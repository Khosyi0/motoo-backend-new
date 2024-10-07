<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GroupAreaResource;
use App\Models\GroupArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class GroupAreaController extends Controller
{
    public function index()
    {
        $group_areas = GroupArea::with(['applications'])->get();
        return GroupAreaResource::collection($group_areas);
    }

    public function show($id)
    {
        $group_area = GroupArea::with(['applications'])->findOrFail($id);
        return new GroupAreaResource($group_area);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'short_name' => 'required',
            'long_name' => 'required',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:1024',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Store the image if it exists
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $relativePath = $request->image->storeAs('group', $imageName, 'public');
            // $logoUrl = url('storage/company/' . $logoName);
            $imageUrl = '/storage/' . $relativePath;

            $group_area = GroupArea::create([
                'id' => Str::uuid(),
                'short_name' => $request->short_name,
                'long_name' => $request->long_name,
                'image' => $imageUrl,
            ]);

            return new GroupAreaResource($group_area);
        } else {
            return response()->json(['error' => 'image file is required'], 422);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'short_name' => 'required',
            'long_name' => 'required',
            'image' => 'image|mimes:png,jpg,jpeg|max:1024', // image not required for update
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $group_area = GroupArea::findOrFail($id);

        if ($group_area->image) {
            $oldImagePath = str_replace('/storage/', 'public/', $group_area->image);
            if (Storage::exists($oldImagePath)) {
                Storage::delete($oldImagePath);
            }

            // Generate the new image name with a timestamp to avoid conflicts
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $relativePath = $request->image->storeAs('group', $imageName, 'public');
            $imageUrl = '/storage/' . $relativePath;

            $group_area->image = $imageUrl;
        }

        $group_area->short_name = $request->short_name;
        $group_area->long_name = $request->long_name;
        $group_area->save();

        return new GroupAreaResource($group_area);
    }

    public function destroy(GroupArea $group_area)
    {
        if ($group_area->image) {
            $oldImagePath = str_replace('/storage/', 'public/', $group_area->image);
            if (Storage::exists($oldImagePath)) {
                Storage::delete($oldImagePath);
            }
            $group_area->delete();
            return new GroupAreaResource($group_area);
        }
    }
}
