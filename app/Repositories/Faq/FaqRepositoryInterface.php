<?php

namespace App\Repositories\Faq;

use App\Models\Faq;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Interface for FAQ Repository
 */
interface FaqRepositoryInterface
{
    /**
     * Get all FAQs with pagination.
     *
     * @param array $allowedFilters
     * @param array $allowedSorts
     * @param string|null $defaultSort
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function search(
        array $allowedFilters = [],
        array $allowedSorts = [],
        ?string $defaultSort = null,
        int $perPage = 15
    ): LengthAwarePaginator;

    /**
     * Find FAQ by ID.
     *
     * @param int|string $id
     * @return Faq|null
     */
    public function findById(int|string $id): ?Faq;

    /**
     * Find FAQ by ID or fail.
     *
     * @param int|string $id
     * @return Faq
     * @throws ModelNotFoundException
     */
    public function findByIdOrFail(int|string $id): Faq;

    /**
     * Create a new FAQ.
     *
     * @param array $data
     * @return Faq
     */
    public function create(array $data): Faq;

    /**
     * Update an existing FAQ.
     *
     * @param int|string $id
     * @param array $data
     * @return Faq
     */
    public function update(int|string $id, array $data): Faq;

    /**
     * Delete a FAQ.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;
}
