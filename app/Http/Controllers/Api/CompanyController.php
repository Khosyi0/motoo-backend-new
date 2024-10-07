<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::with(['applications'])->get();
        return CompanyResource::collection($companies);
    }
    public function show($id)
    {
        $company = Company::with(['applications'])->findOrFail($id);
        return new CompanyResource($company);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'short_name' => 'required|unique:companies,short_name',
            'long_name' => 'required',
            'logo' => 'required|image|mimes:png,jpg,jpeg|max:1024',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->hasFile('logo')) {
            $logoName = time() . '.' . $request->logo->getClientOriginalExtension();
            $relativePath = $request->logo->storeAs('company', $logoName, 'public');
            // $logoUrl = url('storage/company/' . $logoName);
            $logoUrl = '/storage/' . $relativePath;

            $company = Company::create([
                // 'id' => Str::uuid(),
                'short_name' => $request->short_name,
                'long_name' => $request->long_name,
                'logo' => $logoUrl,
            ]);

            return new CompanyResource($company);
        } else {
            return response()->json(['error' => 'Logo file is required'], 422);
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'short_name' => 'required',
            'long_name' => 'required',
            'logo' => 'required|image|mimes:png,jpg,jpeg|max:250', // logo not required for update
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $company = Company::findOrFail($id);

        if ($request->hasFile('logo')) {
            // Delete the old logo if exists
            if ($company->logo) {
                $oldLogoPath = str_replace('/storage/', 'public/', $company->logo);
                if (Storage::exists($oldLogoPath)) {
                    Storage::delete($oldLogoPath);
                }

                // Generate the new image name with a timestamp to avoid conflicts
                $logoName = time() . '.' . $request->logo->getClientOriginalExtension();
                $relativePath = $request->logo->storeAs('company', $logoName, 'public');
                $logoUrl = '/storage/' . $relativePath;

                $company->logo = $logoUrl;
            }
        }

        $company->short_name = $request->short_name;
        $company->long_name = $request->long_name;
        $company->save();

        return new CompanyResource($company);
    }

    public function destroy(Company $company)
    {
        if ($company->logo) {
            $oldLogoPath = str_replace('/storage/', 'public/', $company->logo);
            if (Storage::exists($oldLogoPath)) {
                Storage::delete($oldLogoPath);
            }
            $company->delete();
            return new CompanyResource($company);
        }
    }
}
