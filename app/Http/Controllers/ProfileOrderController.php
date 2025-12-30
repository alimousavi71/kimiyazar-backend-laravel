<?php

namespace App\Http\Controllers;

use App\Services\Order\OrderService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileOrderController extends Controller
{
    public function __construct(
        private readonly OrderService $service
    ) {
    }

    /**
     * Display a listing of the authenticated user's orders.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $user = auth()->user();

        // Filter orders by the authenticated user's ID (member_id)
        // Merge into query parameters for QueryBuilder
        $currentFilters = $request->query('filter', []);
        $currentFilters['member_id'] = $user->id;
        $request->query->set('filter', $currentFilters);

        $orders = $this->service->search(15);

        return view('user.profile.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     *
     * @param string $id
     * @return View
     */
    public function show(string $id): View
    {
        $user = auth()->user();

        $order = $this->service->findById($id);

        // Ensure the order belongs to the authenticated user
        if ($order->member_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('user.profile.orders.show', compact('order'));
    }
}

