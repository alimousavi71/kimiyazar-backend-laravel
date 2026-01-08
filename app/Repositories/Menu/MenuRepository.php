<?php

namespace App\Repositories\Menu;

use App\Models\Menu;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Repository implementation for Menu model
 */
class MenuRepository implements MenuRepositoryInterface
{
    /**
     * Get all menus with pagination using QueryBuilder.
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
    ): LengthAwarePaginator {
        $query = Menu::query();

        $queryBuilder = QueryBuilder::for($query)
            ->allowedFilters($allowedFilters)
            ->allowedSorts($allowedSorts);

        if ($defaultSort) {
            $queryBuilder->defaultSort($defaultSort);
        }

        return $queryBuilder->paginate($perPage)->withQueryString();
    }

    /**
     * Find menu by ID.
     *
     * @param int|string $id
     * @return Menu|null
     */
    public function findById(int|string $id): ?Menu
    {
        return Menu::find($id);
    }

    /**
     * Find menu by ID or fail.
     *
     * @param int|string $id
     * @return Menu
     * @throws ModelNotFoundException
     */
    public function findByIdOrFail(int|string $id): Menu
    {
        return Menu::findOrFail($id);
    }

    /**
     * Find menu by name.
     *
     * @param string $name
     * @return Menu|null
     */
    public function findByName(string $name): ?Menu
    {
        return Menu::where('name', $name)->first();
    }

    /**
     * Create a new menu.
     *
     * @param array $data
     * @return Menu
     */
    public function create(array $data): Menu
    {
        return Menu::create($data);
    }

    /**
     * Update a menu.
     *
     * @param int|string $id
     * @param array $data
     * @return Menu
     */
    public function update(int|string $id, array $data): Menu
    {
        $menu = $this->findByIdOrFail($id);
        $menu->update($data);
        return $menu->fresh();
    }

    /**
     * Delete a menu.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        $menu = $this->findByIdOrFail($id);
        return $menu->delete();
    }

    /**
     * Get all menus.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return Menu::all();
    }
}
