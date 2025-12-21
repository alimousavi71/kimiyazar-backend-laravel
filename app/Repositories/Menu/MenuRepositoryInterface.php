<?php

namespace App\Repositories\Menu;

use App\Models\Menu;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Interface for Menu Repository
 */
interface MenuRepositoryInterface
{
    /**
     * Get all menus with pagination.
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
     * Find menu by ID.
     *
     * @param int|string $id
     * @return Menu|null
     */
    public function findById(int|string $id): ?Menu;

    /**
     * Find menu by ID or fail.
     *
     * @param int|string $id
     * @return Menu
     * @throws ModelNotFoundException
     */
    public function findByIdOrFail(int|string $id): Menu;

    /**
     * Find menu by name.
     *
     * @param string $name
     * @return Menu|null
     */
    public function findByName(string $name): ?Menu;

    /**
     * Create a new menu.
     *
     * @param array $data
     * @return Menu
     */
    public function create(array $data): Menu;

    /**
     * Update a menu.
     *
     * @param int|string $id
     * @param array $data
     * @return Menu
     */
    public function update(int|string $id, array $data): Menu;

    /**
     * Delete a menu.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;

    /**
     * Get all menus.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all(): \Illuminate\Database\Eloquent\Collection;
}
