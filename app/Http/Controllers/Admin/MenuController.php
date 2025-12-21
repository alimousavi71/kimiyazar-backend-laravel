<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Menu\StoreMenuRequest;
use App\Http\Requests\Admin\Menu\UpdateMenuRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Services\Menu\MenuService;
use App\Services\Content\ContentService;
use App\Models\Content;
use App\Enums\Database\ContentType;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuController extends Controller
{
    use ApiResponseTrait;

    /**
     * @param MenuService $service
     * @param ContentService $contentService
     */
    public function __construct(
        private readonly MenuService $service,
        private readonly ContentService $contentService
    ) {
    }

    /**
     * Display a listing of the menus.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $menus = $this->service->search();

        return view('admin.menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new menu.
     *
     * @return View
     */
    public function create(): View
    {
        // Get active content pages for dropdown (only pages and articles)
        $contents = Content::whereIn('type', [ContentType::PAGE, ContentType::ARTICLE])
            ->where('is_active', true)
            ->orderBy('title')
            ->get();

        return view('admin.menus.create', compact('contents'));
    }

    /**
     * Store a newly created menu in storage.
     *
     * @param StoreMenuRequest $request
     * @return RedirectResponse
     */
    public function store(StoreMenuRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $this->service->create($validated);

        return redirect()
            ->route('admin.menus.index')
            ->with('success', __('admin/menus.messages.created'));
    }

    /**
     * Display the specified menu.
     *
     * @param string $id
     * @return View
     */
    public function show(string $id): View
    {
        $menu = $this->service->findById($id);

        return view('admin.menus.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified menu.
     *
     * @param string $id
     * @return View
     */
    public function edit(string $id): View
    {
        $menu = $this->service->findById($id);

        // Get active content pages for dropdown (only pages and articles)
        $contents = Content::whereIn('type', [ContentType::PAGE, ContentType::ARTICLE])
            ->where('is_active', true)
            ->orderBy('title')
            ->get();

        return view('admin.menus.edit', compact('menu', 'contents'));
    }

    /**
     * Update the specified menu in storage.
     *
     * @param UpdateMenuRequest $request
     * @param string $id
     * @return RedirectResponse
     */
    public function update(UpdateMenuRequest $request, string $id): RedirectResponse
    {
        $validated = $request->validated();

        $this->service->update($id, $validated);

        return redirect()
            ->route('admin.menus.index')
            ->with('success', __('admin/menus.messages.updated'));
    }

    /**
     * Remove the specified menu from storage.
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function destroy(string $id): RedirectResponse
    {
        try {
            $this->service->delete($id);

            return redirect()
                ->route('admin.menus.index')
                ->with('success', __('admin/menus.messages.deleted'));
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->route('admin.menus.index')
                ->with('error', __('admin/menus.messages.not_found'));
        } catch (Exception $e) {
            return redirect()
                ->route('admin.menus.index')
                ->with('error', __('admin/menus.messages.delete_failed'));
        }
    }

    /**
     * Update menu links order (AJAX).
     *
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function updateLinks(Request $request, string $id): JsonResponse
    {
        try {
            $request->validate([
                'links' => ['required', 'array'],
                'links.*.id' => ['required', 'string'],
                'links.*.title' => ['required', 'string', 'max:255'],
                'links.*.url' => ['required', 'string', 'max:500'],
                'links.*.type' => ['required', 'in:custom,content'],
                'links.*.content_id' => ['nullable', 'integer', 'exists:contents,id'],
                'links.*.order' => ['required', 'integer', 'min:1'],
            ]);

            $menu = $this->service->updateLinks($id, $request->input('links'));

            return $this->successResponse($menu->toArray(), __('admin/menus.messages.links_updated'));
        } catch (Exception $e) {
            return $this->errorResponse(__('admin/menus.messages.update_failed') . ': ' . $e->getMessage(), 500);
        }
    }
}
