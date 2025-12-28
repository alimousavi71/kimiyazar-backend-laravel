<?php

namespace App\Http\Controllers;

use App\Enums\Database\ContentType;
use App\Services\Content\ContentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PageController extends Controller
{
    public function __construct(
        private readonly ContentService $contentService
    ) {
    }

    /**
     * Display a single page.
     *
     * @param string $slug
     * @return View|RedirectResponse
     */
    public function show(string $slug): View|RedirectResponse
    {
        // Get page by slug
        $page = $this->contentService->getActiveContentByTypeAndSlug(ContentType::PAGE, $slug);

        if (!$page) {
            return redirect()->route('home')->with('error', 'صفحه مورد نظر یافت نشد.');
        }

        return view('page.show', compact('page'));
    }
}

