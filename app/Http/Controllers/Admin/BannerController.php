<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Banner\StoreBannerRequest;
use App\Http\Requests\Admin\Banner\UpdateBannerRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Services\Banner\BannerService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BannerController extends Controller
{
    use ApiResponseTrait;

    /**
     * @param BannerService $service
     */
    public function __construct(
        private readonly BannerService $service
    ) {
    }

    /**
     * Display a listing of the banners.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $banners = $this->service->search();

        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new banner.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.banners.create');
    }

    /**
     * Store a newly created banner in storage.
     *
     * @param StoreBannerRequest $request
     * @return RedirectResponse
     */
    public function store(StoreBannerRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $bannerFile = $request->file('banner_file');

        $this->service->create($validated, $bannerFile);

        return redirect()
            ->route('admin.banners.index')
            ->with('success', __('admin/banners.messages.created'));
    }

    /**
     * Display the specified banner.
     *
     * @param string $id
     * @return View
     */
    public function show(string $id): View
    {
        $banner = $this->service->findById($id);

        return view('admin.banners.show', compact('banner'));
    }

    /**
     * Show the form for editing the specified banner.
     *
     * @param string $id
     * @return View
     */
    public function edit(string $id): View
    {
        $banner = $this->service->findById($id);

        return view('admin.banners.edit', compact('banner'));
    }

    /**
     * Update the specified banner in storage.
     *
     * @param UpdateBannerRequest $request
     * @param string $id
     * @return RedirectResponse
     */
    public function update(UpdateBannerRequest $request, string $id): RedirectResponse
    {
        $validated = $request->validated();
        $bannerFile = $request->file('banner_file');

        $this->service->update($id, $validated, $bannerFile);

        return redirect()
            ->route('admin.banners.index')
            ->with('success', __('admin/banners.messages.updated'));
    }

    /**
     * Remove the specified banner from storage.
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
                return $this->successResponse(null, __('admin/banners.messages.deleted'));
            }

            return redirect()
                ->route('admin.banners.index')
                ->with('success', __('admin/banners.messages.deleted'));
        } catch (ModelNotFoundException $e) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return $this->notFoundResponse(__('admin/banners.messages.not_found'));
            }
            return redirect()
                ->route('admin.banners.index')
                ->with('error', __('admin/banners.messages.not_found'));
        } catch (Exception $e) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return $this->errorResponse(__('admin/banners.messages.delete_failed') . ': ' . $e->getMessage(), 500);
            }
            return redirect()
                ->route('admin.banners.index')
                ->with('error', __('admin/banners.messages.delete_failed'));
        }
    }
}

