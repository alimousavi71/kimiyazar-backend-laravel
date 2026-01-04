<?php

namespace App\Http\Controllers;

use App\Enums\Database\ContentType;
use App\Services\Content\ContentService;
use App\Services\Tag\TagService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function __construct(
        private readonly ContentService $contentService,
        private readonly TagService $tagService
    ) {
    }

    /**
     * Display the news list page.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $search = $request->get('finder');

        // Get paginated news
        $news = $this->contentService->getPaginatedActiveContentByType(
            ContentType::NEWS,
            10,
            $search
        );

        // Get recent news for sidebar (latest 3)
        $recentNews = $this->contentService->getActiveContentByType(ContentType::NEWS, 3);

        // Get all tags from news (for sidebar)
        $tags = $this->tagService->getTagsByContentType(ContentType::NEWS, 20);

        return view('news.index', compact('news', 'recentNews', 'tags', 'search'));
    }

    /**
     * Display a single news item.
     *
     * @param string $slug
     * @return View|RedirectResponse
     */
    public function show(string $slug): View|RedirectResponse
    {
        // Get news by slug
        $news = $this->contentService->getActiveContentByTypeAndSlug(ContentType::NEWS, $slug);

        if (!$news) {
            return redirect()->route('news.index')->with('error', 'خبر مورد نظر یافت نشد.');
        }

        // Load tags relationship
        $news->load('tags');

        // Get recent news for sidebar (latest 3, excluding current)
        $recentNews = $this->contentService->getActiveContentByType(ContentType::NEWS, 4)
            ->filter(fn($item) => $item->id !== $news->id)
            ->take(3);

        // Get all tags from news (for sidebar)
        $tags = $this->tagService->getTagsByContentType(ContentType::NEWS, 20);

        return view('news.show', compact('news', 'recentNews', 'tags'));
    }
}
