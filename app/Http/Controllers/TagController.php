<?php

namespace App\Http\Controllers;

use App\Services\Tag\TagService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TagController extends Controller
{
    public function __construct(
        private readonly TagService $tagService
    ) {
    }

    /**
     * Display entities (contents) by tag slug.
     *
     * @param Request $request
     * @param string $slug
     * @return View|RedirectResponse
     */
    public function index(Request $request, string $slug): View|RedirectResponse
    {
        // Find tag by slug
        $tag = $this->tagService->findBySlug($slug);

        if (!$tag) {
            abort(404, 'Tag not found');
        }

        // Get search parameter
        $search = $request->get('search');

        // Get paginated entities (50 per page)
        $entities = $this->tagService->getPaginatedEntitiesByTagSlug($slug, 50, $search);

        // Get related tags (tags used with the same contents)
        $contentIds = collect($entities->items())->pluck('id')->toArray();
        $relatedTags = $this->tagService->getRelatedTags($tag->id, $contentIds, 10);

        return view('tags.index', compact('tag', 'entities', 'search', 'relatedTags'));
    }
}
