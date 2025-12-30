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
     * Upload avatar for the specified admin.
     *
     * @param UploadAvatarRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function upload(UploadAvatarRequest $request, string $id): JsonResponse
    {
        try {
            $avatarPath = $this->service->upload($id, $request->file('avatar'));
            $admin = $this->service->getAdmin($id);

            return $this->successResponse(
                [
                    'avatar' => $avatarPath,
                    'avatar_url' => $admin->avatar ? asset('storage/' . $admin->avatar) : null,
                ],
                __('admin/admins.messages.avatar_uploaded')
            );
        } catch (Exception $e) {
            return $this->errorResponse(__('admin/admins.messages.avatar_upload_failed'), 500);
        }
    }

    /**
     * Delete avatar for the specified admin.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function delete(string $id): JsonResponse
    {
        try {
            $this->service->delete($id);

            return $this->successResponse(null, __('admin/admins.messages.avatar_deleted'));
        } catch (Exception $e) {
            return $this->errorResponse(__('admin/admins.messages.avatar_delete_failed'), 500);
        }
    }
}

