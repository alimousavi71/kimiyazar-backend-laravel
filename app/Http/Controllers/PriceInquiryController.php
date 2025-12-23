<?php

namespace App\Http\Controllers;

use App\Http\Requests\PriceInquiry\StorePriceInquiryRequest;
use App\Services\PriceInquiry\PriceInquiryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PriceInquiryController extends Controller
{
    public function __construct(
        private readonly PriceInquiryService $service
    ) {
    }

    /**
     * Show the price inquiry form.
     *
     * @return View
     */
    public function create(): View
    {
        // If user is authenticated, prefill their data
        $user = auth()->user();

        return view('price-inquiry.create', compact('user'));
    }

    /**
     * Store a newly created price inquiry.
     *
     * @param StorePriceInquiryRequest $request
     * @return RedirectResponse
     */
    public function store(StorePriceInquiryRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $this->service->create($validated);

        return redirect()
            ->route('price-inquiry.create')
            ->with('success', __('price-inquiry.messages.created'));
    }
}
