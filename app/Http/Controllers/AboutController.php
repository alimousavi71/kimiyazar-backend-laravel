<?php

namespace App\Http\Controllers;

use App\Enums\Database\ContentType;
use App\Services\Content\ContentService;
use App\Services\Setting\SettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function __construct(
        private readonly ContentService $contentService,
        private readonly SettingService $settingService
    ) {
    }

    /**
     * Display the about page.
     *
     * @return View|RedirectResponse
     */
    public function index(): View|RedirectResponse
    {
        $settings = $this->settingService->getAllAsArray();

        // Get about content (PAGE type with slug 'درباره-ما' or 'about')
        // The slug is generated from Persian title "درباره ما" using Str::slug()
        $aboutSlug = \Illuminate\Support\Str::slug('درباره ما');
        $content = $this->contentService->getActiveContentByTypeAndSlug(ContentType::PAGE, $aboutSlug);

        // If content not found, redirect to home
        if (!$content) {
            return redirect()->route('home')->with('error', 'صفحه مورد نظر یافت نشد.');
        }

        return view('about', compact('content', 'settings'));
    }
}
