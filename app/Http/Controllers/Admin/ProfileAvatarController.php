<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Admin\UploadAvatarRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Services\Admin\AdminAvatarService;
use Exception;
use Illuminate\Http\JsonResponse;

class ProfileAvatarController extends Controller
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
     * Upload avatar for the authenticated admin.
     *
     * @param UploadAvatarRequest $request
     * @return JsonResponse
     */
    public function upload(UploadAvatarRequest $request): JsonResponse
    {
        try {
            /** @var \App\Models\Admin $admin */
            $admin = auth('admin')->user();

            // Explicitly use authenticated admin's ID - no way to bypass
            $avatarPath = $this->service->upload($admin->id, $request->file('avatar'));
            $admin = $this->service->getAdmin($admin->id);

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
     * Delete avatar for the authenticated admin.
     *
     * @return JsonResponse
     */
    public function delete(): JsonResponse
    {
        try {
            /** @var \App\Models\Admin $admin */
            $admin = auth('admin')->user();

            // Explicitly use authenticated admin's ID - no way to bypass
            $this->service->delete($admin->id);

            return $this->successResponse(null, 'Avatar deleted successfully.');
        } catch (Exception $e) {
            return $this->errorResponse('Failed to delete avatar: ' . $e->getMessage(), 500);
        }
    }
}

