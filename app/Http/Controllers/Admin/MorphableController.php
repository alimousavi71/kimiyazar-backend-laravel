<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MorphableController extends Controller
{
    use ApiResponseTrait;

    /**
     * Search for items of a specific morphable type.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'type' => ['required', 'string'],
            'query' => ['nullable', 'string', 'min:' . config('morphable.min_search_length', 2)],
            'limit' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $type = $request->input('type');
        $query = $request->input('query', '');
        $limit = $request->input('limit', config('morphable.default_limit', 50));

        // Validate type is allowed
        $allowedTypes = config('morphable.types', []);
        if (!array_key_exists($type, $allowedTypes)) {
            return $this->errorResponse(__('morphable.invalid_type'), 400);
        }

        $config = $allowedTypes[$type];
        $modelClass = $type;

        // Validate that the class exists and is a valid model
        if (!class_exists($modelClass) || !is_subclass_of($modelClass, \Illuminate\Database\Eloquent\Model::class)) {
            return $this->errorResponse(__('morphable.invalid_type'), 400);
        }

        // Build query
        $queryBuilder = $modelClass::query();

        // Apply search filters
        if (!empty($query)) {
            $queryBuilder->where(function ($q) use ($query, $config) {
                foreach ($config['search_fields'] as $field) {
                    $q->orWhere($field, 'like', "%{$query}%");
                }
            });
        }

        // Get results
        $results = $queryBuilder->limit($limit)->get();

        // Format results
        $formattedResults = $results->map(function ($item) use ($config) {
            $result = [
                'id' => $item->id,
                'text' => $item->{$config['display_field']},
            ];

            // Add metadata fields
            if (!empty($config['metadata_fields'])) {
                $result['metadata'] = [];
                foreach ($config['metadata_fields'] as $field) {
                    $result['metadata'][$field] = data_get($item, $field);
                }
            }

            // Add image if configured
            if (!empty($config['image_field'])) {
                $result['image'] = data_get($item, $config['image_field']);
            }

            return $result;
        });

        return $this->successResponse($formattedResults, __('morphable.results_retrieved'));
    }
}
