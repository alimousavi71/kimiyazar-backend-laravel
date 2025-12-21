<?php

namespace App\Http\Controllers;

use App\Enums\Database\ContentType;
use App\Services\Content\ContentService;
use App\Services\Setting\SettingService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function __construct(
        private readonly ContentService $contentService,
        private readonly SettingService $settingService
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
        $settings = $this->settingService->getAllAsArray();
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
        $tags = \App\Models\Tag::whereHas('contents', function ($query) {
            $query->where('type', ContentType::ARTICLE)
                ->where('is_active', true);
        })->limit(20)->get();

        return view('articles.index', compact('articles', 'recentArticles', 'tags', 'settings', 'search'));
    }
}
