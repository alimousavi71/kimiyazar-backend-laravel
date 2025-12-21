<?php

namespace App\Repositories\Content;

use App\Models\Content;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Interface for Content Repository
 */
interface ContentRepositoryInterface
{
    /**
     * Get all contents with pagination.
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
     * Find content by ID.
     *
     * @param int|string $id
     * @return Content|null
     */
    public function findById(int|string $id): ?Content;

    /**
     * Find content by ID or fail.
     *
     * @param int|string $id
     * @return Content
     * @throws ModelNotFoundException
     */
    public function findByIdOrFail(int|string $id): Content;

    /**
     * Create a new content.
     *
     * @param array $data
     * @return Content
     */
    public function create(array $data): Content;

    /**
     * Update an existing content.
     *
     * @param int|string $id
     * @param array $data
     * @return Content
     */
    public function update(int|string $id, array $data): Content;

    /**
     * Delete a content.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;

    /**
     * Find active content by type and slug.
     *
     * @param \App\Enums\Database\ContentType $type
     * @param string $slug
     * @return Content|null
     */
    public function findActiveByTypeAndSlug(\App\Enums\Database\ContentType $type, string $slug): ?Content;
}

