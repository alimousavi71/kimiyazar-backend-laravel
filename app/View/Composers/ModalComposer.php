<?php

namespace App\View\Composers;

use App\Services\Modal\ModalService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ModalComposer
{
    /**
     * @param ModalService $modalService
     * @param Request $request
     */
    public function __construct(
        private readonly ModalService $modalService,
        private readonly Request $request
    ) {
    }

    /**
     * Bind active modals data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view): void
    {
        // Get all published and available modals
        $modals = $this->modalService->getPublishedModals();

        // Filter out modals that have been dismissed via cookies
        $modals = $modals->filter(function ($modal) {
            $cookieName = "modal_{$modal->id}_dismissed";
            return !$this->request->cookie($cookieName);
        });

        $view->with('activeModals', $modals);
    }
}
