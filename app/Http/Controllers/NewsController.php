<?php

namespace App\Http\Controllers;

use App\Enums\Database\ContentType;
use App\Services\Content\ContentService;
use App\Services\Setting\SettingService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function __construct(
        private readonly ContentService $contentService,
        private readonly SettingService $settingService
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
        $settings = $this->settingService->getAllAsArray();
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
        $tags = \App\Models\Tag::whereHas('contents', function ($query) {
            $query->where('type', ContentType::NEWS)
                ->where('is_active', true);
        })->limit(20)->get();

        return view('news.index', compact('news', 'recentNews', 'tags', 'settings', 'search'));
    }
}
