<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Services\Tag\TagService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagController extends Controller
{
    use ApiResponseTrait;

    /**
     * @param TagService $service
     */
    public function __construct(
        private readonly TagService $service
    ) {
    }

    /**
     * Search tags.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $query = $request->input('query', '');
            $limit = (int) $request->input('limit', 20);

            $tags = $this->service->search($query, $limit);

            return $this->successResponse($tags->toArray(), __('admin/tags.messages.retrieved'));
        } catch (Exception $e) {
            return $this->errorResponse(__('admin/tags.messages.search_failed') . ': ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get tags by tagable entity.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'tagable_type' => ['required', 'string'],
                'tagable_id' => ['required', 'integer'],
            ]);

            $tags = $this->service->getByTagable(
                $request->input('tagable_type'),
                $request->input('tagable_id')
            );

            return $this->successResponse($tags->toArray(), __('admin/tags.messages.retrieved'));
        } catch (Exception $e) {
            return $this->errorResponse(__('admin/tags.messages.retrieve_failed') . ': ' . $e->getMessage(), 500);
        }
    }

    /**
     * Create or find a tag.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'title' => ['required', 'string', 'max:255'],
            ]);

            $tag = $this->service->createOrFind($request->input('title'));

            return $this->createdResponse($tag->toArray(), __('admin/tags.messages.created'));
        } catch (Exception $e) {
            return $this->errorResponse(__('admin/tags.messages.create_failed') . ': ' . $e->getMessage(), 500);
        }
    }

    /**
     * Attach tags to a tagable entity.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function attach(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'tagable_type' => ['required', 'string'],
                'tagable_id' => ['required', 'integer'],
                'tags' => ['required', 'array'],
                'tags.*.tag_id' => ['required', 'integer'],
                'tags.*.body' => ['nullable', 'string'],
            ]);

            $this->service->attachToTagable(
                $request->input('tagable_type'),
                $request->input('tagable_id'),
                $request->input('tags')
            );

            return $this->successResponse(null, __('admin/tags.messages.attached'));
        } catch (Exception $e) {
            return $this->errorResponse(__('admin/tags.messages.attach_failed') . ': ' . $e->getMessage(), 500);
        }
    }

    /**
     * Detach a tag from a tagable entity.
     *
     * @param Request $request
     * @param string $tagId
     * @return JsonResponse
     */
    public function detach(Request $request, string $tagId): JsonResponse
    {
        try {
            $request->validate([
                'tagable_type' => ['required', 'string'],
                'tagable_id' => ['required', 'integer'],
            ]);

            $this->service->detachFromTagable(
                $request->input('tagable_type'),
                $request->input('tagable_id'),
                $tagId
            );

            return $this->successResponse(null, __('admin/tags.messages.detached'));
        } catch (Exception $e) {
            return $this->errorResponse(__('admin/tags.messages.detach_failed') . ': ' . $e->getMessage(), 500);
        }
    }

    /**
     * Update tag body.
     *
     * @param Request $request
     * @param string $tagableId
     * @return JsonResponse
     */
    public function updateBody(Request $request, string $tagableId): JsonResponse
    {
        try {
            $request->validate([
                'tag_id' => ['required', 'integer'],
                'body' => ['nullable', 'string'],
            ]);

            $this->service->updateTagBody(
                $tagableId,
                $request->input('tag_id'),
                $request->input('body')
            );

            return $this->successResponse(null, __('admin/tags.messages.body_updated'));
        } catch (Exception $e) {
            return $this->errorResponse(__('admin/tags.messages.update_failed') . ': ' . $e->getMessage(), 500);
        }
    }
}
