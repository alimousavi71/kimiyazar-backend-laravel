<?php

namespace App\Services\Photo;

use App\Models\Photo;
use App\Repositories\Photo\PhotoRepositoryInterface;
use App\Services\ImageService;
use Illuminate\Database\Eloquent\Collection;
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
     * @param string|array|null $preset
     * @return Photo
     */
    public function upload(UploadedFile $file, ?string $photoableType = null, int|string|null $photoableId = null, array $metadata = [], string|array|null $preset = null): Photo
    {
        // Determine preset to use
        $preset = $preset ?? 'large';

        // Upload and process image with the specified preset
        $filePath = $this->imageService->upload($file, $preset, 'photos');

        // Get image dimensions
        $dimensions = $this->getImageDimensions($file, $filePath, $preset);

        // Get next sort order for this entity
        $sortOrder = $this->getNextSortOrder($photoableType, $photoableId);

        // Prepare photo data
        $data = [
            'photoable_type' => $photoableType,
            'photoable_id' => $photoableId,
            'file_path' => $filePath,
            'file_name' => basename($filePath),
            'original_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'width' => $dimensions['width'],
            'height' => $dimensions['height'],
            'alt' => $metadata['alt'] ?? null,
            'sort_order' => $sortOrder,
            'is_primary' => $metadata['is_primary'] ?? false,
        ];

        // If setting as primary, unset other primaries for this entity
        if ($data['is_primary'] && $photoableType && $photoableId) {
            $this->unsetOtherPrimaries($photoableType, $photoableId);
        }

        return $this->repository->create($data);
    }

    /**
     * Get image dimensions from preset config or processed file.
     *
     * @param UploadedFile $file
     * @param string $filePath
     * @param string|array $preset
     * @return array{width: int|null, height: int|null}
     */
    private function getImageDimensions(UploadedFile $file, string $filePath, string|array $preset): array
    {
        // Get preset configuration
        $presetConfig = is_array($preset) ? $preset : $this->getPresetConfig($preset);

        // If preset specifies dimensions, use them
        if (isset($presetConfig['width']) && isset($presetConfig['height'])) {
            return [
                'width' => $presetConfig['width'],
                'height' => $presetConfig['height'],
            ];
        }

        // Otherwise, read dimensions from the processed file
        $processedFilePath = storage_path('app/public/' . $filePath);
        if (file_exists($processedFilePath)) {
            $imageInfo = getimagesize($processedFilePath);
            return [
                'width' => $imageInfo[0] ?? null,
                'height' => $imageInfo[1] ?? null,
            ];
        }

        // Fallback to original file dimensions
        $imageInfo = getimagesize($file->getRealPath());
        return [
            'width' => $imageInfo[0] ?? null,
            'height' => $imageInfo[1] ?? null,
        ];
    }

    /**
     * Get the next sort order for photos of a given entity.
     *
     * @param string|null $photoableType
     * @param int|string|null $photoableId
     * @return int
     */
    private function getNextSortOrder(?string $photoableType, int|string|null $photoableId): int
    {
        if (!$photoableType || !$photoableId) {
            return 0;
        }

        $existingPhotos = $this->repository->getByPhotoable($photoableType, $photoableId);
        $maxSortOrder = $existingPhotos->max('sort_order');

        return $maxSortOrder !== null ? $maxSortOrder + 1 : 0;
    }

    /**
     * Unset primary flag for all other photos of the same entity.
     *
     * @param string $photoableType
     * @param int|string $photoableId
     * @return void
     */
    private function unsetOtherPrimaries(string $photoableType, int|string $photoableId): void
    {
        Photo::where('photoable_type', $photoableType)
            ->where('photoable_id', $photoableId)
            ->update(['is_primary' => false]);
    }

    /**
     * Get preset configuration.
     *
     * @param string $preset
     * @return array
     */
    private function getPresetConfig(string $preset): array
    {
        $presets = config('image.presets', []);

        if (isset($presets[$preset])) {
            return $presets[$preset];
        }

        // Return default config
        return config('image.default', [
            'quality' => 90,
            'format' => 'jpg',
        ]);
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

