<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\StoreContactRequest;
use App\Services\Contact\ContactService;
use App\Services\Setting\SettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function __construct(
        private readonly ContactService $contactService,
        private readonly SettingService $settingService
    ) {
    }

    /**
     * Display the contact page.
     *
     * @return View
     */
    public function index(): View
    {
        $settings = $this->settingService->getAllAsArray();

        return view('contact', compact('settings'));
    }

    /**
     * Store a new contact message.
     *
     * @param StoreContactRequest $request
     * @return RedirectResponse
     */
    public function store(StoreContactRequest $request): RedirectResponse
    {
        $this->contactService->create($request->validated());

        return redirect()
            ->route('contact.index')
            ->with('success', 'پیام شما با موفقیت ارسال شد. در اسرع وقت با شما تماس خواهیم گرفت.');
    }
}
