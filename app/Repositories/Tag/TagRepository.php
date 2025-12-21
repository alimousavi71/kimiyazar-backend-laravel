<?php

namespace App\Repositories\Tag;

use App\Enums\Database\ContentType;
use App\Models\Tag;
use App\Models\Tagable;
use Illuminate\Database\Eloquent\Collection;

/**
 * Repository implementation for Tag model
 */
class TagRepository implements TagRepositoryInterface
{
    /**
     * Search tags by query string.
     *
     * @param string $query
     * @param int $limit
     * @return Collection
     */
    public function search(string $query = '', int $limit = 20): Collection
    {
        $tags = Tag::query();

        if (!empty($query)) {
            $tags->where('title', 'like', "%{$query}%")
                ->orWhere('slug', 'like', "%{$query}%");
        }

        // Order by latest when no query
        if (empty($query)) {
            $tags->orderBy('created_at', 'desc');
        }

        return $tags->limit($limit)->get();
    }

    /**
     * Find tag by title (case-insensitive).
     *
     * @param string $title
     * @return Tag|null
     */
    public function findByTitle(string $title): ?Tag
    {
        return Tag::whereRaw('LOWER(title) = ?', [mb_strtolower($title, 'UTF-8')])->first();
    }

    /**
     * Create a new tag.
     *
     * @param array $data
     * @return Tag
     */
    public function create(array $data): Tag
    {
        return Tag::create($data);
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
        return Tag::whereHas('contents', function ($query) use ($contentType) {
            $query->where('type', $contentType)
                ->where('is_active', true);
        })->limit($limit)->get();
    }

    /**
     * Get tagables by tagable entity.
     *
     * @param string $tagableType
     * @param int|string $tagableId
     * @return Collection
     */
    public function getTagablesByTagable(string $tagableType, int|string $tagableId): Collection
    {
        return Tagable::where('tagable_type', $tagableType)
            ->where('tagable_id', $tagableId)
            ->with('tag')
            ->get();
    }

    /**
     * Delete tagables by tagable entity.
     *
     * @param string $tagableType
     * @param int|string $tagableId
     * @return bool
     */
    public function deleteTagablesByTagable(string $tagableType, int|string $tagableId): bool
    {
        return Tagable::where('tagable_type', $tagableType)
            ->where('tagable_id', $tagableId)
            ->delete() > 0;
    }

    /**
     * Create a tagable.
     *
     * @param array $data
     * @return Tagable
     */
    public function createTagable(array $data): Tagable
    {
        return Tagable::create($data);
    }

    /**
     * Delete tagables by tagable entity and tag ID.
     *
     * @param string $tagableType
     * @param int|string $tagableId
     * @param int|string $tagId
     * @return bool
     */
    public function deleteTagableByTagableAndTag(string $tagableType, int|string $tagableId, int|string $tagId): bool
    {
        return Tagable::where('tagable_type', $tagableType)
            ->where('tagable_id', $tagableId)
            ->where('tag_id', $tagId)
            ->delete() > 0;
    }

    /**
     * Find tagable by ID and tag ID.
     *
     * @param int|string $tagableId
     * @param int|string $tagId
     * @return Tagable|null
     */
    public function findTagableByIdAndTagId(int|string $tagableId, int|string $tagId): ?Tagable
    {
        return Tagable::where('id', $tagableId)
            ->where('tag_id', $tagId)
            ->first();
    }
}
