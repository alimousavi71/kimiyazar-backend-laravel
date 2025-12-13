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
     * @param string $id
     * @return View
     */
    public function edit(string $id): View
    {
        $admin = $this->service->findById($id);

        return view('admin.admins.password.edit', compact('admin'));
    }

    /**
     * Update the admin password.
     *
     * @param UpdatePasswordRequest $request
     * @param string $id
     * @return RedirectResponse
     */
    public function update(UpdatePasswordRequest $request, string $id): RedirectResponse
    {
        $validated = $request->validated();

        $this->service->update($id, $validated);

        return redirect()
            ->route('admin.admins.show', $id)
            ->with('success', __('admin/admins.messages.password_updated'));
    }
}

