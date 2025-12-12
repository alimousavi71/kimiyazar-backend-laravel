<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\PasswordResetRequest;
use App\Http\Requests\Admin\Auth\PasswordResetEmailRequest;
use App\Models\Admin;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Illuminate\Support\Str;

class AdminPasswordResetController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // Middleware is applied in routes
    }

    /**
     * Show the form for requesting a password reset link.
     *
     * @return View
     */
    public function showLinkRequestForm(): View
    {
        return view('admin.auth.forgot-password');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param PasswordResetEmailRequest $request
     * @return RedirectResponse
     */
    public function sendResetLinkEmail(PasswordResetEmailRequest $request): RedirectResponse
    {
        $status = Password::broker('admins')->sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        return back()->withErrors(['email' => __($status)]);
    }

    /**
     * Display the password reset view for the given token.
     *
     * @param string $token
     * @return View
     */
    public function showResetForm(string $token): View
    {
        return view('admin.auth.reset-password', ['token' => $token]);
    }

    /**
     * Reset the user's password.
     *
     * @param PasswordResetRequest $request
     * @return RedirectResponse
     */
    public function reset(PasswordResetRequest $request): RedirectResponse
    {
        $status = Password::broker('admins')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (Admin $admin, string $password) {
                $admin->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $admin->save();

                event(new PasswordReset($admin));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('admin.login')->with('status', __($status));
        }

        return back()->withErrors(['email' => [__($status)]]);
    }
}

