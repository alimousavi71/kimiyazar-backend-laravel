<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreProductRequest;
use App\Http\Requests\Admin\Product\UpdateProductRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Services\Category\CategoryService;
use App\Services\Product\ProductService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    use ApiResponseTrait;

    /**
     * @param ProductService $service
     * @param CategoryService $categoryService
     */
    public function __construct(
        private readonly ProductService $service,
        private readonly CategoryService $categoryService
    ) {
    }

    /**
     * Display a listing of the products.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $products = $this->service->search();
        $categories = $this->categoryService->getAllCategoriesTree();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new product.
     *
     * @return View
     */
    public function create(): View
    {
        $categories = $this->categoryService->getAllCategoriesTree();

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     *
     * @param StoreProductRequest $request
     * @return RedirectResponse
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $this->service->create($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', __('admin/products.messages.created'));
    }

    /**
     * Display the specified product.
     *
     * @param string $id
     * @return View
     */
    public function show(string $id): View
    {
        $product = $this->service->findById($id);

        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param string $id
     * @return View
     */
    public function edit(string $id): View
    {
        $product = $this->service->findById($id);
        $categories = $this->categoryService->getAllCategoriesTree();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     *
     * @param UpdateProductRequest $request
     * @param string $id
     * @return RedirectResponse
     */
    public function update(UpdateProductRequest $request, string $id): RedirectResponse
    {
        $validated = $request->validated();

        $this->service->update($id, $validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', __('admin/products.messages.updated'));
    }

    /**
     * Update the sort order of the specified product.
     *
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function updateSortOrder(Request $request, string $id): JsonResponse
    {
        try {
            $request->validate([
                'sort_order' => ['required', 'integer', 'min:0'],
            ]);

            $product = $this->service->findById($id);
            $product->update(['sort_order' => $request->input('sort_order')]);

            return $this->successResponse(
                ['product' => $product->fresh()],
                __('admin/products.messages.sort_order_updated')
            );
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse(__('admin/products.messages.not_found'));
        } catch (Exception $e) {
            return $this->errorResponse(
                __('admin/products.messages.sort_order_update_failed') . ': ' . $e->getMessage(),
                500
            );
        }
    }

    /**
     * Remove the specified product from storage.
     *
     * @param Request $request
     * @param string $id
     * @return JsonResponse|RedirectResponse
     */
    public function destroy(Request $request, string $id): JsonResponse|RedirectResponse
    {
        try {
            $this->service->delete($id);

            if ($request->expectsJson() || $request->wantsJson()) {
                return $this->successResponse(null, __('admin/products.messages.deleted'));
            }

            return redirect()
                ->route('admin.products.index')
                ->with('success', __('admin/products.messages.deleted'));
        } catch (ModelNotFoundException $e) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return $this->notFoundResponse(__('admin/products.messages.not_found'));
            }
            return redirect()
                ->route('admin.products.index')
                ->with('error', __('admin/products.messages.not_found'));
        } catch (Exception $e) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return $this->errorResponse(__('admin/products.messages.delete_failed') . ': ' . $e->getMessage(), 500);
            }
            return redirect()
                ->route('admin.products.index')
                ->with('error', __('admin/products.messages.delete_failed'));
        }
    }
}
