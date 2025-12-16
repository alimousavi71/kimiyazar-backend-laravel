<?php

namespace App\Repositories\Photo;

use App\Models\Photo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Interface for Photo Repository
 */
interface PhotoRepositoryInterface
{
    /**
     * Get photos by photoable entity.
     *
     * @param string $photoableType
     * @param int|string $photoableId
     * @return Collection
     */
    public function getByPhotoable(string $photoableType, int|string $photoableId): Collection;

    /**
     * Find photo by ID.
     *
     * @param int|string $id
     * @return Photo|null
     */
    public function findById(int|string $id): ?Photo;

    /**
     * Find photo by ID or fail.
     *
     * @param int|string $id
     * @return Photo
     * @throws ModelNotFoundException
     */
    public function findByIdOrFail(int|string $id): Photo;

    /**
     * Create a new photo.
     *
     * @param array $data
     * @return Photo
     */
    public function create(array $data): Photo;

    /**
     * Update an existing photo.
     *
     * @param int|string $id
     * @param array $data
     * @return Photo
     */
    public function update(int|string $id, array $data): Photo;

    /**
     * Delete a photo.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;

    /**
     * Update sort order for multiple photos.
     *
     * @param array $photoOrders Array of ['id' => photo_id, 'sort_order' => order]
     * @return void
     */
    public function updateSortOrders(array $photoOrders): void;
}

