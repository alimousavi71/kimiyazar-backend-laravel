<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Bank\StoreBankRequest;
use App\Http\Requests\Admin\Bank\UpdateBankRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Services\Bank\BankService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BankController extends Controller
{
    use ApiResponseTrait;

    /**
     * @param BankService $service
     */
    public function __construct(
        private readonly BankService $service
    ) {
    }

    /**
     * Display a listing of banks.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $banks = $this->service->search();

        return view('admin.banks.index', compact('banks'));
    }

    /**
     * Show the form for creating a new bank.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.banks.create');
    }

    /**
     * Store a newly created bank in storage.
     *
     * @param StoreBankRequest $request
     * @return RedirectResponse
     */
    public function store(StoreBankRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $this->service->create($validated);

        return redirect()
            ->route('admin.banks.index')
            ->with('success', __('admin/banks.messages.created'));
    }

    /**
     * Display the specified bank.
     *
     * @param string $id
     * @return View
     */
    public function show(string $id): View
    {
        $bank = $this->service->findById($id);

        return view('admin.banks.show', compact('bank'));
    }

    /**
     * Show the form for editing the specified bank.
     *
     * @param string $id
     * @return View
     */
    public function edit(string $id): View
    {
        $bank = $this->service->findById($id);

        return view('admin.banks.edit', compact('bank'));
    }

    /**
     * Update the specified bank in storage.
     *
     * @param UpdateBankRequest $request
     * @param string $id
     * @return RedirectResponse
     */
    public function update(UpdateBankRequest $request, string $id): RedirectResponse
    {
        $validated = $request->validated();
        $this->service->update($id, $validated);

        return redirect()
            ->route('admin.banks.index')
            ->with('success', __('admin/banks.messages.updated'));
    }

    /**
     * Remove the specified bank from storage.
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
                return $this->successResponse(null, __('admin/banks.messages.deleted'));
            }

            return redirect()
                ->route('admin.banks.index')
                ->with('success', __('admin/banks.messages.deleted'));
        } catch (ModelNotFoundException $e) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return $this->notFoundResponse(__('admin/banks.messages.not_found'));
            }
            return redirect()
                ->route('admin.banks.index')
                ->with('error', __('admin/banks.messages.not_found'));
        } catch (Exception $e) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return $this->errorResponse(__('admin/banks.messages.delete_failed'), 500);
            }
            return redirect()
                ->route('admin.banks.index')
                ->with('error', __('admin/banks.messages.delete_failed'));
        }
    }
}
