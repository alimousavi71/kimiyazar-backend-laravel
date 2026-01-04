<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ModalController extends Controller
{
    use ApiResponseTrait;

    /**
     * Handle "don't show again" request for a modal.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function dontShowAgain(Request $request): JsonResponse
    {
        $request->validate([
            'modal_id' => 'required|integer|exists:modals,id',
        ]);

        $modalId = $request->input('modal_id');
        $cookieName = "modal_{$modalId}_dismissed";
        
        // Set cookie for 1 year
        $cookie = Cookie::make($cookieName, '1', 525600); // 1 year in minutes

        return $this->successResponse(
            ['message' => 'Modal will not be shown again'],
            200,
            [$cookie]
        );
    }
}
