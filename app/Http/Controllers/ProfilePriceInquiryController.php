<?php

namespace App\Http\Controllers;

use App\Services\PriceInquiry\PriceInquiryService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfilePriceInquiryController extends Controller
{
    public function __construct(
        private readonly PriceInquiryService $service
    ) {
    }

    /**
     * Display a listing of the authenticated user's price inquiries.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $user = auth()->user();

        // Filter price inquiries by the authenticated user's ID
        // Merge into query parameters for QueryBuilder
        $currentFilters = $request->query('filter', []);
        $currentFilters['user_id'] = $user->id;
        $request->query->set('filter', $currentFilters);

        $priceInquiries = $this->service->search(15);

        return view('user.profile.price-inquiries.index', compact('priceInquiries'));
    }

    /**
     * Display the specified price inquiry.
     *
     * @param string $id
     * @return View
     */
    public function show(string $id): View
    {
        $user = auth()->user();

        $priceInquiry = $this->service->findById($id);

        // Ensure the price inquiry belongs to the authenticated user
        if ($priceInquiry->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $products = $this->service->getProducts($priceInquiry)->keyBy('id');

        return view('user.profile.price-inquiries.show', compact('priceInquiry', 'products'));
    }
}
