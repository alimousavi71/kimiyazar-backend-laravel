<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Admin\UploadAvatarRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Services\Admin\AdminAvatarService;
use Exception;
use Illuminate\Http\JsonResponse;

class AdminAvatarController extends Controller
{
    use ApiResponseTrait;

    /**
     * @param AdminAvatarService $service
     */
    public function __construct(
        private readonly AdminAvatarService $service
    ) {
    }

    /**
     * Upload avatar for the specified admin or authenticated admin.
     *
     * @param UploadAvatarRequest $request
     * @param string|null $id
     * @return JsonResponse
     */
    public function upload(UploadAvatarRequest $request, ?string $id = null): JsonResponse
    {
        try {
            // If no ID provided, use authenticated admin's ID
            if (!$id) {
                $admin = auth('admin')->user() ?? auth()->user();
                $id = $admin->id;
            }

            $avatarPath = $this->service->upload($id, $request->file('avatar'));
            $admin = $this->service->getAdmin($id);

            return $this->successResponse(
                [
                    'avatar' => $avatarPath,
                    'avatar_url' => $admin->avatar ? asset('storage/' . $admin->avatar) : null,
                ],
                'Avatar uploaded successfully.'
            );
        } catch (Exception $e) {
            return $this->errorResponse('Failed to upload avatar: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Delete avatar for the specified admin or authenticated admin.
     *
     * @param string|null $id
     * @return JsonResponse
     */
    public function delete(?string $id = null): JsonResponse
    {
        try {
            // If no ID provided, use authenticated admin's ID
            if (!$id) {
                $admin = auth('admin')->user() ?? auth()->user();
                $id = $admin->id;
            }

            $this->service->delete($id);

            return $this->successResponse(null, 'Avatar deleted successfully.');
        } catch (Exception $e) {
            return $this->errorResponse('Failed to delete avatar: ' . $e->getMessage(), 500);
        }
    }
}

