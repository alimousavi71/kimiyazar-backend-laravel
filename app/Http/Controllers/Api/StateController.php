<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Models\State;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StateController extends Controller
{
    use ApiResponseTrait;

    /**
     * Search states for Select2 dropdown.
     */
    public function search(Request $request): JsonResponse
    {
        $search = $request->input('q', '');
        $countryId = $request->input('country_id');
        
        $states = State::query()
            ->when($countryId, function ($query) use ($countryId) {
                return $query->where('country_id', $countryId);
            })
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->limit(50)
            ->get()
            ->map(fn($state) => [
                'id' => $state->id,
                'name' => $state->name,
                'text' => $state->name,
            ]);
        
        return $this->successResponse($states);
    }
}
