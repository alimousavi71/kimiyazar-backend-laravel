<?php

namespace App\Repositories\Content;

use App\Models\Content;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Repository implementation for Content model
 */
class ContentRepository implements ContentRepositoryInterface
{
    /**
     * Get all contents with pagination using QueryBuilder.
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
        $query = QueryBuilder::for(Content::class);

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
     * Find content by ID.
     *
     * @param int|string $id
     * @return Content|null
     */
    public function findById(int|string $id): ?Content
    {
        return Content::find($id);
    }

    /**
     * Find content by ID or fail.
     *
     * @param int|string $id
     * @return Content
     * @throws ModelNotFoundException
     */
    public function findByIdOrFail(int|string $id): Content
    {
        return Content::findOrFail($id);
    }

    /**
     * Create a new content.
     *
     * @param array $data
     * @return Content
     */
    public function create(array $data): Content
    {
        return Content::create($data);
    }

    /**
     * Update an existing content.
     *
     * @param int|string $id
     * @param array $data
     * @return Content
     */
    public function update(int|string $id, array $data): Content
    {
        $content = $this->findByIdOrFail($id);
        $content->update($data);

        return $content->fresh();
    }

    /**
     * Delete a content.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        $content = $this->findByIdOrFail($id);

        return $content->delete();
    }

    /**
     * Find active content by type and slug.
     *
     * @param \App\Enums\Database\ContentType $type
     * @param string $slug
     * @return Content|null
     */
    public function findActiveByTypeAndSlug(\App\Enums\Database\ContentType $type, string $slug): ?Content
    {
        return Content::where('type', $type)
            ->where('slug', $slug)
            ->where('is_active', true)
            ->first();
    }
}

