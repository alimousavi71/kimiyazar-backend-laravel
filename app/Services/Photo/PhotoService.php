<?php

namespace App\Services\Photo;

use App\Models\Photo;
use App\Repositories\Photo\PhotoRepositoryInterface;
use App\Services\ImageService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;

/**
 * Service class for Photo business logic
 */
class PhotoService
{
    /**
     * @param PhotoRepositoryInterface $repository
     * @param ImageService $imageService
     */
    public function __construct(
        private readonly PhotoRepositoryInterface $repository,
        private readonly ImageService $imageService
    ) {
    }

    /**
     * Get photos by photoable entity.
     *
     * @param string $photoableType
     * @param int|string $photoableId
     * @return Collection
     */
    public function getByPhotoable(string $photoableType, int|string $photoableId): Collection
    {
        return $this->repository->getByPhotoable($photoableType, $photoableId);
    }

    /**
     * Upload and create a photo.
     *
     * @param UploadedFile $file
     * @param string|null $photoableType
     * @param int|string|null $photoableId
     * @param array $metadata
     * @return Photo
     */
    public function upload(UploadedFile $file, ?string $photoableType = null, int|string|null $photoableId = null, array $metadata = []): Photo
    {
        // Get image dimensions
        $imageInfo = getimagesize($file->getRealPath());
        $width = $imageInfo[0] ?? null;
        $height = $imageInfo[1] ?? null;

        // Upload image using ImageService
        $filePath = $this->imageService->upload($file, 'large', 'photos');

        // Get next sort order
        $sortOrder = 0;
        if ($photoableType && $photoableId) {
            $existingPhotos = $this->repository->getByPhotoable($photoableType, $photoableId);
            $maxSortOrder = $existingPhotos->max('sort_order');
            $sortOrder = $maxSortOrder !== null ? $maxSortOrder + 1 : 0;
        }

        // Prepare photo data
        $data = [
            'photoable_type' => $photoableType,
            'photoable_id' => $photoableId,
            'file_path' => $filePath,
            'file_name' => basename($filePath),
            'original_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'width' => $width,
            'height' => $height,
            'alt' => $metadata['alt'] ?? null,
            'sort_order' => $sortOrder,
            'is_primary' => $metadata['is_primary'] ?? false,
        ];

        // If setting as primary, unset other primaries
        if ($data['is_primary'] && $photoableType && $photoableId) {
            Photo::where('photoable_type', $photoableType)
                ->where('photoable_id', $photoableId)
                ->update(['is_primary' => false]);
        }

        return $this->repository->create($data);
    }

    /**
     * Update photo metadata.
     *
     * @param int|string $id
     * @param array $data
     * @return Photo
     */
    public function update(int|string $id, array $data): Photo
    {
        // If setting as primary, unset other primaries
        if (isset($data['is_primary']) && $data['is_primary']) {
            $photo = $this->repository->findByIdOrFail($id);
            if ($photo->photoable_type && $photo->photoable_id) {
                Photo::where('photoable_type', $photo->photoable_type)
                    ->where('photoable_id', $photo->photoable_id)
                    ->where('id', '!=', $id)
                    ->update(['is_primary' => false]);
            }
        }

        return $this->repository->update($id, $data);
    }

    /**
     * Delete a photo.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        $photo = $this->repository->findByIdOrFail($id);

        // Delete file from storage
        if ($photo->file_path) {
            $this->imageService->delete($photo->file_path);
        }

        return $this->repository->delete($id);
    }

    /**
     * Update sort orders for photos.
     *
     * @param array $photoOrders Array of ['id' => photo_id, 'sort_order' => order]
     * @return void
     */
    public function updateSortOrders(array $photoOrders): void
    {
        $this->repository->updateSortOrders($photoOrders);
    }

    /**
     * Attach photos to a photoable entity.
     *
     * @param string $photoableType
     * @param int|string $photoableId
     * @param array $photoIds
     * @return void
     */
    public function attachToPhotoable(string $photoableType, int|string $photoableId, array $photoIds): void
    {
        Photo::whereIn('id', $photoIds)
            ->update([
                'photoable_type' => $photoableType,
                'photoable_id' => $photoableId,
            ]);
    }
}

