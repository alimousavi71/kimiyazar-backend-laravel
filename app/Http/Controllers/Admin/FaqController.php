<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Faq\StoreFaqRequest;
use App\Http\Requests\Admin\Faq\UpdateFaqRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Services\Faq\FaqService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqController extends Controller
{
    use ApiResponseTrait;

    /**
     * @param FaqService $service
     */
    public function __construct(
        private readonly FaqService $service
    ) {
    }

    /**
     * Display a listing of the FAQs.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $faqs = $this->service->search();

        return view('admin.faqs.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new FAQ.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.faqs.create');
    }

    /**
     * Store a newly created FAQ in storage.
     *
     * @param StoreFaqRequest $request
     * @return RedirectResponse
     */
    public function store(StoreFaqRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $this->service->create($validated);

        return redirect()
            ->route('admin.faqs.index')
            ->with('success', __('admin/faqs.messages.created'));
    }

    /**
     * Display the specified FAQ.
     *
     * @param string $id
     * @return View
     */
    public function show(string $id): View
    {
        $faq = $this->service->findById($id);

        return view('admin.faqs.show', compact('faq'));
    }

    /**
     * Show the form for editing the specified FAQ.
     *
     * @param string $id
     * @return View
     */
    public function edit(string $id): View
    {
        $faq = $this->service->findById($id);

        return view('admin.faqs.edit', compact('faq'));
    }

    /**
     * Update the specified FAQ in storage.
     *
     * @param UpdateFaqRequest $request
     * @param string $id
     * @return RedirectResponse
     */
    public function update(UpdateFaqRequest $request, string $id): RedirectResponse
    {
        $validated = $request->validated();

        $this->service->update($id, $validated);

        return redirect()
            ->route('admin.faqs.index')
            ->with('success', __('admin/faqs.messages.updated'));
    }

    /**
     * Remove the specified FAQ from storage.
     *
     * @param Request $request
     * @param string $id
     * @return JsonResponse|RedirectResponse
     */
    public function destroy(Request $request, string $id): JsonResponse|RedirectResponse
    {
        try {
            $this->service->delete($id);

            if ($request->expectsJson() || $request->wantsJson()) {
                return $this->successResponse(null, __('admin/faqs.messages.deleted'));
            }

            return redirect()
                ->route('admin.faqs.index')
                ->with('success', __('admin/faqs.messages.deleted'));
        } catch (ModelNotFoundException $e) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return $this->notFoundResponse(__('admin/faqs.messages.not_found'));
            }
            return redirect()
                ->route('admin.faqs.index')
                ->with('error', __('admin/faqs.messages.not_found'));
        } catch (Exception $e) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return $this->errorResponse(__('admin/faqs.messages.delete_failed') . ': ' . $e->getMessage(), 500);
            }
            return redirect()
                ->route('admin.faqs.index')
                ->with('error', __('admin/faqs.messages.delete_failed'));
        }
    }
}
