<?php

namespace App\Repositories\Tag;

use App\Enums\Database\ContentType;
use App\Models\Tag;
use App\Models\Tagable;
use App\Models\Content;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

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
        // Normalize tagable_type: convert AppModelsProduct to App\Models\Product
        // Handle both formats for backward compatibility
        $normalizedType = $this->normalizeTagableType($tagableType);

        return Tagable::where('tagable_type', $normalizedType)
            ->where('tagable_id', $tagableId)
            ->with('tag')
            ->get();
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

        // Convert AppModelsProduct to App\Models\Product
        // Pattern: AppModelsX -> App\Models\X
        if (preg_match('/^AppModels(.+)$/', $type, $matches)) {
            return 'App\Models\\' . $matches[1];
        }

        // If no match, return original
        return $type;
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
        $normalizedType = $this->normalizeTagableType($tagableType);

        return Tagable::where('tagable_type', $normalizedType)
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
        $normalizedType = $this->normalizeTagableType($tagableType);

        return Tagable::where('tagable_type', $normalizedType)
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

    /**
     * Find tag by slug.
     *
     * @param string $slug
     * @return Tag|null
     */
    public function findBySlug(string $slug): ?Tag
    {
        return Tag::where('slug', $slug)->first();
    }

    /**
     * Get paginated entities (contents and products) by tag slug with search.
     *
     * @param string $tagSlug
     * @param int $perPage
     * @param string|null $search
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginatedEntitiesByTagSlug(string $tagSlug, int $perPage = 50, ?string $search = null): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $tag = $this->findBySlug($tagSlug);

        if (!$tag) {
            return new LengthAwarePaginator([], 0, $perPage);
        }

        $entities = collect();

        // Fetch Contents
        $contentQuery = Content::whereHas('tags', function ($q) use ($tag) {
            $q->where('tags.id', $tag->id);
        })
            ->where('is_active', true)
            ->with(['photos', 'tags']);

        if ($search) {
            $contentQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('body', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        $contents = $contentQuery->get()->map(function ($content) {
            $content->entity_type = 'content';
            $content->entity_route = $content->type->value === 'news' ? 'news.show' : 'articles.show';
            return $content;
        });

        $entities = $entities->merge($contents);

        // Fetch Products
        $productQuery = Product::whereHas('tags', function ($q) use ($tag) {
            $q->where('tags.id', $tag->id);
        })
            ->where('is_published', true)
            ->with(['photos', 'tags']);

        if ($search) {
            $productQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('body', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        $products = $productQuery->get()->map(function ($product) {
            $product->entity_type = 'product';
            $product->entity_route = 'products.show';
            // Map product fields to match content structure for view compatibility
            $product->title = $product->name;
            $product->type = (object) ['value' => 'product'];
            return $product;
        });

        $entities = $entities->merge($products);

        // Sort by created_at desc
        $entities = $entities->sortByDesc('created_at')->values();

        // Manual pagination
        $currentPage = request()->get('page', 1);
        $items = $entities->slice(($currentPage - 1) * $perPage, $perPage)->all();

        return new LengthAwarePaginator(
            $items,
            $entities->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
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
        if (empty($contentIds)) {
            return Tag::where('id', 0)->get();
        }

        return Tag::whereHas('contents', function ($query) use ($contentIds) {
            $query->whereIn('contents.id', $contentIds)
                ->where('contents.is_active', true);
        })
            ->where('tags.id', '!=', $tagId)
            ->distinct()
            ->limit($limit)
            ->get();
    }
}
