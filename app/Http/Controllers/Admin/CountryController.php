<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Country\StoreCountryRequest;
use App\Http\Requests\Admin\Country\UpdateCountryRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Services\Country\CountryService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CountryController extends Controller
{
    use ApiResponseTrait;

    /**
     * @param CountryService $service
     */
    public function __construct(
        private readonly CountryService $service
    ) {
    }

    /**
     * Display a listing of countries.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $countries = $this->service->search();

        return view('admin.countries.index', compact('countries'));
    }

    /**
     * Show the form for creating a new country.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.countries.create');
    }

    /**
     * Store a newly created country in storage.
     *
     * @param StoreCountryRequest $request
     * @return RedirectResponse
     */
    public function store(StoreCountryRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $this->service->create($validated);

        return redirect()
            ->route('admin.countries.index')
            ->with('success', __('admin/countries.messages.created'));
    }

    /**
     * Display the specified country.
     *
     * @param string $id
     * @return View
     */
    public function show(string $id): View
    {
        $country = $this->service->findById($id);

        return view('admin.countries.show', compact('country'));
    }

    /**
     * Show the form for editing the specified country.
     *
     * @param string $id
     * @return View
     */
    public function edit(string $id): View
    {
        $country = $this->service->findById($id);

        return view('admin.countries.edit', compact('country'));
    }

    /**
     * Update the specified country in storage.
     *
     * @param UpdateCountryRequest $request
     * @param string $id
     * @return RedirectResponse
     */
    public function update(UpdateCountryRequest $request, string $id): RedirectResponse
    {
        $validated = $request->validated();
        $this->service->update($id, $validated);

        return redirect()
            ->route('admin.countries.index')
            ->with('success', __('admin/countries.messages.updated'));
    }

    /**
     * Remove the specified country from storage.
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
                return $this->successResponse(null, __('admin/countries.messages.deleted'));
            }

            return redirect()
                ->route('admin.countries.index')
                ->with('success', __('admin/countries.messages.deleted'));
        } catch (ModelNotFoundException $e) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return $this->notFoundResponse(__('admin/countries.messages.not_found'));
            }
            return redirect()
                ->route('admin.countries.index')
                ->with('error', __('admin/countries.messages.not_found'));
        } catch (Exception $e) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return $this->errorResponse(__('admin/countries.messages.delete_failed'), 500);
            }
            return redirect()
                ->route('admin.countries.index')
                ->with('error', __('admin/countries.messages.delete_failed'));
        }
    }
}
