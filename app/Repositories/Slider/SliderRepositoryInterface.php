<?php

namespace App\Repositories\Slider;

use App\Models\Slider;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Repository interface for Slider model
 */
interface SliderRepositoryInterface
{
    /**
     * Get all sliders with pagination using QueryBuilder.
     *
     * @param array $allowedFilters Allowed filters configuration
     * @param array $allowedSorts Allowed sorts configuration
     * @param string|null $defaultSort Default sort
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
     * Find slider by ID.
     *
     * @param int|string $id
     * @return Slider|null
     */
    public function findById(int|string $id): ?Slider;

    /**
     * Find slider by ID or fail.
     *
     * @param int|string $id
     * @return Slider
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findByIdOrFail(int|string $id): Slider;

    /**
     * Create a new slider.
     *
     * @param array $data
     * @return Slider
     */
    public function create(array $data): Slider;

    /**
     * Update an existing slider.
     *
     * @param int|string $id
     * @param array $data
     * @return Slider
     */
    public function update(int|string $id, array $data): Slider;

    /**
     * Delete a slider.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;
}

