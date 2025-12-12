<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Admin\UpdatePasswordRequest;
use App\Services\Admin\AdminService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminPasswordController extends Controller
{
    /**
     * @param AdminService $service
     */
    public function __construct(
        private readonly AdminService $service
    ) {
    }

    /**
     * Show the form for changing admin password.
     *
     * @param string|null $id
     * @return View
     */
    public function edit(?string $id = null): View
    {
        // If no ID provided, use authenticated admin's ID
        if (!$id) {
            $admin = auth('admin')->user() ?? auth()->user();
            $id = $admin->id;
            $view = 'admin.profile.password.edit';
        } else {
            $admin = $this->service->findById($id);
            $view = 'admin.admins.password.edit';
        }

        return view($view, compact('admin'));
    }

    /**
     * Update the admin password.
     *
     * @param UpdatePasswordRequest $request
     * @param string|null $id
     * @return RedirectResponse
     */
    public function update(UpdatePasswordRequest $request, ?string $id = null): RedirectResponse
    {
        $validated = $request->validated();

        // If no ID provided, use authenticated admin's ID
        if (!$id) {
            $admin = auth('admin')->user() ?? auth()->user();
            $id = $admin->id;
            $redirectRoute = 'admin.profile.show';
            $messageKey = 'admin/profile.messages.password_updated';
        } else {
            $redirectRoute = 'admin.admins.show';
            $messageKey = 'admin/admins.messages.password_updated';
        }

        // Use the existing service update method
        $this->service->update($id, $validated);

        if ($id && $redirectRoute === 'admin.admins.show') {
            return redirect()
                ->route($redirectRoute, $id)
                ->with('success', __($messageKey));
        }

        return redirect()
            ->route($redirectRoute)
            ->with('success', __($messageKey));
    }
}

