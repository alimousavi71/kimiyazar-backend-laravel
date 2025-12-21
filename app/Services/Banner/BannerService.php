<?php

namespace App\Services\Banner;

use App\Enums\Database\BannerPosition;
use App\Models\Banner;
use App\Repositories\Banner\BannerRepositoryInterface;
use App\Services\ImageService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * Service class for Banner business logic
 */
class BannerService
{
    /**
     * @param BannerRepositoryInterface $repository
     * @param ImageService $imageService
     */
    public function __construct(
        private readonly BannerRepositoryInterface $repository,
        private readonly ImageService $imageService
    ) {
    }

    /**
     * Get all banners with optional filters using QueryBuilder.
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function search(int $perPage = 15): LengthAwarePaginator
    {
        $allowedFilters = [
            AllowedFilter::partial('name'),
            AllowedFilter::exact('position'),
            AllowedFilter::exact('is_active'),
            AllowedFilter::exact('target_type'),
            AllowedFilter::callback('search', function ($query, $value) {
                $query->where(function ($q) use ($value) {
                    $q->where('name', 'like', "%{$value}%")
                        ->orWhere('link', 'like', "%{$value}%");
                });
            }),
        ];

        $allowedSorts = [
            'id',
            'name',
            'position',
            'is_active',
            'created_at',
            'updated_at',
        ];

        $defaultSort = '-created_at';

        return $this->repository->search($allowedFilters, $allowedSorts, $defaultSort, $perPage);
    }

    /**
     * Find banner by ID.
     *
     * @param int|string $id
     * @return Banner
     * @throws ModelNotFoundException
     */
    public function findById(int|string $id): Banner
    {
        return $this->repository->findByIdOrFail($id);
    }

    /**
     * Create a new banner.
     *
     * @param array $data
     * @param UploadedFile|null $bannerFile
     * @return Banner
     */
    public function create(array $data, ?UploadedFile $bannerFile = null): Banner
    {
        // Handle banner file upload
        if ($bannerFile) {
            $position = BannerPosition::from($data['position']);
            $data['banner_file'] = $this->uploadBannerFile($bannerFile, $position);
        }

        // Handle target morph relationship
        if (empty($data['target_type']) || empty($data['target_id'])) {
            $data['target_type'] = null;
            $data['target_id'] = null;
        }

        if (isset($data['is_active']) && is_bool($data['is_active'])) {
            $data['is_active'] = $data['is_active'] ? 1 : 0;
        }

        return $this->repository->create($data);
    }

    /**
     * Update an existing banner.
     *
     * @param int|string $id
     * @param array $data
     * @param UploadedFile|null $bannerFile
     * @return Banner
     */
    public function update(int|string $id, array $data, ?UploadedFile $bannerFile = null): Banner
    {
        $banner = $this->repository->findByIdOrFail($id);

        // Handle banner file upload
        if ($bannerFile) {
            // Delete old banner file if exists
            if ($banner->banner_file) {
                $this->imageService->delete($banner->banner_file);
            }

            $position = isset($data['position'])
                ? BannerPosition::from($data['position'])
                : $banner->position;
            $data['banner_file'] = $this->uploadBannerFile($bannerFile, $position);
        }

        // Handle target morph relationship
        if (isset($data['target_type']) && empty($data['target_type'])) {
            $data['target_type'] = null;
            $data['target_id'] = null;
        }

        if (isset($data['is_active']) && is_bool($data['is_active'])) {
            $data['is_active'] = $data['is_active'] ? 1 : 0;
        }

        return $this->repository->update($id, $data);
    }

    /**
     * Delete a banner.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        $banner = $this->repository->findByIdOrFail($id);

        // Delete banner file if exists
        if ($banner->banner_file) {
            $this->imageService->delete($banner->banner_file);
        }

        return $this->repository->delete($id);
    }

    /**
     * Upload banner file with position-specific dimensions.
     *
     * @param UploadedFile $file
     * @param BannerPosition $position
     * @return string
     */
    private function uploadBannerFile(UploadedFile $file, BannerPosition $position): string
    {
        $presetConfig = $this->getPositionPreset($position);

        return $this->imageService->upload($file, $presetConfig, 'banners');
    }

    /**
     * Get preset configuration for a banner position.
     *
     * @param BannerPosition $position
     * @return array{width: int, height: int, fit: string, quality: int, format: string}
     */
    private function getPositionPreset(BannerPosition $position): array
    {
        $positions = config('banner.positions', []);

        return $positions[$position->value] ?? [
            'width' => 1200,
            'height' => 300,
            'fit' => 'cover',
            'quality' => 90,
            'format' => 'jpg',
        ];
    }

    /**
     * Get position dimensions for display.
     *
     * @param BannerPosition $position
     * @return array{width: int, height: int}
     */
    public function getPositionDimensionsForDisplay(BannerPosition $position): array
    {
        $preset = $this->getPositionPreset($position);

        return [
            'width' => $preset['width'],
            'height' => $preset['height'],
        ];
    }

    /**
     * Get active banners by positions.
     *
     * @param array<BannerPosition> $positions
     * @param int|null $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActiveBannersByPositions(array $positions, ?int $limit = null): \Illuminate\Database\Eloquent\Collection
    {
        $query = Banner::whereIn('position', array_map(fn($p) => $p->value, $positions))
            ->where('is_active', true)
            ->orderBy('created_at', 'desc');

        if ($limit !== null) {
            $query->limit($limit);
        }

        return $query->get();
    }
}

