<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

/**
 * Service class for image upload and manipulation
 */
class ImageService
{
    /**
     * @var ImageManager
     */
    private ImageManager $imageManager;

    /**
     * @param string|null $driver
     */
    public function __construct(?string $driver = null)
    {
        $driver = $driver ?? config('image.driver', 'gd');
        $this->imageManager = new ImageManager(new Driver());
    }

    /**
     * Upload and process image with preset configuration.
     *
     * @param UploadedFile $file
     * @param string|array $preset Preset name or custom preset config array
     * @param string $folder
     * @param string|null $filename
     * @return string
     */
    public function upload(UploadedFile $file, string|array $preset = 'default', string $folder = 'images', ?string $filename = null): string
    {
        $presetConfig = is_array($preset) ? $preset : $this->getPresetConfig($preset);

        // Generate filename if not provided
        if (!$filename) {
            $filename = $this->generateFilename($file, $presetConfig['format'] ?? 'jpg');
        }

        // Create full path
        $path = $folder . '/' . $filename;
        $fullPath = storage_path('app/public/' . $path);

        // Ensure directory exists
        $directory = dirname($fullPath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // Process image
        $image = $this->imageManager->read($file->getRealPath());

        // Apply fit/resize based on preset
        if (isset($presetConfig['width']) || isset($presetConfig['height'])) {
            $width = $presetConfig['width'] ?? null;
            $height = $presetConfig['height'] ?? null;
            $fit = $presetConfig['fit'] ?? 'contain';

            $image = $this->applyFit($image, $width, $height, $fit);
        }

        // Encode and save
        $quality = $presetConfig['quality'] ?? 90;
        $format = $presetConfig['format'] ?? 'jpg';

        if ($format === 'png') {
            $encoded = $image->toPng();
        } elseif ($format === 'webp') {
            $encoded = $image->toWebp($quality);
        } else {
            $encoded = $image->toJpeg($quality);
        }

        // Save encoded image to file
        $encoded->save($fullPath);

        return $path;
    }

    /**
     * Apply fit method to image.
     *
     * @param mixed $image
     * @param int|null $width
     * @param int|null $height
     * @param string $fit
     * @return mixed
     */
    private function applyFit($image, ?int $width, ?int $height, string $fit)
    {
        if ($width === null && $height === null) {
            return $image;
        }

        switch ($fit) {
            case 'cover':
                return $image->cover($width ?? $height, $height ?? $width);

            case 'contain':
                return $image->scale($width, $height);

            case 'fill':
                return $image->resize($width, $height);

            case 'inside':
                return $image->scaleDown($width, $height);

            case 'outside':
                // Scale to fit outside dimensions (will scale up if needed)
                return $image->scale($width, $height);

            default:
                return $image->scale($width, $height);
        }
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
     * Generate unique filename.
     *
     * @param UploadedFile $file
     * @param string $format
     * @return string
     */
    private function generateFilename(UploadedFile $file, string $format = 'jpg'): string
    {
        $extension = $file->getClientOriginalExtension();
        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $name = str_replace(' ', '_', $name);
        $name = preg_replace('/[^A-Za-z0-9_-]/', '', $name);

        return $name . '_' . time() . '_' . uniqid() . '.' . $format;
    }

    /**
     * Delete image from storage.
     *
     * @param string $path
     * @param string $disk
     * @return bool
     */
    public function delete(string $path, string $disk = 'public'): bool
    {
        if (Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->delete($path);
        }

        return false;
    }

    /**
     * Get image URL.
     *
     * @param string $path
     * @return string|null
     */
    public function url(string $path): ?string
    {
        if (empty($path)) {
            return null;
        }

        return asset('storage/' . $path);
    }
}

