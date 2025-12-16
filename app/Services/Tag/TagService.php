<?php

namespace App\Services\Tag;

use App\Models\Tag;
use App\Models\Tagable;
use Illuminate\Database\Eloquent\Collection;

/**
 * Service class for Tag business logic
 */
class TagService
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
     * Get tags by tagable entity.
     *
     * @param string $tagableType
     * @param int|string $tagableId
     * @return Collection
     */
    public function getByTagable(string $tagableType, int|string $tagableId): Collection
    {
        return Tagable::where('tagable_type', $tagableType)
            ->where('tagable_id', $tagableId)
            ->with('tag')
            ->get()
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
        $tag = Tag::whereRaw('LOWER(title) = ?', [mb_strtolower($title, 'UTF-8')])->first();

        if ($tag) {
            return $tag;
        }

        // Create new tag - HasPersianSlug trait will auto-generate slug
        return Tag::create(['title' => $title]);
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
        Tagable::where('tagable_type', $tagableType)
            ->where('tagable_id', $tagableId)
            ->delete();

        // Then attach new tags
        foreach ($tagData as $data) {
            Tagable::create([
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
        return Tagable::where('tagable_type', $tagableType)
            ->where('tagable_id', $tagableId)
            ->where('tag_id', $tagId)
            ->delete() > 0;
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
        $tagable = Tagable::where('id', $tagableId)
            ->where('tag_id', $tagId)
            ->first();

        if (!$tagable) {
            return false;
        }

        $tagable->body = $body;
        return $tagable->save();
    }
}

