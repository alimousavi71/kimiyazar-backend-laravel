<?php

namespace App\Services\PriceInquiry;

use App\Models\PriceInquiry;
use App\Repositories\PriceInquiry\PriceInquiryRepositoryInterface;
use App\Services\Product\ProductService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\AllowedFilter;

class PriceInquiryService
{
    public function __construct(
        private readonly PriceInquiryRepositoryInterface $repository,
        private readonly ProductService $productService
    ) {
    }

    /**
     * Search price inquiries with filters and sorting.
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function search(int $perPage = 15): LengthAwarePaginator
    {
        $allowedFilters = [
            AllowedFilter::partial('first_name'),
            AllowedFilter::partial('last_name'),
            AllowedFilter::partial('email'),
            AllowedFilter::partial('phone_number'),
            AllowedFilter::exact('is_reviewed'),
            AllowedFilter::exact('user_id'),
            AllowedFilter::callback('search', function ($query, $value) {
                $query->where(function ($q) use ($value) {
                    $q->where('first_name', 'like', "%{$value}%")
                        ->orWhere('last_name', 'like', "%{$value}%")
                        ->orWhere('email', 'like', "%{$value}%")
                        ->orWhere('phone_number', 'like', "%{$value}%");
                });
            }),
        ];

        $allowedSorts = [
            'id',
            'first_name',
            'last_name',
            'email',
            'phone_number',
            'is_reviewed',
            'user_id',
            'created_at',
            'updated_at',
        ];

        $defaultSort = '-created_at';

        return $this->repository->search($allowedFilters, $allowedSorts, $defaultSort, $perPage);
    }

    /**
     * Find price inquiry by ID.
     *
     * @param int|string $id
     * @return PriceInquiry
     */
    public function findById(int|string $id): PriceInquiry
    {
        return $this->repository->findByIdOrFail($id);
    }

    /**
     * Create a new price inquiry.
     *
     * @param array $data
     * @return PriceInquiry
     */
    public function create(array $data): PriceInquiry
    {
        // If user is authenticated, set user_id
        if (auth()->check() && !isset($data['user_id'])) {
            $data['user_id'] = auth()->id();
        }

        // Ensure products is an array of product IDs: [1, 2, 3]
        if (isset($data['products'])) {
            if (is_string($data['products'])) {
                $data['products'] = json_decode($data['products'], true);
            }
            // Store as simple array of IDs
            $data['products'] = array_values(array_filter(array_map('intval', $data['products'])));
        }

        // Ensure is_reviewed defaults to false
        if (!isset($data['is_reviewed'])) {
            $data['is_reviewed'] = false;
        }

        return $this->repository->create($data);
    }

    /**
     * Update price inquiry.
     *
     * @param int|string $id
     * @param array $data
     * @return PriceInquiry
     */
    public function update(int|string $id, array $data): PriceInquiry
    {
        // Handle products if it's a string
        if (isset($data['products']) && is_string($data['products'])) {
            $data['products'] = json_decode($data['products'], true);
        }

        // Handle is_reviewed boolean conversion
        if (isset($data['is_reviewed']) && is_bool($data['is_reviewed'])) {
            $data['is_reviewed'] = $data['is_reviewed'] ? 1 : 0;
        }

        return $this->repository->update($id, $data);
    }

    /**
     * Delete price inquiry.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        return $this->repository->delete($id);
    }

    /**
     * Toggle review status.
     *
     * @param int|string $id
     * @return PriceInquiry
     */
    public function toggleReviewStatus(int|string $id): PriceInquiry
    {
        $priceInquiry = $this->repository->findByIdOrFail($id);
        $priceInquiry->update(['is_reviewed' => !$priceInquiry->is_reviewed]);

        return $priceInquiry->fresh();
    }

    /**
     * Get products for a price inquiry.
     *
     * @param PriceInquiry $priceInquiry
     * @return Collection
     */
    public function getProducts(PriceInquiry $priceInquiry): Collection
    {
        if (empty($priceInquiry->products) || !is_array($priceInquiry->products)) {
            return new Collection();
        }

        $productIds = array_filter(array_map('intval', $priceInquiry->products));

        if (empty($productIds)) {
            return new Collection();
        }

        return $this->productService->findByIds($productIds);
    }
}
