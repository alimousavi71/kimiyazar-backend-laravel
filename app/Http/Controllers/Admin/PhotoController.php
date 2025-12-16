<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Photo\AttachPhotoRequest;
use App\Http\Requests\Admin\Photo\IndexPhotoRequest;
use App\Http\Requests\Admin\Photo\ReorderPhotoRequest;
use App\Http\Requests\Admin\Photo\StorePhotoRequest;
use App\Http\Requests\Admin\Photo\UpdatePhotoRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Services\Photo\PhotoService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class PhotoController extends Controller
{
    use ApiResponseTrait;

    /**
     * @param PhotoService $service
     */
    public function __construct(
        private readonly PhotoService $service
    ) {
    }

    /**
     * Get photos by photoable entity.
     *
     * @param IndexPhotoRequest $request
     * @return JsonResponse
     */
    public function index(IndexPhotoRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            $photos = $this->service->getByPhotoable(
                $validated['photoable_type'],
                $validated['photoable_id']
            );

            return $this->successResponse($photos->toArray(), __('admin/photos.messages.retrieved'));
        } catch (Exception $e) {
            return $this->errorResponse(__('admin/photos.messages.retrieve_failed') . ': ' . $e->getMessage(), 500);
        }
    }

    /**
     * Upload a new photo.
     *
     * @param StorePhotoRequest $request
     * @return JsonResponse
     */
    public function store(StorePhotoRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            $photo = $this->service->upload(
                $request->file('file'),
                $validated['photoable_type'] ?? null,
                $validated['photoable_id'] ?? null,
                [
                    'alt' => $validated['alt'] ?? null,
                    'is_primary' => $validated['is_primary'] ?? false,
                ]
            );

            return $this->createdResponse($photo->toArray(), __('admin/photos.messages.uploaded'));
        } catch (Exception $e) {
            return $this->errorResponse(__('admin/photos.messages.upload_failed') . ': ' . $e->getMessage(), 500);
        }
    }

    /**
     * Update photo metadata.
     *
     * @param UpdatePhotoRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(UpdatePhotoRequest $request, string $id): JsonResponse
    {
        try {
            $validated = $request->validated();
            $data = [];

            if (isset($validated['alt'])) {
                $data['alt'] = $validated['alt'];
            }
            if (isset($validated['is_primary'])) {
                $data['is_primary'] = $validated['is_primary'];
            }
            if (isset($validated['sort_order'])) {
                $data['sort_order'] = $validated['sort_order'];
            }

            $photo = $this->service->update($id, $data);

            return $this->successResponse($photo->toArray(), __('admin/photos.messages.updated'));
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse(__('admin/photos.messages.not_found'));
        } catch (Exception $e) {
            return $this->errorResponse(__('admin/photos.messages.update_failed') . ': ' . $e->getMessage(), 500);
        }
    }

    /**
     * Delete a photo.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $this->service->delete($id);

            return $this->successResponse(null, __('admin/photos.messages.deleted'));
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse(__('admin/photos.messages.not_found'));
        } catch (Exception $e) {
            return $this->errorResponse(__('admin/photos.messages.delete_failed') . ': ' . $e->getMessage(), 500);
        }
    }

    /**
     * Update sort orders for multiple photos.
     *
     * @param ReorderPhotoRequest $request
     * @return JsonResponse
     */
    public function reorder(ReorderPhotoRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            $this->service->updateSortOrders($validated['photos']);

            return $this->successResponse(null, __('admin/photos.messages.reordered'));
        } catch (Exception $e) {
            return $this->errorResponse(__('admin/photos.messages.reorder_failed') . ': ' . $e->getMessage(), 500);
        }
    }

    /**
     * Attach photos to a photoable entity.
     *
     * @param AttachPhotoRequest $request
     * @return JsonResponse
     */
    public function attach(AttachPhotoRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            $this->service->attachToPhotoable(
                $validated['photoable_type'],
                $validated['photoable_id'],
                $validated['photo_ids']
            );

            return $this->successResponse(null, __('admin/photos.messages.attached'));
        } catch (Exception $e) {
            return $this->errorResponse(__('admin/photos.messages.attach_failed') . ': ' . $e->getMessage(), 500);
        }
    }
}

