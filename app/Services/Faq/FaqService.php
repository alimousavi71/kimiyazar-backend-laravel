<?php

namespace App\Services\Faq;

use App\Models\Faq;
use App\Repositories\Faq\FaqRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * Service class for FAQ business logic
 */
class FaqService
{
    /**
     * @param FaqRepositoryInterface $repository
     */
    public function __construct(
        private readonly FaqRepositoryInterface $repository
    ) {
    }

    /**
     * Get all FAQs with optional filters using QueryBuilder.
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function search(int $perPage = 15): LengthAwarePaginator
    {
        $allowedFilters = [
            AllowedFilter::partial('question'),
            AllowedFilter::partial('answer'),
            AllowedFilter::exact('is_published'),
            AllowedFilter::callback('search', function ($query, $value) {
                $query->where(function ($q) use ($value) {
                    $q->where('question', 'like', "%{$value}%")
                        ->orWhere('answer', 'like', "%{$value}%");
                });
            }),
        ];

        $allowedSorts = [
            'id',
            'question',
            'is_published',
            'created_at',
            'updated_at',
        ];

        $defaultSort = '-created_at';

        return $this->repository->search($allowedFilters, $allowedSorts, $defaultSort, $perPage);
    }

    /**
     * Find FAQ by ID.
     *
     * @param int|string $id
     * @return Faq
     * @throws ModelNotFoundException
     */
    public function findById(int|string $id): Faq
    {
        return $this->repository->findByIdOrFail($id);
    }

    /**
     * Create a new FAQ.
     *
     * @param array $data
     * @return Faq
     */
    public function create(array $data): Faq
    {
        if (isset($data['is_published']) && is_bool($data['is_published'])) {
            $data['is_published'] = $data['is_published'] ? 1 : 0;
        }

        return $this->repository->create($data);
    }

    /**
     * Update an existing FAQ.
     *
     * @param int|string $id
     * @param array $data
     * @return Faq
     */
    public function update(int|string $id, array $data): Faq
    {
        if (isset($data['is_published']) && is_bool($data['is_published'])) {
            $data['is_published'] = $data['is_published'] ? 1 : 0;
        }

        return $this->repository->update($id, $data);
    }

    /**
     * Delete a FAQ.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        return $this->repository->delete($id);
    }
}
