<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\UpdatePasswordRequest;
use App\Services\User\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfilePasswordController extends Controller
{
    /**
     * @param UserService $service
     */
    public function __construct(
        private readonly UserService $service
    ) {
    }

    /**
     * Show the form for changing the authenticated user's password.
     *
     * @return View
     */
    public function edit(): View
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        return view('user.profile.password.edit', compact('user'));
    }

    /**
     * Update the authenticated user's password.
     *
     * @param UpdatePasswordRequest $request
     * @return RedirectResponse
     */
    public function update(UpdatePasswordRequest $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $validated = $request->validated();

        // Use changePassword method to update password
        $this->service->changePassword($user->id, $validated['password']);

        return redirect()
            ->route('user.profile.show')
            ->with('success', __('user/profile.messages.password_updated'));
    }
}
