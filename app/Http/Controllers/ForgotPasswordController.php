<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\EmailVerificationCodeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request, EmailVerificationCodeService $verificationCodes)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->input('email'))->first();

        if ($user === null) {
            return back()->withErrors([
                'email' => 'No account was found for this email address.',
            ])->withInput($request->only('email'));
        }

        if (! $user->hasVerifiedEmail()) {
            session()->put('verification_intent', 'password_reset');
            $verificationCodes->send($user);

            return redirect()->route('email.verification.code.form')
                ->with('success', 'We sent a verification code to your email address.')
                ->withInput($request->only('email'));
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function showVerificationCodeForm()
    {
        return view('auth.verify-email-code');
    }

    public function resendVerificationCode(Request $request, EmailVerificationCodeService $verificationCodes): RedirectResponse
    {
        $fields = $request->validate(['email' => ['required', 'email']]);
        $user = User::query()->where('email', $fields['email'])->first();

        if ($user === null || $user->hasVerifiedEmail()) {
            return back()->withErrors(['email' => 'A new verification code cannot be sent for this account.'])->withInput();
        }

        $verificationCodes->send($user);

        return redirect()->route('email.verification.code.form')
            ->with('success', 'A new verification code was sent to your email address.')
            ->withInput(['email' => $user->email]);
    }

    public function verifyEmailCode(Request $request, EmailVerificationCodeService $verificationCodes)
    {
        $fields = $request->validate([
            'email' => ['required', 'email'],
            'code' => ['required', 'digits:6'],
        ]);

        $user = User::where('email', $fields['email'])->first();

        if ($user === null || ! $verificationCodes->verify($user, $fields['code'])) {
            return back()
                ->withErrors(['code' => 'The verification code is invalid or expired. Request a new code and try again.'])
                ->withInput($request->only('email'));
        }

        $verificationIntent = session()->pull('verification_intent');
        if ($user->email_verification_required) {
            $user->forceFill(['email_verification_required' => false])->save();
        }

        if ($verificationIntent === 'login') {
            return redirect()->route('login')
                ->with('success', 'Your email is verified. You can now sign in.')
                ->withInput(['username' => $user->username]);
        }

        $successMessage = auth()->check()
            ? 'Your new email address has been verified.'
            : 'Your email is verified. Enter it again to request a password reset link.';

        return redirect()->route(auth()->check() ? 'profile' : 'password.request')
            ->with('success', $successMessage)
            ->withInput(['email' => $user->email]);
    }

    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect('/login')->with('success', 'Your password has been reset.')
            : back()->withErrors(['email' => __($status)]);
    }
}
