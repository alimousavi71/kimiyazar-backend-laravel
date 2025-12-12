<?php

namespace App\Services\Admin;

use App\Models\Admin;
use App\Repositories\Admin\AdminRepositoryInterface;
use App\Services\ImageService;
use Illuminate\Http\UploadedFile;

/**
 * Service class for Admin Avatar operations
 */
class AdminAvatarService
{
    /**
     * @param AdminRepositoryInterface $repository
     * @param ImageService $imageService
     */
    public function __construct(
        private readonly AdminRepositoryInterface $repository,
        private readonly ImageService $imageService
    ) {
    }

    /**
     * Upload avatar for an admin.
     *
     * @param int|string $id
     * @param UploadedFile $file
     * @return string
     */
    public function upload(int|string $id, UploadedFile $file): string
    {
        $admin = $this->repository->findByIdOrFail($id);

        // Delete old avatar if exists
        if ($admin->avatar) {
            $this->imageService->delete($admin->avatar);
        }

        // Upload and process image using ImageService with avatar preset
        $avatarPath = $this->imageService->upload($file, 'avatar', 'admin/avatars');

        // Update admin with new avatar path
        $this->repository->update($id, ['avatar' => $avatarPath]);

        return $avatarPath;
    }

    /**
     * Delete avatar for an admin.
     *
     * @param int|string $id
     * @return void
     */
    public function delete(int|string $id): void
    {
        $admin = $this->repository->findByIdOrFail($id);

        if ($admin->avatar) {
            $this->imageService->delete($admin->avatar);
            $this->repository->update($id, ['avatar' => null]);
        }
    }

    /**
     * Get admin by ID.
     *
     * @param int|string $id
     * @return Admin
     */
    public function getAdmin(int|string $id): Admin
    {
        return $this->repository->findByIdOrFail($id);
    }

}

