<?php

namespace App\Services\Menu;

use App\Models\Menu;
use App\Repositories\Menu\MenuRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * Service class for Menu business logic
 */
class MenuService
{
    /**
     * @param MenuRepositoryInterface $repository
     */
    public function __construct(
        private readonly MenuRepositoryInterface $repository
    ) {
    }

    /**
     * Get all menus with optional filters using QueryBuilder.
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function search(int $perPage = 15): LengthAwarePaginator
    {
        $allowedFilters = [
            AllowedFilter::partial('name'),
            AllowedFilter::callback('search', function ($query, $value) {
                $query->where('name', 'like', "%{$value}%");
            }),
        ];

        $allowedSorts = [
            'id',
            'name',
            'created_at',
            'updated_at',
        ];

        $defaultSort = '-created_at';

        return $this->repository->search($allowedFilters, $allowedSorts, $defaultSort, $perPage);
    }

    /**
     * Find menu by ID.
     *
     * @param int|string $id
     * @return Menu
     * @throws ModelNotFoundException
     */
    public function findById(int|string $id): Menu
    {
        return $this->repository->findByIdOrFail($id);
    }

    /**
     * Find menu by name.
     *
     * @param string $name
     * @return Menu|null
     */
    public function findByName(string $name): ?Menu
    {
        return $this->repository->findByName($name);
    }

    /**
     * Create a new menu.
     *
     * @param array $data
     * @return Menu
     */
    public function create(array $data): Menu
    {
        // Ensure links is an array
        if (isset($data['links']) && is_string($data['links'])) {
            $data['links'] = json_decode($data['links'], true);
        }

        if (!isset($data['links']) || !is_array($data['links'])) {
            $data['links'] = [];
        }

        return $this->repository->create($data);
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
        // Ensure links is an array
        if (isset($data['links']) && is_string($data['links'])) {
            $data['links'] = json_decode($data['links'], true);
        }

        return $this->repository->update($id, $data);
    }

    /**
     * Delete a menu.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        return $this->repository->delete($id);
    }

    /**
     * Update menu links.
     *
     * @param int|string $id
     * @param array $links
     * @return Menu
     */
    public function updateLinks(int|string $id, array $links): Menu
    {
        // Ensure each link has required fields and order
        $processedLinks = [];
        foreach ($links as $index => $link) {
            if (empty($link['title'])) {
                continue;
            }

            $processedLinks[] = [
                'id' => $link['id'] ?? uniqid('link_'),
                'title' => $link['title'],
                'url' => $link['url'] ?? '#',
                'type' => $link['type'] ?? 'custom',
                'content_id' => $link['content_id'] ?? null,
                'order' => $link['order'] ?? ($index + 1),
            ];
        }

        // Sort by order
        usort($processedLinks, fn($a, $b) => $a['order'] <=> $b['order']);

        return $this->repository->update($id, ['links' => $processedLinks]);
    }

    /**
     * Get all menus.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->repository->all();
    }
}
