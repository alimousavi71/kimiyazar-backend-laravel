<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Order\StoreOrderRequest;
use App\Http\Requests\Admin\Order\UpdateOrderRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Services\Order\OrderService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    use ApiResponseTrait;

    /**
     * @param OrderService $service
     */
    public function __construct(
        private readonly OrderService $service
    ) {
    }

    /**
     * Display a listing of the orders.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $orders = $this->service->search();

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new order.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.orders.create');
    }

    /**
     * Store a newly created order in storage.
     *
     * @param StoreOrderRequest $request
     * @return RedirectResponse
     */
    public function store(StoreOrderRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $this->service->create($validated);

        return redirect()
            ->route('admin.orders.index')
            ->with('success', __('admin/orders.messages.created'));
    }

    /**
     * Display the specified order.
     *
     * @param string $id
     * @return View
     */
    public function show(string $id): View
    {
        $order = $this->service->findById($id);
        $this->service->markAsViewed($id);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified order.
     *
     * @param string $id
     * @return View
     */
    public function edit(string $id): View
    {
        $order = $this->service->findById($id);

        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update the specified order in storage.
     *
     * @param UpdateOrderRequest $request
     * @param string $id
     * @return RedirectResponse
     */
    public function update(UpdateOrderRequest $request, string $id): RedirectResponse
    {
        $validated = $request->validated();

        $this->service->update($id, $validated);

        return redirect()
            ->route('admin.orders.index')
            ->with('success', __('admin/orders.messages.updated'));
    }

    /**
     * Remove the specified order from storage.
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
                return $this->successResponse(null, __('admin/orders.messages.deleted'));
            }

            return redirect()
                ->route('admin.orders.index')
                ->with('success', __('admin/orders.messages.deleted'));
        } catch (ModelNotFoundException $e) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return $this->notFoundResponse(__('admin/orders.messages.not_found'));
            }
            return redirect()
                ->route('admin.orders.index')
                ->with('error', __('admin/orders.messages.not_found'));
        } catch (Exception $e) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return $this->errorResponse(__('admin/orders.messages.delete_failed') . ': ' . $e->getMessage(), 500);
            }
            return redirect()
                ->route('admin.orders.index')
                ->with('error', __('admin/orders.messages.delete_failed'));
        }
    }
}
