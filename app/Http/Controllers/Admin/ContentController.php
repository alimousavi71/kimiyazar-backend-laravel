<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\StoreContentRequest;
use App\Http\Requests\Admin\Content\UpdateContentRequest;
use App\Http\Requests\Admin\Content\UploadEditorImageRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Services\Content\ContentService;
use App\Services\ImageService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContentController extends Controller
{
    use ApiResponseTrait;

    /**
     * @param ContentService $service
     * @param ImageService $imageService
     */
    public function __construct(
        private readonly ContentService $service,
        private readonly ImageService $imageService
    ) {
    }

    /**
     * Display a listing of the contents.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $contents = $this->service->search();

        return view('admin.contents.index', compact('contents'));
    }

    /**
     * Show the form for creating a new content.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.contents.create');
    }

    /**
     * Store a newly created content in storage.
     *
     * @param StoreContentRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function store(StoreContentRequest $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validated();

        $content = $this->service->create($validated);

        if ($request->expectsJson() || $request->wantsJson()) {
            return $this->createdResponse($content->toArray(), __('admin/contents.messages.created'));
        }

        return redirect()
            ->route('admin.contents.index')
            ->with('success', __('admin/contents.messages.created'));
    }

    /**
     * Display the specified content.
     *
     * @param string $id
     * @return View
     */
    public function show(string $id): View
    {
        $content = $this->service->findById($id);

        return view('admin.contents.show', compact('content'));
    }

    /**
     * Show the form for editing the specified content.
     *
     * @param string $id
     * @return View
     */
    public function edit(string $id): View
    {
        $content = $this->service->findById($id);

        return view('admin.contents.edit', compact('content'));
    }

    /**
     * Update the specified content in storage.
     *
     * @param UpdateContentRequest $request
     * @param string $id
     * @return RedirectResponse
     */
    public function update(UpdateContentRequest $request, string $id): RedirectResponse
    {
        $validated = $request->validated();

        $this->service->update($id, $validated);

        return redirect()
            ->route('admin.contents.index')
            ->with('success', __('admin/contents.messages.updated'));
    }

    /**
     * Remove the specified content from storage.
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
                return $this->successResponse(null, __('admin/contents.messages.deleted'));
            }

            return redirect()
                ->route('admin.contents.index')
                ->with('success', __('admin/contents.messages.deleted'));
        } catch (ModelNotFoundException $e) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return $this->notFoundResponse(__('admin/contents.messages.not_found'));
            }
            return redirect()
                ->route('admin.contents.index')
                ->with('error', __('admin/contents.messages.not_found'));
        } catch (Exception $e) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return $this->errorResponse(__('admin/contents.messages.delete_failed') . ': ' . $e->getMessage(), 500);
            }
            return redirect()
                ->route('admin.contents.index')
                ->with('error', __('admin/contents.messages.delete_failed'));
        }
    }

    /**
     * Upload an image for the editor.
     *
     * @param UploadEditorImageRequest $request
     * @return JsonResponse
     */
    public function uploadEditorImage(UploadEditorImageRequest $request): JsonResponse
    {
        try {
            $file = $request->file('image');

            // Upload image without resizing - preserve original size and format
            $preset = [
                'width' => null,
                'height' => null,
                'quality' => 90,
                'format' => strtolower($file->getClientOriginalExtension()) ?: 'jpg',
            ];

            $filePath = $this->imageService->upload($file, $preset, 'editor');

            // Return the public URL
            $url = asset('storage/' . $filePath);

            return $this->successResponse(['url' => $url], __('admin/contents.messages.image_uploaded'));
        } catch (Exception $e) {
            return $this->errorResponse(__('admin/contents.messages.image_upload_failed') . ': ' . $e->getMessage(), 500);
        }
    }
}
