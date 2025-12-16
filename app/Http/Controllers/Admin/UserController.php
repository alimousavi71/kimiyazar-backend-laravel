<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\ChangePasswordRequest;
use App\Http\Requests\Admin\User\StoreUserRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Services\User\UserService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        private readonly UserService $service
    ) {
    }

    public function index(Request $request): View
    {
        $users = $this->service->search();

        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $this->service->create($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', __('admin/users.messages.created'));
    }

    public function show(string $id): View
    {
        $user = $this->service->findById($id);

        return view('admin.users.show', compact('user'));
    }

    public function edit(string $id): View
    {
        $user = $this->service->findById($id);

        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, string $id): RedirectResponse
    {
        $validated = $request->validated();

        $this->service->update($id, $validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', __('admin/users.messages.updated'));
    }

    public function editPassword(string $id): View
    {
        $user = $this->service->findById($id);

        return view('admin.users.change-password', compact('user'));
    }

    public function updatePassword(ChangePasswordRequest $request, string $id): RedirectResponse
    {
        try {
            $validated = $request->validated();

            $this->service->changePassword($id, $validated['password']);

            return redirect()
                ->route('admin.users.index')
                ->with('success', __('admin/users.messages.password_changed'));
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', __('admin/users.messages.not_found'));
        }
    }

    public function destroy(Request $request, string $id): JsonResponse|RedirectResponse
    {
        try {
            $this->service->delete($id);

            if ($request->expectsJson() || $request->wantsJson()) {
                return $this->successResponse(null, __('admin/users.messages.deleted'));
            }

            return redirect()
                ->route('admin.users.index')
                ->with('success', __('admin/users.messages.deleted'));
        } catch (ModelNotFoundException $e) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return $this->notFoundResponse(__('admin/users.messages.not_found'));
            }
            return redirect()
                ->route('admin.users.index')
                ->with('error', __('admin/users.messages.not_found'));
        } catch (Exception $e) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return $this->errorResponse(__('admin/users.messages.delete_failed') . ': ' . $e->getMessage(), 500);
            }
            return redirect()
                ->route('admin.users.index')
                ->with('error', __('admin/users.messages.delete_failed'));
        }
    }

    public function toggleStatus(string $id): RedirectResponse
    {
        try {
            $user = $this->service->toggleStatus($id);
            $statusMessage = $user->is_active ? __('admin/users.messages.activated') : __('admin/users.messages.deactivated');

            return redirect()
                ->route('admin.users.index')
                ->with('success', $statusMessage);
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', __('admin/users.messages.not_found'));
        }
    }
}
