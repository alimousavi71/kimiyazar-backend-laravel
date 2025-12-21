<?php

namespace App\Http\Controllers;

use App\Services\Faq\FaqService;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function __construct(
        private readonly FaqService $faqService
    ) {
    }

    /**
     * Display the FAQ index page.
     *
     * @return View
     */
    public function index(): View
    {
        $faqs = $this->faqService->getPublishedFaqs();

        return view('faqs.index', compact('faqs'));
    }
}
