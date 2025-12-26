<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Country;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    use ApiResponseTrait;

    /**
     * Search countries for Select2 dropdown.
     */
    public function search(Request $request): JsonResponse
    {
        $search = $request->input('q', '');
        
        $countries = Country::query()
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('code', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->limit(50)
            ->get()
            ->map(fn($country) => [
                'id' => $country->id,
                'name' => $country->name,
                'text' => $country->name,
            ]);
        
        return $this->successResponse($countries);
    }
}
