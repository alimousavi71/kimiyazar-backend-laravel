<?php

namespace App\Repositories\Slider;

use App\Models\Slider;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Repository implementation for Slider model
 */
class SliderRepository implements SliderRepositoryInterface
{
    /**
     * Get all sliders with pagination using QueryBuilder.
     *
     * @param array $allowedFilters Allowed filters configuration
     * @param array $allowedSorts   Allowed sorts configuration
     * @param string|null $defaultSort Default sort
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function search(
        array $allowedFilters = [],
        array $allowedSorts = [],
        ?string $defaultSort = null,
        int $perPage = 15
    ): LengthAwarePaginator {
        $query = QueryBuilder::for(Slider::class);

        if (!empty($allowedFilters)) {
            $query->allowedFilters($allowedFilters);
        }

        if (!empty($allowedSorts)) {
            $query->allowedSorts($allowedSorts);
        }

        if ($defaultSort !== null) {
            $query->defaultSort($defaultSort);
        }

        return $query->paginate($perPage);
    }

    /**
     * Find slider by ID.
     *
     * @param int|string $id
     * @return Slider|null
     */
    public function findById(int|string $id): ?Slider
    {
        return Slider::find($id);
    }

    /**
     * Find slider by ID or fail.
     *
     * @param int|string $id
     * @return Slider
     * @throws ModelNotFoundException
     */
    public function findByIdOrFail(int|string $id): Slider
    {
        return Slider::findOrFail($id);
    }

    /**
     * Create a new slider.
     *
     * @param array $data
     * @return Slider
     */
    public function create(array $data): Slider
    {
        return Slider::create($data);
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
        $slider = $this->findByIdOrFail($id);
        $slider->update($data);

        return $slider->fresh();
    }

    /**
     * Delete a slider.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        $slider = $this->findByIdOrFail($id);

        return $slider->delete();
    }
}

