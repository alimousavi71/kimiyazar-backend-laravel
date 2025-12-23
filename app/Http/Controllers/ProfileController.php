<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Services\User\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * @param UserService $service
     */
    public function __construct(
        private readonly UserService $service
    ) {
    }

    /**
     * Display the authenticated user's profile.
     *
     * @return View
     */
    public function show(): View
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        return view('user.profile.show', compact('user'));
    }

    /**
     * Show the form for editing the authenticated user's profile.
     *
     * @return View
     */
    public function edit(): View
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        return view('user.profile.edit', compact('user'));
    }

    /**
     * Update the authenticated user's profile.
     *
     * @param UpdateProfileRequest $request
     * @return RedirectResponse
     */
    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $validated = $request->validated();

        $this->service->update($user->id, $validated);

        return redirect()
            ->route('user.profile.show')
            ->with('success', __('user/profile.messages.updated'));
    }
}
