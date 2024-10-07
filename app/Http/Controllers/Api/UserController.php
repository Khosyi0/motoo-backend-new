<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PragmaRX\Google2FAQRCode\Google2FA;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Register2faResource;


class UserController extends Controller
{
    public function index()
    {
        //get posts
        $users = User::all();

        //return collection of posts as a resource
        return UserResource::collection($users);
    }

    public function show(User $user)
    {
        //return single post as a resource
        return new UserResource($user);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email'     => 'required|email|unique:users',
            'role' => 'required|in:client,teknisi,admin,reporter',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            'password' => 'required|min:8',
            'company' => 'nullable',
            'phone' => 'nullable|numeric',
        ],
        [
            // custom message
            'name.required' => 'Nama belum terisi',
            'email.required' => 'Email belum terisi',
            'email.email' => 'Email harus valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password belum terisi',
            'password.min' => 'Password minimal 8 karakter',
        ]);

        // if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //check if validation fails
        if ($request->hasFile('photo')) {
            $photoName = time() . '.' . $request->photo->getClientOriginalExtension();
            // $request->photo->storeAs('public/user', $photoName);
            $relativePath = $request->photo->storeAs('user', $photoName, 'public');
            // $photoUrl = url('storage/user/' . $photoName);
            $photoUrl = '/storage/' . $relativePath;

        }else{
            $photoUrl = null;
        }

        //generate code 2fa
        $google2fa = app('pragmarx.google2fa');
        $google2fa_secret = $google2fa->generateSecretKey();


            //create user
            $user = User::create([
                'id' => Str::uuid(),
                'name' => $request->name,
                //company
                // 'company_id' => $request->company_id,

                //multi company
                'company' => $request->company,

                'photo' => $photoUrl,
                'email' => $request->email,
                'role' => $request->role,
                'job' => $request->job,
                'team' => $request->team,
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
                'google2fa_secret' => $google2fa_secret,
                'status' => 'active',
            ]);

            //return response
            return new UserResource($user);
    }

    public function update(Request $request, $id)
    {
        // Find the user or fail
        $user = User::findOrFail($id);

        // Define validation rules
        $validator = Validator::make($request->all(), [
            'role' => 'in:client,teknisi,admin,reporter',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            'company' => 'nullable',
            'phone' => 'nullable|numeric',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Handle photo update
        if ($request->hasFile('photo')) {
            if ($user->photo) {
                $oldPhotoPath = str_replace('/storage/', 'public/', $user->photo);
                if (Storage::exists($oldPhotoPath)) {
                    Storage::delete($oldPhotoPath);
                }
            }

            // Generate the new image name with a timestamp to avoid conflicts
            $photoName = time() . '.' . $request->photo->getClientOriginalExtension();
            $relativePath = $request->photo->storeAs('user', $photoName, 'public');
            $photoUrl = '/storage/' . $relativePath;
            $user->photo = $photoUrl;
        }

        // Update user details
        $user->update([
            'name' => $request->name,
            'company' => $request->company,
            'email' => $request->email,
            'role' => $request->role,
            'job' => $request->job,
            'team' => $request->team,
            'phone' => $request->phone,
            'password' => $request->filled('password') ? bcrypt($request->password) : $user->password,
            'status' => $request->filled('status') ? $request->status : $user->status,
        ]);

        // Return response
        return new UserResource($user);
    }


    public function getAdminContact()
    {
        $admin = User::where('role', 'admin')->first();

        if ($admin) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil',
                'data' => [
                    'email' => $admin->email,
                    'phone' => $admin->phone,
                ],
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data admin tidak ditemukan',
            ], 404);
        }
    }

    public function destroy(User $user)
    {

        //delete post
        $user->delete();

        //return response
        return new UserResource($user);
    }

   
}
