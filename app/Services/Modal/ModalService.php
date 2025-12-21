<?php

namespace App\Services\Modal;

use App\Models\Modal;
use App\Repositories\Modal\ModalRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * Service class for Modal business logic
 */
class ModalService
{
    /**
     * @param ModalRepositoryInterface $repository
     */
    public function __construct(
        private readonly ModalRepositoryInterface $repository
    ) {
    }

    /**
     * Get all modals with optional filters using QueryBuilder.
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function search(int $perPage = 15): LengthAwarePaginator
    {
        $allowedFilters = [
            AllowedFilter::partial('title'),
            AllowedFilter::exact('is_published'),
            AllowedFilter::exact('priority'),
            AllowedFilter::partial('modalable_type'),
            AllowedFilter::callback('search', function ($query, $value) {
                $query->where(function ($q) use ($value) {
                    $q->where('title', 'like', "%{$value}%")
                        ->orWhere('content', 'like', "%{$value}%");
                });
            }),
        ];

        $allowedSorts = [
            'id',
            'title',
            'is_published',
            'priority',
            'start_at',
            'end_at',
            'created_at',
            'updated_at',
        ];

        $defaultSort = '-priority';

        return $this->repository->search($allowedFilters, $allowedSorts, $defaultSort, $perPage);
    }

    /**
     * Find modal by ID.
     *
     * @param int|string $id
     * @return Modal
     * @throws ModelNotFoundException
     */
    public function findById(int|string $id): Modal
    {
        return $this->repository->findByIdOrFail($id);
    }

    /**
     * Create a new modal.
     *
     * @param array $data
     * @return Modal
     */
    public function create(array $data): Modal
    {
        if (!isset($data['priority'])) {
            $data['priority'] = 0;
        }

        if (isset($data['is_published']) && is_bool($data['is_published'])) {
            $data['is_published'] = $data['is_published'] ? 1 : 0;
        }

        if (isset($data['is_rememberable']) && is_bool($data['is_rememberable'])) {
            $data['is_rememberable'] = $data['is_rememberable'] ? 1 : 0;
        }

        return $this->repository->create($data);
    }

    /**
     * Update an existing modal.
     *
     * @param int|string $id
     * @param array $data
     * @return Modal
     */
    public function update(int|string $id, array $data): Modal
    {
        if (!isset($data['priority'])) {
            $data['priority'] = 0;
        }

        if (isset($data['is_published']) && is_bool($data['is_published'])) {
            $data['is_published'] = $data['is_published'] ? 1 : 0;
        }

        if (isset($data['is_rememberable']) && is_bool($data['is_rememberable'])) {
            $data['is_rememberable'] = $data['is_rememberable'] ? 1 : 0;
        }

        return $this->repository->update($id, $data);
    }

    /**
     * Delete a modal.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        return $this->repository->delete($id);
    }

    /**
     * Get published modals with proper ordering.
     *
     * @return Collection
     */
    public function getPublishedModals(): Collection
    {
        return Modal::published()
            ->withinDateRange()
            ->ordered()
            ->get();
    }

    /**
     * Get modals for a specific modalable model.
     *
     * @param string $modalableType
     * @param int|null $modalableId
     * @return Collection
     */
    public function getForModalable(string $modalableType, ?int $modalableId = null): Collection
    {
        return Modal::forModalable($modalableType, $modalableId)
            ->published()
            ->withinDateRange()
            ->ordered()
            ->get();
    }
}
