<?php

namespace App\Repositories\Tag;

use App\Enums\Database\ContentType;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface for Tag Repository
 */
interface TagRepositoryInterface
{
    /**
     * Search tags by query string.
     *
     * @param string $query
     * @param int $limit
     * @return Collection
     */
    public function search(string $query = '', int $limit = 20): Collection;

    /**
     * Find tag by title (case-insensitive).
     *
     * @param string $title
     * @return Tag|null
     */
    public function findByTitle(string $title): ?Tag;

    /**
     * Create a new tag.
     *
     * @param array $data
     * @return Tag
     */
    public function create(array $data): Tag;

    /**
     * Get tags by content type with filtering.
     * Filters tags that are associated with active contents of the specified type.
     *
     * @param ContentType $contentType
     * @param int $limit
     * @return Collection
     */
    public function getTagsByContentType(ContentType $contentType, int $limit = 20): Collection;

    /**
     * Get tagables by tagable entity.
     *
     * @param string $tagableType
     * @param int|string $tagableId
     * @return Collection
     */
    public function getTagablesByTagable(string $tagableType, int|string $tagableId): Collection;

    /**
     * Delete tagables by tagable entity.
     *
     * @param string $tagableType
     * @param int|string $tagableId
     * @return bool
     */
    public function deleteTagablesByTagable(string $tagableType, int|string $tagableId): bool;

    /**
     * Create a tagable.
     *
     * @param array $data
     * @return \App\Models\Tagable
     */
    public function createTagable(array $data): \App\Models\Tagable;

    /**
     * Delete tagables by tagable entity and tag ID.
     *
     * @param string $tagableType
     * @param int|string $tagableId
     * @param int|string $tagId
     * @return bool
     */
    public function deleteTagableByTagableAndTag(string $tagableType, int|string $tagableId, int|string $tagId): bool;

    /**
     * Find tagable by ID and tag ID.
     *
     * @param int|string $tagableId
     * @param int|string $tagId
     * @return \App\Models\Tagable|null
     */
    public function findTagableByIdAndTagId(int|string $tagableId, int|string $tagId): ?\App\Models\Tagable;

    /**
     * Find tag by slug.
     *
     * @param string $slug
     * @return Tag|null
     */
    public function findBySlug(string $slug): ?Tag;

    /**
     * Get paginated entities (contents) by tag slug with search.
     *
     * @param string $tagSlug
     * @param int $perPage
     * @param string|null $search
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginatedEntitiesByTagSlug(string $tagSlug, int $perPage = 50, ?string $search = null): \Illuminate\Contracts\Pagination\LengthAwarePaginator;

    /**
     * Get related tags that are used with the same contents as the given tag.
     *
     * @param int $tagId
     * @param array $contentIds
     * @param int $limit
     * @return Collection
     */
    public function getRelatedTags(int $tagId, array $contentIds, int $limit = 10): Collection;
}
