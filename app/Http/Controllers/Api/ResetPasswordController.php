<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function requestReset(Request $request)
{
    // Logging data yang diterima dari frontend
    \Log::info('Received reset password request', [
        'email' => $request->input('email'),
        'g-recaptcha-response' => $request->input('g-recaptcha-response')
    ]);

    // Validasi input
    $validator = Validator::make($request->all(), [
        'email' => 'required|email|exists:users,email',
        'g-recaptcha-response' => 'required|captcha',
    ]);

    // Logging hasil validasi
    if ($validator->fails()) {
        \Log::error('Validation failed for reset password request', [
            'errors' => $validator->errors()
        ]);
        return response()->json([
            'message' => 'validation.captcha',
            'errors' => $validator->errors(),
        ], 422);
    }

    // Sebelum validasi
\Log::info('Validating reCAPTCHA', [
    'response' => $request->input('g-recaptcha-response'),
]);

// Setelah validasi
$validator = Validator::make($request->all(), [
    'email' => 'required|email|exists:users,email',
    'g-recaptcha-response' => 'required|captcha',
]);

// Cek apakah ada error pada validasi
if ($validator->fails()) {
    \Log::error('Validation failed', [
        'errors' => $validator->errors()
    ]);
}


    // Attempt to send the password reset link
    $status = Password::sendResetLink(
        $request->only('email')
    );

    // Logging hasil pengiriman tautan reset
    if ($status == Password::RESET_LINK_SENT) {
        \Log::info('Password reset link sent successfully', [
            'email' => $request->email,
            'status' => $status
        ]);
        return response()->json([
            'token' => DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->value('token'),
            'status' => $status,
            'message' => 'Password reset link has been sent to your email.',
        ], 200);
    } else {
        \Log::error('Failed to send password reset link', [
            'email' => $request->email,
            'status' => $status
        ]);
        return response()->json([
            'error' => $status,
            'message' => 'Unable to send password reset link.',
        ], 400);
    }
}


    public function resetPassword(Request $request)
    {
        try {
            $request->validate([
                'token' => ['required'],
                'email' => ['required', 'email'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user) use ($request) {
                    $user->forceFill([
                        'password' => Hash::make($request->password),
                        'remember_token' => Str::random(60),
                    ])->save();

                    event(new PasswordReset($user));
                }
            );

            if ($status == Password::PASSWORD_RESET) {
                return response()->json([
                    'message' => 'Password has been reset successfully.',
                ], 200);
            } else {
                $errorMessages = [
                    Password::INVALID_TOKEN => 'The password reset token is invalid.',
                    Password::INVALID_USER => 'We can\'t find a user with that email address.',
                    // Password::INVALID_PASSWORD => 'The password is invalid.', // This case is less likely as we validate password rules before.
                ];

                return response()->json([
                    'error' => $errorMessages[$status] ?? 'Failed to reset password.',
                ], 400);
            }
        } catch (Exception $e) {
            \Log::error('Password reset error: '.$e->getMessage());
            
            return response()->json([
                'error' => 'An error occurred while resetting the password.',
                'message' => $e->getMessage(),
            ], 500);
        }
        
    }
}