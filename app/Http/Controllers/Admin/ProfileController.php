<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Profile\UpdateProfileRequest;
use App\Services\Admin\AdminService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * @param AdminService $service
     */
    public function __construct(
        private readonly AdminService $service
    ) {
    }

    /**
     * Display the authenticated admin's profile.
     *
     * @return View
     */
    public function show(): View
    {
        $admin = auth('admin')->user() ?? auth()->user();

        return view('admin.profile.show', compact('admin'));
    }

    /**
     * Show the form for editing the authenticated admin's profile.
     *
     * @return View
     */
    public function edit(): View
    {
        $admin = auth('admin')->user() ?? auth()->user();

        return view('admin.profile.edit', compact('admin'));
    }

    /**
     * Update the authenticated admin's profile.
     *
     * @param UpdateProfileRequest $request
     * @return RedirectResponse
     */
    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $admin = auth('admin')->user() ?? auth()->user();
        $validated = $request->validated();

        $this->service->update($admin->id, $validated);

        return redirect()
            ->route('admin.profile.show')
            ->with('success', __('admin/profile.messages.updated'));
    }
}

