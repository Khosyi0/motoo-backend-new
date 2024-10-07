<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Payload;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use PragmaRX\Google2FAQRCode\Google2FA;
use App\Http\Resources\GoogleAuthResource;
use App\Http\Resources\UserResource;


class GoogleAuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function show2faRegistration(Request $request)
    {
        // $user = User::find($request->route('id'));
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $twoFa = new Google2FA();
        // $secret_key = $user->google2fa_secret;
        $QR_Image = $twoFa->getQRCodeInline(
            'Motoo',
            $user['email'],
            $user['google2fa_secret'],
        );
        return response()->json(["QR_Image" => $QR_Image, 
    "message" => "user berhasil login"]);
    }

    protected $jwtAuth;

    public function __construct(JWTAuth $jwtAuth)
    {
        $this->jwtAuth = $jwtAuth;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function completeRegistration(Request $request)
    {
        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa');
        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->otp);

        if ($valid) {
            // Generate a new token with additional payload
            $mfaToken = $this->generateMfaToken($user);

            return response()->json([
                'mfa_verified' => true,
                'mfa_token' => $mfaToken  // Return the MFA token
            ], 200);
        }

        return response()->json(['message' => 'Invalid OTP'], 422);
    }


    protected function generateMfaToken($user)
    {
        $payload = $this->jwtAuth->getPayloadFactory()->customClaims([
            'sub' => $user->id,
            'iat' => now()->timestamp,
            'exp' => now()->addHours(1)->timestamp,
            'mfa' => true
        ])->make();

        return $this->jwtAuth->encode($payload)->get();
    }

    public function enable2FA(Request $request)
    {
        $user = Auth::user();
        
        if ($user) {
            $user->is_2fa_enabled = true;
            $user->save();

            return response()->json(['message' => '2FA enabled successfully'], 200);
        }

        return response()->json(['message' => 'User not found'], 404);
    }

    public function disable2FA($id)
    {
        // $user = Auth::user();
        $user = User::findOrFail($id);
        
        if ($user) {
            $user->is_2fa_enabled = false;
            $user->save();
            return response()->json(['message' => '2FA disabled successfully'], 200);
            // return new UserResource($user);
        }
        return response()->json(['message' => 'User not found'], 404);
    }
}