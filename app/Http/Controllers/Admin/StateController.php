<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\State\StoreStateRequest;
use App\Http\Requests\Admin\State\UpdateStateRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Services\Country\CountryService;
use App\Services\State\StateService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StateController extends Controller
{
    use ApiResponseTrait;

    /**
     * @param StateService $service
     * @param CountryService $countryService
     */
    public function __construct(
        private readonly StateService $service,
        private readonly CountryService $countryService
    ) {
    }

    /**
     * Display a listing of states.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $states = $this->service->search();
        $countries = $this->countryService->all();

        return view('admin.states.index', compact('states', 'countries'));
    }

    /**
     * Show the form for creating a new state.
     *
     * @return View
     */
    public function create(): View
    {
        $countries = $this->countryService->all();

        return view('admin.states.create', compact('countries'));
    }

    /**
     * Store a newly created state in storage.
     *
     * @param StoreStateRequest $request
     * @return RedirectResponse
     */
    public function store(StoreStateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $this->service->create($validated);

        return redirect()
            ->route('admin.states.index')
            ->with('success', __('admin/states.messages.created'));
    }

    /**
     * Display the specified state.
     *
     * @param string $id
     * @return View
     */
    public function show(string $id): View
    {
        $state = $this->service->findById($id);

        return view('admin.states.show', compact('state'));
    }

    /**
     * Show the form for editing the specified state.
     *
     * @param string $id
     * @return View
     */
    public function edit(string $id): View
    {
        $state = $this->service->findById($id);
        $countries = $this->countryService->all();

        return view('admin.states.edit', compact('state', 'countries'));
    }

    /**
     * Update the specified state in storage.
     *
     * @param UpdateStateRequest $request
     * @param string $id
     * @return RedirectResponse
     */
    public function update(UpdateStateRequest $request, string $id): RedirectResponse
    {
        $validated = $request->validated();
        $this->service->update($id, $validated);

        return redirect()
            ->route('admin.states.index')
            ->with('success', __('admin/states.messages.updated'));
    }

    /**
     * Remove the specified state from storage.
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
                return $this->successResponse(null, __('admin/states.messages.deleted'));
            }

            return redirect()
                ->route('admin.states.index')
                ->with('success', __('admin/states.messages.deleted'));
        } catch (ModelNotFoundException $e) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return $this->notFoundResponse(__('admin/states.messages.not_found'));
            }
            return redirect()
                ->route('admin.states.index')
                ->with('error', __('admin/states.messages.not_found'));
        } catch (Exception $e) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return $this->errorResponse(__('admin/states.messages.delete_failed'), 500);
            }
            return redirect()
                ->route('admin.states.index')
                ->with('error', __('admin/states.messages.delete_failed'));
        }
    }
}
