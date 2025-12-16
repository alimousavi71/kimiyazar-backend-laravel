<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Slider\StoreSliderRequest;
use App\Http\Requests\Admin\Slider\UpdateSliderRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Services\Slider\SliderService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SliderController extends Controller
{
    use ApiResponseTrait;

    /**
     * @param SliderService $service
     */
    public function __construct(
        private readonly SliderService $service
    ) {
    }

    /**
     * Display a listing of the sliders.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $sliders = $this->service->search();

        return view('admin.sliders.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new slider.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.sliders.create');
    }

    /**
     * Store a newly created slider in storage.
     *
     * @param StoreSliderRequest $request
     * @return RedirectResponse|JsonResponse
     */
    public function store(StoreSliderRequest $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validated();

        try {
            $slider = $this->service->create($validated);

            if ($request->expectsJson() || $request->wantsJson()) {
                return $this->createdResponse($slider->toArray(), __('admin/sliders.messages.created'));
            }

            return redirect()
                ->route('admin.sliders.index')
                ->with('success', __('admin/sliders.messages.created'));
        } catch (Exception $e) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return $this->errorResponse(__('admin/sliders.messages.create_failed') . ': ' . $e->getMessage(), 500);
            }
            return redirect()
                ->route('admin.sliders.index')
                ->with('error', __('admin/sliders.messages.create_failed'));
        }
    }

    /**
     * Display the specified slider.
     *
     * @param string $id
     * @return View
     */
    public function show(string $id): View
    {
        $slider = $this->service->findById($id);

        return view('admin.sliders.show', compact('slider'));
    }

    /**
     * Show the form for editing the specified slider.
     *
     * @param string $id
     * @return View
     */
    public function edit(string $id): View
    {
        $slider = $this->service->findById($id);

        return view('admin.sliders.edit', compact('slider'));
    }

    /**
     * Update the specified slider in storage.
     *
     * @param UpdateSliderRequest $request
     * @param string $id
     * @return RedirectResponse
     */
    public function update(UpdateSliderRequest $request, string $id): RedirectResponse
    {
        $validated = $request->validated();

        $this->service->update($id, $validated);

        return redirect()
            ->route('admin.sliders.index')
            ->with('success', __('admin/sliders.messages.updated'));
    }

    /**
     * Remove the specified slider from storage.
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
                return $this->successResponse(null, __('admin/sliders.messages.deleted'));
            }

            return redirect()
                ->route('admin.sliders.index')
                ->with('success', __('admin/sliders.messages.deleted'));
        } catch (ModelNotFoundException $e) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return $this->notFoundResponse(__('admin/sliders.messages.not_found'));
            }
            return redirect()
                ->route('admin.sliders.index')
                ->with('error', __('admin/sliders.messages.not_found'));
        } catch (Exception $e) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return $this->errorResponse(__('admin/sliders.messages.delete_failed') . ': ' . $e->getMessage(), 500);
            }
            return redirect()
                ->route('admin.sliders.index')
                ->with('error', __('admin/sliders.messages.delete_failed'));
        }
    }
}

