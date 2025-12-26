<?php

namespace App\Repositories\Order;

use App\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Interface for Order Repository
 */
interface OrderRepositoryInterface
{
    /**
     * Get all orders with pagination.
     *
     * @param array $allowedFilters
     * @param array $allowedSorts
     * @param string|null $defaultSort
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function search(
        array $allowedFilters = [],
        array $allowedSorts = [],
        ?string $defaultSort = null,
        int $perPage = 15
    ): LengthAwarePaginator;

    /**
     * Find order by ID.
     *
     * @param int|string $id
     * @return Order|null
     */
    public function findById(int|string $id): ?Order;

    /**
     * Find order by ID or fail.
     *
     * @param int|string $id
     * @return Order
     * @throws ModelNotFoundException
     */
    public function findByIdOrFail(int|string $id): Order;

    /**
     * Create a new order.
     *
     * @param array $data
     * @return Order
     */
    public function create(array $data): Order;

    /**
     * Update an existing order.
     *
     * @param int|string $id
     * @param array $data
     * @return Order
     */
    public function update(int|string $id, array $data): Order;

    /**
     * Delete an order.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;

    /**
     * Get all orders for a member.
     *
     * @param int $memberId
     * @return Collection
     */
    public function getByMemberId(int $memberId): Collection;

    /**
     * Get unviewed orders count.
     *
     * @return int
     */
    public function getUnviewedCount(): int;

    /**
     * Get all orders.
     *
     * @return Collection
     */
    public function all(): Collection;
}
