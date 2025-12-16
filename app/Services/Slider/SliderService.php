<?php

namespace App\Services\Slider;

use App\Models\Slider;
use App\Repositories\Slider\SliderRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * Service class for Slider business logic
 */
class SliderService
{
    /**
     * @param SliderRepositoryInterface $repository
     */
    public function __construct(
        private readonly SliderRepositoryInterface $repository
    ) {
    }

    /**
     * Get all sliders with optional filters using QueryBuilder.
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function search(int $perPage = 15): LengthAwarePaginator
    {
        $allowedFilters = [
            AllowedFilter::partial('title'),
            AllowedFilter::partial('heading'),
            AllowedFilter::partial('description'),
            AllowedFilter::exact('is_active'),
            AllowedFilter::callback('search', function ($query, $value) {
                $query->where(function ($q) use ($value) {
                    $q->where('title', 'like', "%{$value}%")
                        ->orWhere('heading', 'like', "%{$value}%")
                        ->orWhere('description', 'like', "%{$value}%");
                });
            }),
        ];

        $allowedSorts = [
            'id',
            'title',
            'heading',
            'is_active',
            'sort_order',
            'created_at',
            'updated_at',
        ];

        $defaultSort = 'sort_order';

        return $this->repository->search($allowedFilters, $allowedSorts, $defaultSort, $perPage);
    }

    /**
     * Find slider by ID.
     *
     * @param int|string $id
     * @return Slider
     * @throws ModelNotFoundException
     */
    public function findById(int|string $id): Slider
    {
        return $this->repository->findByIdOrFail($id);
    }

    /**
     * Create a new slider.
     *
     * @param array $data
     * @return Slider
     */
    public function create(array $data): Slider
    {
        // Handle boolean fields
        if (isset($data['is_active']) && is_bool($data['is_active'])) {
            $data['is_active'] = $data['is_active'] ? 1 : 0;
        }

        // Set default sort order if not provided
        if (!isset($data['sort_order'])) {
            $maxOrder = Slider::max('sort_order') ?? 0;
            $data['sort_order'] = $maxOrder + 1;
        }

        return $this->repository->create($data);
    }

    /**
     * Update an existing slider.
     *
     * @param int|string $id
     * @param array $data
     * @return Slider
     */
    public function update(int|string $id, array $data): Slider
    {
        // Handle boolean fields
        if (isset($data['is_active']) && is_bool($data['is_active'])) {
            $data['is_active'] = $data['is_active'] ? 1 : 0;
        }

        return $this->repository->update($id, $data);
    }

    /**
     * Delete a slider.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        return $this->repository->delete($id);
    }
}

