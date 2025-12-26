<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\DashboardService;
use Illuminate\View\View;

/**
 * Dashboard Controller
 */
class DashboardController extends Controller
{
    /**
     * Constructor with service injection.
     */
    public function __construct(
        private readonly DashboardService $dashboardService
    ) {
    }

    /**
     * Show admin dashboard.
     *
     * @return View
     */
    public function index(): View
    {
        $data = $this->dashboardService->getDashboardData();

        return view('pages.dashboard', $data);
    }
}
