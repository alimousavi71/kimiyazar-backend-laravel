<?php

namespace App\Repositories\PriceInquiry;

use App\Models\PriceInquiry;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;

class PriceInquiryRepository implements PriceInquiryRepositoryInterface
{
    public function search(array $allowedFilters, array $allowedSorts, string $defaultSort, int $perPage = 15): LengthAwarePaginator
    {
        $query = QueryBuilder::for(PriceInquiry::class)
            ->with(['user'])
            ->allowedFilters($allowedFilters)
            ->allowedSorts($allowedSorts)
            ->defaultSort($defaultSort);

        return $query->paginate($perPage)->appends(request()->query());
    }

    public function findById(int|string $id): ?PriceInquiry
    {
        return PriceInquiry::with(['user'])->find($id);
    }

    public function findByIdOrFail(int|string $id): PriceInquiry
    {
        return PriceInquiry::with(['user'])->findOrFail($id);
    }

    public function create(array $data): PriceInquiry
    {
        return PriceInquiry::create($data);
    }

    public function update(int|string $id, array $data): PriceInquiry
    {
        $priceInquiry = $this->findByIdOrFail($id);
        $priceInquiry->update($data);

        return $priceInquiry->fresh();
    }

    public function delete(int|string $id): bool
    {
        $priceInquiry = $this->findByIdOrFail($id);

        return $priceInquiry->delete();
    }

    public function all()
    {
        return PriceInquiry::with(['user'])->get();
    }
}
