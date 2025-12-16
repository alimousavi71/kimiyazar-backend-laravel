<?php

namespace App\Services\Contact;

use App\Models\Contact;
use App\Repositories\Contact\ContactRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * Service class for Contact business logic
 */
class ContactService
{
    /**
     * @param ContactRepositoryInterface $repository
     */
    public function __construct(
        private readonly ContactRepositoryInterface $repository
    ) {
    }

    /**
     * Get all contacts with optional filters using QueryBuilder.
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function search(int $perPage = 15): LengthAwarePaginator
    {
        $allowedFilters = [
            AllowedFilter::partial('title'),
            AllowedFilter::partial('email'),
            AllowedFilter::partial('mobile'),
            AllowedFilter::exact('is_read'),
            AllowedFilter::callback('search', function ($query, $value) {
                $query->where(function ($q) use ($value) {
                    $q->where('title', 'like', "%{$value}%")
                        ->orWhere('email', 'like', "%{$value}%")
                        ->orWhere('mobile', 'like', "%{$value}%")
                        ->orWhere('text', 'like', "%{$value}%");
                });
            }),
        ];

        $allowedSorts = [
            'id',
            'title',
            'email',
            'mobile',
            'is_read',
            'created_at',
            'updated_at',
        ];

        $defaultSort = '-created_at';

        return $this->repository->search($allowedFilters, $allowedSorts, $defaultSort, $perPage);
    }

    /**
     * Find contact by ID.
     *
     * @param int|string $id
     * @return Contact
     * @throws ModelNotFoundException
     */
    public function findById(int|string $id): Contact
    {
        $contact = $this->repository->findByIdOrFail($id);

        // Mark as read when viewing
        if (!$contact->is_read) {
            $contact->markAsRead();
        }

        return $contact;
    }
}

