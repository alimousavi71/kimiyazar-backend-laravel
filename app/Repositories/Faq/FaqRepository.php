<?php

namespace App\Repositories\Faq;

use App\Models\Faq;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Repository implementation for FAQ model
 */
class FaqRepository implements FaqRepositoryInterface
{
    /**
     * Get all FAQs with pagination using QueryBuilder.
     *
     * @param array $allowedFilters Allowed filters configuration
     * @param array $allowedSorts   Allowed sorts configuration
     * @param string|null $defaultSort Default sort
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function search(
        array $allowedFilters = [],
        array $allowedSorts = [],
        ?string $defaultSort = null,
        int $perPage = 15
    ): LengthAwarePaginator {
        $query = QueryBuilder::for(Faq::class);

        if (!empty($allowedFilters)) {
            $query->allowedFilters($allowedFilters);
        }

        if (!empty($allowedSorts)) {
            $query->allowedSorts($allowedSorts);
        }

        if ($defaultSort !== null) {
            $query->defaultSort($defaultSort);
        }

        return $query->paginate($perPage);
    }

    /**
     * Find FAQ by ID.
     *
     * @param int|string $id
     * @return Faq|null
     */
    public function findById(int|string $id): ?Faq
    {
        return Faq::find($id);
    }

    /**
     * Find FAQ by ID or fail.
     *
     * @param int|string $id
     * @return Faq
     * @throws ModelNotFoundException
     */
    public function findByIdOrFail(int|string $id): Faq
    {
        return Faq::findOrFail($id);
    }

    /**
     * Create a new FAQ.
     *
     * @param array $data
     * @return Faq
     */
    public function create(array $data): Faq
    {
        return Faq::create($data);
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
        $faq = $this->findByIdOrFail($id);
        $faq->update($data);

        return $faq->fresh();
    }

    /**
     * Delete a FAQ.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        $faq = $this->findByIdOrFail($id);

        return $faq->delete();
    }
}
