<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Admin\UpdatePasswordRequest;
use App\Services\Admin\AdminService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfilePasswordController extends Controller
{
    /**
     * @param AdminService $service
     */
    public function __construct(
        private readonly AdminService $service
    ) {
    }

    /**
     * Show the form for changing the authenticated admin's password.
     *
     * @return View
     */
    public function edit(): View
    {
        $admin = auth('admin')->user() ?? auth()->user();

        return view('admin.profile.password.edit', compact('admin'));
    }

    /**
     * Update the authenticated admin's password.
     *
     * @param UpdatePasswordRequest $request
     * @return RedirectResponse
     */
    public function update(UpdatePasswordRequest $request): RedirectResponse
    {
        $admin = auth('admin')->user() ?? auth()->user();
        $validated = $request->validated();

        // Use the existing service update method
        $this->service->update($admin->id, $validated);

        return redirect()
            ->route('admin.profile.show')
            ->with('success', __('admin/profile.messages.password_updated'));
    }
}

