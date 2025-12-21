<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\StoreCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Services\Category\CategoryService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    use ApiResponseTrait;

    /**
     * @param CategoryService $service
     */
    public function __construct(
        private readonly CategoryService $service
    ) {
    }

    /**
     * Display a listing of the categories.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $categories = $this->service->search();
        $rootCategories = $this->service->getRootCategories();

        return view('admin.categories.index', compact('categories', 'rootCategories'));
    }

    /**
     * Show the form for creating a new category.
     *
     * @return View
     */
    public function create(): View
    {
        $categories = $this->service->getAllCategoriesTree();

        return view('admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created category in storage.
     *
     * @param StoreCategoryRequest $request
     * @return RedirectResponse
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $this->service->create($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', __('admin/categories.messages.created'));
    }

    /**
     * Display the specified category.
     *
     * @param string $id
     * @return View
     */
    public function show(string $id): View
    {
        $category = $this->service->findById($id);

        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param string $id
     * @return View
     */
    public function edit(string $id): View
    {
        $category = $this->service->findById($id);
        // Exclude current category and all its descendants to prevent circular references
        $categories = $this->service->getAllCategoriesTree($category->id);

        return view('admin.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified category in storage.
     *
     * @param UpdateCategoryRequest $request
     * @param string $id
     * @return RedirectResponse
     */
    public function update(UpdateCategoryRequest $request, string $id): RedirectResponse
    {
        $validated = $request->validated();

        $this->service->update($id, $validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', __('admin/categories.messages.updated'));
    }

    /**
     * Remove the specified category from storage.
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
                return $this->successResponse(null, __('admin/categories.messages.deleted'));
            }

            return redirect()
                ->route('admin.categories.index')
                ->with('success', __('admin/categories.messages.deleted'));
        } catch (ModelNotFoundException $e) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return $this->notFoundResponse(__('admin/categories.messages.not_found'));
            }
            return redirect()
                ->route('admin.categories.index')
                ->with('error', __('admin/categories.messages.not_found'));
        } catch (Exception $e) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return $this->errorResponse(__('admin/categories.messages.delete_failed') . ': ' . $e->getMessage(), 500);
            }
            return redirect()
                ->route('admin.categories.index')
                ->with('error', __('admin/categories.messages.delete_failed'));
        }
    }
}
