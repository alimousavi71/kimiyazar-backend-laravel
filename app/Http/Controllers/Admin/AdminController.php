<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Admin\StoreAdminRequest;
use App\Http\Requests\Admin\Admin\UpdateAdminRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Services\Admin\AdminService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    use ApiResponseTrait;

    /**
     * @param AdminService $service
     */
    public function __construct(
        private readonly AdminService $service
    ) {
    }

    /**
     * Display a listing of the admins.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        // Use QueryBuilder for all filtering, sorting, and pagination
        // Query parameters:
        // - filter[first_name]=John
        // - filter[last_name]=Doe
        // - filter[email]=example@mail.com
        // - filter[is_block]=true
        // - sort=first_name or sort=-created_at (descending)
        // - page=1
        $admins = $this->service->getAll();

        return view('admin.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new admin.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.admins.create');
    }

    /**
     * Store a newly created admin in storage.
     *
     * @param StoreAdminRequest $request
     * @return RedirectResponse
     */
    public function store(StoreAdminRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Remove avatar from validated data if present (handled separately)
        unset($validated['avatar']);

        $this->service->create($validated);

        return redirect()
            ->route('admin.admins.index')
            ->with('success', 'Admin created successfully.');
    }

    /**
     * Display the specified admin.
     *
     * @param string $id
     * @return View
     */
    public function show(string $id): View
    {
        $admin = $this->service->findById($id);

        return view('admin.admins.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified admin.
     *
     * @param string $id
     * @return View
     */
    public function edit(string $id): View
    {
        $admin = $this->service->findById($id);

        return view('admin.admins.edit', compact('admin'));
    }

    /**
     * Update the specified admin in storage.
     *
     * @param UpdateAdminRequest $request
     * @param string $id
     * @return RedirectResponse
     */
    public function update(UpdateAdminRequest $request, string $id): RedirectResponse
    {
        $validated = $request->validated();

        // Remove avatar from validated data if present (handled separately)
        unset($validated['avatar']);

        $this->service->update($id, $validated);

        return redirect()
            ->route('admin.admins.index')
            ->with('success', 'Admin updated successfully.');
    }

    /**
     * Remove the specified admin from storage.
     *
     * @param Request $request
     * @param string $id
     * @return JsonResponse|RedirectResponse
     */
    public function destroy(Request $request, string $id): JsonResponse|RedirectResponse
    {
        try {
            $this->service->delete($id);

            if ($request->expectsJson() || $request->wantsJson()) {
                return $this->successResponse(null, 'Admin deleted successfully.');
            }

            return redirect()
                ->route('admin.admins.index')
                ->with('success', 'Admin deleted successfully.');
        } catch (Exception $e) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return $this->errorResponse('Failed to delete admin: ' . $e->getMessage(), 500);
            }

            return redirect()
                ->route('admin.admins.index')
                ->with('error', 'Failed to delete admin.');
        }
    }
}

