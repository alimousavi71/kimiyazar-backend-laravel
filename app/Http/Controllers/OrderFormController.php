<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreRealOrderRequest;
use App\Http\Requests\Order\StoreLegalOrderRequest;
use App\Services\Order\OrderService;
use App\Services\Product\ProductService;
use App\Enums\Database\OrderStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderFormController extends Controller
{
    public function __construct(
        private readonly OrderService $orderService,
        private readonly ProductService $productService
    ) {}

    /**
     * Show the real customer order form.
     */
    public function createReal(string $productSlug): View
    {
        $product = $this->productService->findBySlug($productSlug);

        if (!$product || !$product->is_published) {
            abort(404);
        }

        $user = auth()->user();

        return view('orders.create-real', compact('product', 'user'));
    }

    /**
     * Store a real customer order.
     */
    public function storeReal(StoreRealOrderRequest $request, string $productSlug): RedirectResponse
    {
        $product = $this->productService->findBySlug($productSlug);

        if (!$product || !$product->is_published) {
            abort(404);
        }

        $validated = $request->validated();

        // Handle national_card_photo upload
        if ($request->hasFile('national_card_photo')) {
            $path = $request->file('national_card_photo')->store('orders/national-cards', 'public');
            $validated['national_card_photo'] = $path;
        }

        // Set order metadata
        $validated['customer_type'] = 'real';
        $validated['product_id'] = $product->id;
        $validated['status'] = OrderStatus::PendingPayment->value;
        $validated['is_viewed'] = false;
        $validated['is_registered_service'] = false;
        $validated['is_photo_sent'] = !empty($validated['national_card_photo']);

        // Set member_id if authenticated
        if (auth()->check()) {
            $validated['member_id'] = auth()->id();
        }

        $order = $this->orderService->create($validated);

        return redirect()
            ->route('orders.confirmation', ['orderId' => $order->id])
            ->with('success', __('orders.messages.created'));
    }

    /**
     * Show the legal customer order form.
     */
    public function createLegal(string $productSlug): View
    {
        $product = $this->productService->findBySlug($productSlug);

        if (!$product || !$product->is_published) {
            abort(404);
        }

        $user = auth()->user();

        return view('orders.create-legal', compact('product', 'user'));
    }

    /**
     * Store a legal customer order.
     */
    public function storeLegal(StoreLegalOrderRequest $request, string $productSlug): RedirectResponse
    {
        $product = $this->productService->findBySlug($productSlug);

        if (!$product || !$product->is_published) {
            abort(404);
        }

        $validated = $request->validated();

        // Handle official_gazette_photo upload
        if ($request->hasFile('official_gazette_photo')) {
            $path = $request->file('official_gazette_photo')->store('orders/official-gazettes', 'public');
            $validated['official_gazette_photo'] = $path;
        }

        // Set order metadata
        $validated['customer_type'] = 'legal';
        $validated['product_id'] = $product->id;
        $validated['status'] = OrderStatus::PendingPayment->value;
        $validated['is_viewed'] = false;
        $validated['is_registered_service'] = false;
        $validated['is_photo_sent'] = !empty($validated['official_gazette_photo']);

        // Set member_id if authenticated
        if (auth()->check()) {
            $validated['member_id'] = auth()->id();
        }

        $order = $this->orderService->create($validated);

        return redirect()
            ->route('orders.confirmation', ['orderId' => $order->id])
            ->with('success', __('orders.messages.created'));
    }

    /**
     * Show order confirmation page.
     */
    public function confirmation(string $orderId): View
    {
        $order = $this->orderService->findById($orderId);
        
        if (!$order) {
            abort(404);
        }
        
        // Optional: verify user owns this order if authenticated
        if (auth()->check() && $order->member_id && $order->member_id !== auth()->id()) {
            abort(403);
        }
        
        return view('orders.confirmation', compact('order'));
    }
}
