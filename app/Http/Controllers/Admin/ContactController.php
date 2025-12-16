<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Contact\ContactService;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * @param ContactService $service
     */
    public function __construct(
        private readonly ContactService $service
    ) {
    }

    /**
     * Display a listing of the contacts.
     *
     * @return View
     */
    public function index(): View
    {
        $contacts = $this->service->search();

        return view('admin.contacts.index', compact('contacts'));
    }

    /**
     * Display the specified contact.
     *
     * @param string $id
     * @return View
     */
    public function show(string $id): View
    {
        $contact = $this->service->findById($id);

        return view('admin.contacts.show', compact('contact'));
    }
}

