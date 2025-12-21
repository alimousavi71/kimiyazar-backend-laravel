<?php

namespace App\Http\Controllers;

use App\Enums\Database\ContentType;
use App\Services\Content\ContentService;
use App\Services\Tag\TagService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function __construct(
        private readonly ContentService $contentService,
        private readonly TagService $tagService
    ) {
    }

    /**
     * Display the articles list page.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $search = $request->get('finder');

        // Get paginated articles
        $articles = $this->contentService->getPaginatedActiveContentByType(
            ContentType::ARTICLE,
            10,
            $search
        );

        // Get recent articles for sidebar (latest 3)
        $recentArticles = $this->contentService->getActiveContentByType(ContentType::ARTICLE, 3);

        // Get all tags from articles (for sidebar)
        $tags = $this->tagService->getTagsByContentType(ContentType::ARTICLE, 20);

        return view('articles.index', compact('articles', 'recentArticles', 'tags', 'search'));
    }

    /**
     * Display a single article item.
     *
     * @param string $slug
     * @return View|RedirectResponse
     */
    public function show(string $slug): View|RedirectResponse
    {
        // Get article by slug
        $article = $this->contentService->getActiveContentByTypeAndSlug(ContentType::ARTICLE, $slug);

        if (!$article) {
            return redirect()->route('articles.index')->with('error', 'مقاله مورد نظر یافت نشد.');
        }

        // Get recent articles for sidebar (latest 3, excluding current)
        $recentArticles = $this->contentService->getActiveContentByType(ContentType::ARTICLE, 4)
            ->filter(fn($item) => $item->id !== $article->id)
            ->take(3);

        // Get all tags from articles (for sidebar)
        $tags = $this->tagService->getTagsByContentType(ContentType::ARTICLE, 20);

        return view('articles.show', compact('article', 'recentArticles', 'tags'));
    }
}
