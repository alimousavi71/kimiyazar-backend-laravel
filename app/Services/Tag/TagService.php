<?php

namespace App\Services\Tag;

use App\Enums\Database\ContentType;
use App\Models\Tag;
use App\Repositories\Tag\TagRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

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
        return $this->repository->getTagablesByTagable($tagableType, $tagableId)
            ->map(function ($tagable) {
                return [
                    'id' => $tagable->tag->id,
                    'tag_id' => $tagable->tag_id,
                    'title' => $tagable->tag->title,
                    'slug' => $tagable->tag->slug,
                    'body' => $tagable->body,
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
     * @param array $tagData Array of ['tag_id' => id, 'body' => 'optional body']
     * @return void
     */
    public function attachToTagable(string $tagableType, int|string $tagableId, array $tagData): void
    {
        // First, detach all existing tags
        $this->repository->deleteTagablesByTagable($tagableType, $tagableId);

        // Then attach new tags
        foreach ($tagData as $data) {
            $this->repository->createTagable([
                'tag_id' => $data['tag_id'],
                'tagable_type' => $tagableType,
                'tagable_id' => $tagableId,
                'body' => $data['body'] ?? null,
            ]);
        }
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
        return $this->repository->deleteTagableByTagableAndTag($tagableType, $tagableId, $tagId);
    }

    /**
     * Update tag body for a specific tagable.
     *
     * @param int|string $tagableId
     * @param int|string $tagId
     * @param string|null $body
     * @return bool
     */
    public function updateTagBody(int|string $tagableId, int|string $tagId, ?string $body): bool
    {
        $tagable = $this->repository->findTagableByIdAndTagId($tagableId, $tagId);

        if (!$tagable) {
            return false;
        }

        $tagable->body = $body;
        return $tagable->save();
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
}

