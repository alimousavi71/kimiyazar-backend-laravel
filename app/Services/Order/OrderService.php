<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Repositories\Order\OrderRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * Service class for Order business logic
 */
class OrderService
{
    /**
     * @param OrderRepositoryInterface $repository
     */
    public function __construct(
        private readonly OrderRepositoryInterface $repository
    ) {
    }

    /**
     * Get all orders with optional filters using QueryBuilder.
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function search(int $perPage = 15): LengthAwarePaginator
    {
        $allowedFilters = [
            AllowedFilter::partial('full_name'),
            AllowedFilter::partial('company_name'),
            AllowedFilter::partial('national_code'),
            AllowedFilter::partial('economic_code'),
            AllowedFilter::exact('customer_type'),
            AllowedFilter::exact('status'),
            AllowedFilter::exact('payment_type'),
            AllowedFilter::exact('is_viewed'),
            AllowedFilter::callback('search', function ($query, $value) {
                $query->where(function ($q) use ($value) {
                    $q->where('full_name', 'like', "%{$value}%")
                        ->orWhere('company_name', 'like', "%{$value}%")
                        ->orWhere('national_code', 'like', "%{$value}%")
                        ->orWhere('economic_code', 'like', "%{$value}%")
                        ->orWhere('email', 'like', "%{$value}%")
                        ->orWhere('phone', 'like', "%{$value}%");
                });
            }),
        ];

        $allowedSorts = [
            'id',
            'customer_type',
            'status',
            'payment_type',
            'is_viewed',
            'created_at',
        ];

        $defaultSort = '-id';

        return $this->repository->search($allowedFilters, $allowedSorts, $defaultSort, $perPage);
    }

    /**
     * Find order by ID.
     *
     * @param int|string $id
     * @return Order
     * @throws ModelNotFoundException
     */
    public function findById(int|string $id): Order
    {
        return $this->repository->findByIdOrFail($id);
    }

    /**
     * Create a new order.
     *
     * @param array $data
     * @return Order
     */
    public function create(array $data): Order
    {
        // Set timestamp if not provided
        if (!isset($data['created_at'])) {
            $data['created_at'] = time();
        }

        return $this->repository->create($data);
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
        return $this->repository->update($id, $data);
    }

    /**
     * Delete an order.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        return $this->repository->delete($id);
    }

    /**
     * Get all orders for a member.
     *
     * @param int $memberId
     * @return Collection
     */
    public function getByMemberId(int $memberId): Collection
    {
        return $this->repository->getByMemberId($memberId);
    }

    /**
     * Get unviewed orders count.
     *
     * @return int
     */
    public function getUnviewedCount(): int
    {
        return $this->repository->getUnviewedCount();
    }

    /**
     * Mark an order as viewed.
     *
     * @param int|string $id
     * @return Order
     */
    public function markAsViewed(int|string $id): Order
    {
        return $this->repository->update($id, ['is_viewed' => true]);
    }

    /**
     * Get all orders.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->repository->all();
    }
}
