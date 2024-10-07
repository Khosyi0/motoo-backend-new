<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PragmaRX\Google2FAQRCode\Google2FA;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // set validation
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'photo'     => 'nullable|image|mimes:jpeg,png,jpg|max:250',
            'password'  => 'required|min:8',
        ],
            [
                // custom message
                'name.required' => 'Nama belum terisi',
                'email.required' => 'Email belum terisi',
                'email.email' => 'Email harus valid',
                'email.unique' => 'Email sudah terdaftar',
                'password.required' => 'Password belum terisi',
                'password.min' => 'Password minimal 8 karakter'
            ]
        );

        // if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Initialize photoUrl as null
        $photoUrl = null;

        // if photo is uploaded
        if ($request->hasFile('photo')) {
            $photoName = time() . '.' . $request->photo->getClientOriginalExtension();
            $request->photo->storeAs('public/user', $photoName);
            $photoUrl = url('storage/user/' . $photoName);
        }

        $role = $request->input('role', 'client');


        //generate code 2fa
        $google2fa = app('pragmarx.google2fa');
        $google2fa_secret = $google2fa->generateSecretKey();

        // create user
        $user = User::create([
            'id'        => Str::uuid(),
            'name'      => $request->name,
            'photo'     => $photoUrl,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'password'  => bcrypt($request->password),
            'role'      => $request->$role,
            'google2fa_secret' => $google2fa_secret,
        ]);

        // return response JSON user is created
        if ($user) {
            return response()->json([
                'success' => true,
                'user'    => $user,
            ], 201);
        }

        // return JSON process insert failed
        return response()->json([
            'success' => false,
        ], 409);
    }
}