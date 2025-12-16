<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Services\Auth\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        private readonly AuthService $authService,
    ) {
    }

    /**
     * Show login form.
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Process login request.
     */
    public function login(LoginRequest $request): RedirectResponse|JsonResponse
    {
        try {
            $result = $this->authService->login(
                $request->input('email_or_phone'),
                $request->input('password')
            );

            if (!$result['success']) {
                if ($request->expectsJson()) {
                    return $this->errorResponse(
                        $result['message'],
                        401,
                        ['email_or_phone' => $result['message']]
                    );
                }

                return back()
                    ->withInput($request->only('email_or_phone'))
                    ->with('error', $result['message']);
            }

            // Perform login
            $this->authService->performLogin(
                $result['user'],
                $request->boolean('remember', false)
            );

            if ($request->expectsJson()) {
                return $this->successResponse(
                    ['user' => $result['user']],
                    __('auth.messages.login_successful')
                );
            }

            return redirect()->intended('/')
                ->with('success', __('auth.messages.login_successful'));
        } catch (Exception $e) {
            \Log::error('Login error: ' . $e->getMessage());

            return $this->respondError(
                ['error' => 'Login failed'],
                'An error occurred during login',
                500
            );
        }
    }

    /**
     * Process logout request.
     */
    public function logout(Request $request): RedirectResponse|JsonResponse
    {
        try {
            Auth::guard('web')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            if ($request->expectsJson()) {
                return $this->successResponse(
                    null,
                    __('auth.messages.logout_successful')
                );
            }

            return redirect()->route('auth.login')
                ->with('success', __('auth.messages.logout_successful'));
        } catch (Exception $e) {
            \Log::error('Logout error: ' . $e->getMessage());

            return $this->respondError(
                ['error' => 'Logout failed'],
                'An error occurred during logout',
                500
            );
        }
    }
}
