<?php

namespace App\Http\Controllers\Api;

use App\Models\Pic;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\PicResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;   

class PicController extends Controller
{
    public function index()
    {
        $pics = Pic::with('applications','user')->get();
        return PicResource::collection($pics);
    }

    public function show($id)
    {
        $pic = Pic::with(['applications', 'user'])->findOrFail($id);
        return new PicResource($pic);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'contact' => 'required|numeric',
            'jobdesc' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:1024',
            'status' => 'required|string',
            'role' => 'required|string',
            'company' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->hasFile('photo')) {
            $imageName = time() . '.' . $request->photo->getClientOriginalExtension();
            $relativePath = $request->photo->storeAs('pic', $imageName, 'public');
            $imageUrl = '/storage/' . $relativePath;
        }

        // Create Pic entry with all fields
        $pic = Pic::create([
            'id' => Str::uuid(),
            'name' => $request->name,
            'contact' => $request->contact,
            'jobdesc' => $request->jobdesc,
            'photo' => $imageUrl ?? null, // Make sure the imageUrl exists
            'status' => $request->status,
            'role' => $request->role,
            'company' => $request->company,
        ]);

        return (new PicResource($pic))->additional(['message' => 'Berhasil Ditambahkan!']);
    }


    public function update(Request $request, Pic $pic)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'contact' => 'required|numeric',
            'jobdesc' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            'status' => 'required|string',
            'role' => 'required|string',
            'company' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Handle photo update
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($pic->photo) {
                Storage::disk('public')->delete($pic->photo);
            }
            
            // Store new photo
            $imageName = time() . '.' . $request->photo->getClientOriginalExtension();
            $relativePath = $request->photo->storeAs('pic', $imageName, 'public');
            $pic->photo = '/storage/' . $relativePath;
        }

        // Update other fields
        $pic->update($request->except('photo'));

        return (new PicResource($pic))->additional(['message' => 'Berhasil Diperbarui!']);
    }

    

    public function destroy(Pic $pic)
    {
        Storage::delete('public/posts/' . $pic->photo);
        $pic->delete();
        return response()->json(['message' => 'Berhasil Dihapus!']);
    }
}