<?php

namespace App\Repositories\Photo;

use App\Models\Photo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Repository implementation for Photo model
 */
class PhotoRepository implements PhotoRepositoryInterface
{
    /**
     * Get photos by photoable entity.
     *
     * @param string $photoableType
     * @param int|string $photoableId
     * @return Collection
     */
    public function getByPhotoable(string $photoableType, int|string $photoableId): Collection
    {
        return Photo::where('photoable_type', $photoableType)
            ->where('photoable_id', $photoableId)
            ->ordered()
            ->get();
    }

    /**
     * Find photo by ID.
     *
     * @param int|string $id
     * @return Photo|null
     */
    public function findById(int|string $id): ?Photo
    {
        return Photo::find($id);
    }

    /**
     * Find photo by ID or fail.
     *
     * @param int|string $id
     * @return Photo
     * @throws ModelNotFoundException
     */
    public function findByIdOrFail(int|string $id): Photo
    {
        return Photo::findOrFail($id);
    }

    /**
     * Create a new photo.
     *
     * @param array $data
     * @return Photo
     */
    public function create(array $data): Photo
    {
        return Photo::create($data);
    }

    /**
     * Update an existing photo.
     *
     * @param int|string $id
     * @param array $data
     * @return Photo
     */
    public function update(int|string $id, array $data): Photo
    {
        $photo = $this->findByIdOrFail($id);
        $photo->update($data);

        return $photo->fresh();
    }

    /**
     * Delete a photo.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        $photo = $this->findByIdOrFail($id);

        return $photo->delete();
    }

    /**
     * Update sort order for multiple photos.
     *
     * @param array $photoOrders Array of ['id' => photo_id, 'sort_order' => order]
     * @return void
     */
    public function updateSortOrders(array $photoOrders): void
    {
        foreach ($photoOrders as $order) {
            Photo::where('id', $order['id'])
                ->update(['sort_order' => $order['sort_order']]);
        }
    }
}

