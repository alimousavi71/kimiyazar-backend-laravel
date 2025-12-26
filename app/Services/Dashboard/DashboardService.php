<?php

namespace App\Services\Dashboard;

use App\Enums\Database\OrderStatus;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * Service class for Dashboard business logic
 */
class DashboardService
{
    /**
     * Get dashboard statistics.
     *
     * @return array
     */
    public function getStats(): array
    {
        return [
            'totalUsers' => User::count(),
            'totalOrders' => Order::count(),
            'totalProducts' => Product::count(),
            'totalCategories' => Category::count(),
            'pendingOrders' => Order::where('status', OrderStatus::PendingPayment->value)->count(),
            'paidOrders' => Order::where('status', OrderStatus::Paid->value)->count(),
            'unviewedOrders' => Order::where('is_viewed', false)->count(),
        ];
    }

    /**
     * Get recent orders with eager loaded relationships.
     *
     * @param int $limit
     * @return Collection
     */
    public function getRecentOrders(int $limit = 5): Collection
    {
        return Order::with(['product'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get all dashboard data.
     *
     * @return array
     */
    public function getDashboardData(): array
    {
        return [
            ...$this->getStats(),
            'recentOrders' => $this->getRecentOrders(),
        ];
    }

    /**
     * Format recent orders for view display.
     *
     * @param Collection $orders
     * @return Collection
     */
    public function formatRecentOrders(Collection $orders): Collection
    {
        return $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'customer' => $order->customer_type === 'real' ? $order->full_name : $order->company_name,
                'initials' => $this->getInitials($order),
                'product' => $order->product?->name ?? 'Product',
                'time' => Carbon::createFromTimestamp($order->created_at)->diffForHumans(),
                'status' => $order->status,
                'statusColor' => $this->getStatusColor($order->status),
                'statusBadge' => $this->getStatusBadgeVariant($order->status),
                'order' => $order,
            ];
        });
    }

    /**
     * Get initials from customer name.
     *
     * @param Order $order
     * @return string
     */
    private function getInitials(Order $order): string
    {
        $name = $order->customer_type === 'real' ? $order->full_name : $order->company_name;
        $parts = explode(' ', trim($name));
        $first = substr($parts[0] ?? '', 0, 1);
        $second = substr($parts[1] ?? $parts[0] ?? '', 0, 1);

        return strtoupper($first . $second);
    }

    /**
     * Get color for order status.
     *
     * @param string $status
     * @return string
     */
    private function getStatusColor(string $status): string
    {
        return match ($status) {
            'pending_payment' => 'orange',
            'paid' => 'emerald',
            'processing' => 'blue',
            'shipped' => 'purple',
            'delivered' => 'green',
            'cancelled' => 'red',
            'returned' => 'yellow',
            default => 'gray',
        };
    }

    /**
     * Get badge variant for order status.
     *
     * @param string $status
     * @return string
     */
    private function getStatusBadgeVariant(string $status): string
    {
        return match ($status) {
            'pending_payment' => 'warning',
            'paid' => 'success',
            'processing' => 'info',
            'shipped' => 'info',
            'delivered' => 'success',
            'cancelled' => 'danger',
            'returned' => 'warning',
            default => 'secondary',
        };
    }
}
