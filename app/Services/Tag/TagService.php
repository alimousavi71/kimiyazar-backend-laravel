<?php

namespace App\Services\Tag;

use App\Enums\Database\ContentType;
use App\Models\Tag;
use App\Repositories\Tag\TagRepositoryInterface;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

/**
 * Service class for Tag business logic
 */
class TagService
{
    /**
     * @param TagRepositoryInterface $repository
     */
    public function __construct(
        private readonly TagRepositoryInterface $repository
    ) {
    }
    /**
     * Search tags by query string.
     *
     * @param string $query
     * @param int $limit
     * @return Collection
     */
    public function search(string $query = '', int $limit = 20): Collection
    {
        return $this->repository->search($query, $limit);
    }

    /**
     * Get tags by tagable entity.
     *
     * @param string $tagableType
     * @param int|string $tagableId
     * @return Collection
     */
    public function getByTagable(string $tagableType, int|string $tagableId): Collection
    {
        $normalizedType = $this->normalizeTagableType($tagableType);
        $tagables = $this->repository->getTagablesByTagable($normalizedType, $tagableId);

        return $tagables->map(function ($tagable) {
            return [
                'id' => $tagable->tag->id,
                'tag_id' => $tagable->tag_id,
                'title' => $tagable->tag->title,
                'slug' => $tagable->tag->slug,
                'tagable_id' => $tagable->id,
            ];
        });
    }

    /**
     * Create or find a tag by title.
     *
     * @param string $title
     * @return Tag
     */
    public function createOrFind(string $title): Tag
    {
        $title = trim($title);

        // Try to find by title (case-insensitive)
        $tag = $this->repository->findByTitle($title);

        if ($tag) {
            return $tag;
        }

        // Create new tag - HasPersianSlug trait will auto-generate slug
        return $this->repository->create(['title' => $title]);
    }

    /**
     * Attach tags to a tagable entity.
     *
     * @param string $tagableType
     * @param int|string $tagableId
     * @param array $tagData Array of ['tag_id' => id]
     * @return void
     */
    public function attachToTagable(string $tagableType, int|string $tagableId, array $tagData): void
    {
        // Normalize tagable_type to ensure consistency
        $normalizedType = $this->normalizeTagableType($tagableType);

        // First, detach all existing tags
        $this->repository->deleteTagablesByTagable($normalizedType, $tagableId);

        // Then attach new tags
        foreach ($tagData as $data) {
            $this->repository->createTagable([
                'tag_id' => $data['tag_id'],
                'tagable_type' => $normalizedType,
                'tagable_id' => $tagableId,
            ]);
        }
    }

    /**
     * Normalize tagable type format.
     * Converts AppModelsProduct to App\Models\Product
     *
     * @param string $type
     * @return string
     */
    private function normalizeTagableType(string $type): string
    {
        // If it already has backslashes, return as is
        if (str_contains($type, '\\')) {
            return $type;
        }

        // Convert AppModelsX to App\Models\X
        if (preg_match('/^AppModels(.+)$/', $type, $matches)) {
            return 'App\Models\\' . $matches[1];
        }

        // If no match, return original
        return $type;
    }

    /**
     * Detach a tag from a tagable entity.
     *
     * @param string $tagableType
     * @param int|string $tagableId
     * @param int|string $tagId
     * @return bool
     */
    public function detachFromTagable(string $tagableType, int|string $tagableId, int|string $tagId): bool
    {
        $normalizedType = $this->normalizeTagableType($tagableType);
        return $this->repository->deleteTagableByTagableAndTag($normalizedType, $tagableId, $tagId);
    }


    /**
     * Get tags by content type with filtering.
     * Filters tags that are associated with active contents of the specified type.
     *
     * @param ContentType $contentType
     * @param int $limit
     * @return Collection
     */
    public function getTagsByContentType(ContentType $contentType, int $limit = 20): Collection
    {
        return $this->repository->getTagsByContentType($contentType, $limit);
    }

    /**
     * Find tag by slug.
     *
     * @param string $slug
     * @return Tag|null
     */
    public function findBySlug(string $slug): ?Tag
    {
        return $this->repository->findBySlug($slug);
    }

    /**
     * Get paginated entities (contents) by tag slug with search.
     *
     * @param string $tagSlug
     * @param int $perPage
     * @param string|null $search
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginatedEntitiesByTagSlug(string $tagSlug, int $perPage = 50, ?string $search = null): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->repository->getPaginatedEntitiesByTagSlug($tagSlug, $perPage, $search);
    }

    /**
     * Get related tags that are used with the same contents as the given tag.
     *
     * @param int $tagId
     * @param array $contentIds
     * @param int $limit
     * @return Collection
     */
    public function getRelatedTags(int $tagId, array $contentIds, int $limit = 10): Collection
    {
        return $this->repository->getRelatedTags($tagId, $contentIds, $limit);
    }
}

