<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
     * Display a listing of the price inquiries.
     *
     * @return View
     */
    public function index(): View
    {
        $priceInquiries = $this->service->search();

        return view('admin.price-inquiries.index', compact('priceInquiries'));
    }

    /**
     * Display the specified price inquiry.
     *
     * @param string $id
     * @return View
     */
    public function show(string $id): View
    {
        $priceInquiry = $this->service->findById($id);
        $products = $this->service->getProducts($priceInquiry)->keyBy('id');

        return view('admin.price-inquiries.show', compact('priceInquiry', 'products'));
    }

    /**
     * Toggle review status of price inquiry.
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function toggleReviewStatus(string $id): RedirectResponse
    {
        $this->service->toggleReviewStatus($id);

        return redirect()
            ->route('admin.price-inquiries.show', $id)
            ->with('success', __('admin/price-inquiries.messages.status_toggled'));
    }

    /**
     * Remove the specified price inquiry from storage.
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function destroy(string $id): RedirectResponse
    {
        $this->service->delete($id);

        return redirect()
            ->route('admin.price-inquiries.index')
            ->with('success', __('admin/price-inquiries.messages.deleted'));
    }
}
