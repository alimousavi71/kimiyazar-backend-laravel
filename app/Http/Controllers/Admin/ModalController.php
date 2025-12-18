<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Modal\StoreModalRequest;
use App\Http\Requests\Admin\Modal\UpdateModalRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Services\Modal\ModalService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ModalController extends Controller
{
    use ApiResponseTrait;

    /**
     * @param ModalService $service
     */
    public function __construct(
        private readonly ModalService $service
    ) {
    }

    /**
     * Display a listing of the modals.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $modals = $this->service->search();

        return view('admin.modals.index', compact('modals'));
    }

    /**
     * Show the form for creating a new modal.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.modals.create');
    }

    /**
     * Store a newly created modal in storage.
     *
     * @param StoreModalRequest $request
     * @return RedirectResponse|JsonResponse
     */
    public function store(StoreModalRequest $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validated();

        try {
            $modal = $this->service->create($validated);

            if ($request->expectsJson() || $request->wantsJson()) {
                return $this->createdResponse($modal->toArray(), __('admin/modals.messages.created'));
            }

            return redirect()
                ->route('admin.modals.index')
                ->with('success', __('admin/modals.messages.created'));
        } catch (Exception $e) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return $this->errorResponse(__('admin/modals.messages.create_failed') . ': ' . $e->getMessage(), 500);
            }
            return redirect()
                ->route('admin.modals.index')
                ->with('error', __('admin/modals.messages.create_failed'));
        }
    }

    /**
     * Display the specified modal.
     *
     * @param string $id
     * @return View
     */
    public function show(string $id): View
    {
        $modal = $this->service->findById($id);

        return view('admin.modals.show', compact('modal'));
    }

    /**
     * Show the form for editing the specified modal.
     *
     * @param string $id
     * @return View
     */
    public function edit(string $id): View
    {
        $modal = $this->service->findById($id);

        return view('admin.modals.edit', compact('modal'));
    }

    /**
     * Update the specified modal in storage.
     *
     * @param UpdateModalRequest $request
     * @param string $id
     * @return RedirectResponse
     */
    public function update(UpdateModalRequest $request, string $id): RedirectResponse
    {
        $validated = $request->validated();

        $this->service->update($id, $validated);

        return redirect()
            ->route('admin.modals.index')
            ->with('success', __('admin/modals.messages.updated'));
    }

    /**
     * Remove the specified modal from storage.
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
                return $this->successResponse(null, __('admin/modals.messages.deleted'));
            }

            return redirect()
                ->route('admin.modals.index')
                ->with('success', __('admin/modals.messages.deleted'));
        } catch (ModelNotFoundException $e) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return $this->notFoundResponse(__('admin/modals.messages.not_found'));
            }
            return redirect()
                ->route('admin.modals.index')
                ->with('error', __('admin/modals.messages.not_found'));
        } catch (Exception $e) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return $this->errorResponse(__('admin/modals.messages.delete_failed') . ': ' . $e->getMessage(), 500);
            }
            return redirect()
                ->route('admin.modals.index')
                ->with('error', __('admin/modals.messages.delete_failed'));
        }
    }
}
