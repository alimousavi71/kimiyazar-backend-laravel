<?php

namespace App\Repositories\Order;

use App\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Repository implementation for Order model
 */
class OrderRepository implements OrderRepositoryInterface
{
    /**
     * Get all orders with pagination using QueryBuilder.
     *
     * @param array $allowedFilters Allowed filters configuration (Spatie\QueryBuilder\AllowedFilter instances or field names)
     * @param array $allowedSorts   Allowed sorts configuration (field names)
     * @param string|null $defaultSort Default sort (e.g. 'sort_order' or '-created_at'), can be null to skip default sort
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function search(
        array $allowedFilters = [],
        array $allowedSorts = [],
        ?string $defaultSort = null,
        int $perPage = 15
    ): LengthAwarePaginator {
        $query = QueryBuilder::for(Order::class)
            ->with(['country', 'state', 'paymentBank', 'product']);

        if (!empty($allowedFilters)) {
            $query->allowedFilters($allowedFilters);
        }

        if (!empty($allowedSorts)) {
            $query->allowedSorts($allowedSorts);
        }

        if ($defaultSort !== null) {
            $query->defaultSort($defaultSort);
        }

        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Find order by ID.
     *
     * @param int|string $id
     * @return Order|null
     */
    public function findById(int|string $id): ?Order
    {
        return Order::with(['country', 'state', 'paymentBank', 'product'])->find($id);
    }

    /**
     * Find order by ID or fail.
     *
     * @param int|string $id
     * @return Order
     * @throws ModelNotFoundException
     */
    public function findByIdOrFail(int|string $id): Order
    {
        return Order::with(['country', 'state', 'paymentBank', 'product'])->findOrFail($id);
    }

    /**
     * Create a new order.
     *
     * @param array $data
     * @return Order
     */
    public function create(array $data): Order
    {
        return Order::create($data);
    }

    /**
     * Update an existing order.
     *
     * @param int|string $id
     * @param array $data
     * @return Order
     */
    public function update(int|string $id, array $data): Order
    {
        $order = $this->findByIdOrFail($id);
        $order->update($data);

        return $order->fresh();
    }

    /**
     * Delete an order.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        $order = $this->findByIdOrFail($id);

        return $order->delete();
    }

    /**
     * Get all orders for a member.
     *
     * @param int $memberId
     * @return Collection
     */
    public function getByMemberId(int $memberId): Collection
    {
        return Order::where('member_id', $memberId)
            ->with(['country', 'state', 'paymentBank', 'product'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get unviewed orders count.
     *
     * @return int
     */
    public function getUnviewedCount(): int
    {
        return Order::where('is_viewed', false)->count();
    }

    /**
     * Get all orders.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return Order::with(['country', 'state', 'paymentBank', 'product'])->get();
    }
}
