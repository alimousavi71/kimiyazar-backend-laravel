<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\UpdateSettingRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Services\Setting\SettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingController extends Controller
{
    use ApiResponseTrait;

    /**
     * @param SettingService $service
     */
    public function __construct(
        private readonly SettingService $service
    ) {
    }

    /**
     * Show the form for editing settings.
     *
     * @return View
     */
    public function edit(): View
    {
        $settings = $this->service->getAllGrouped();
        $availableKeys = $this->service->getAvailableKeys();

        return view('admin.settings.edit', compact('settings', 'availableKeys'));
    }

    /**
     * Update settings in storage.
     *
     * @param UpdateSettingRequest $request
     * @return RedirectResponse
     */
    public function update(UpdateSettingRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $this->service->updateMultiple($validated['settings'] ?? []);

        return redirect()
            ->route('admin.settings.edit')
            ->with('success', __('admin/settings.messages.updated'));
    }
}
