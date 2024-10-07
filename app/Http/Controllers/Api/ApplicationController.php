<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Log;

use App\Models\Pic;
use App\Models\Company;
use App\Models\Topology;
use App\Models\GroupArea;
use App\Models\Technology;
use App\Models\Application;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\VirtualMachine;
use App\Imports\ApplicationImport;
use App\Exports\ApplicationsExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ApplicationResource;

class ApplicationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $companyNames = explode(', ', $user->company);
        // dd($companyNames);
        // $applications = Application::with([
        //     'virtual_machines', 
        //     'topologies', 
        //     'technologies', 
        //     'pics',
        //     'groupArea',
        //     'companies',
        //     'reviews',
        // ])
        // if($user->role != 'admin') {
        //     ->where('group_area', $user->company_id)
        // };
        // ->get();

        $applicationsQuery = Application::with([
            'virtual_machines', 
            'topologies', 
            'technologies', 
            'pics',
            'groupArea',
            'companies',
            'reviews',
        ]);
    
        if ($user->role == 'client') {
            // $applicationsQuery->where('company_id', $user->company_id);
            $applicationsQuery->whereIn('company', $companyNames)->pluck('company');

        // $applications = Application::whereIn('company', $companyNames)->get();
        }
    
        $applications = $applicationsQuery->get();



        return ApplicationResource::collection($applications);
    }

    public function show($id)
    {
        // Retrieve the application by its ID with eager loading of related data
        $application = Application::with([
            'virtual_machines', 
            'topologies', 
            'technologies', 
            'pics',
            'groupArea',
            'companies',
            'reviews',
        ])->findOrFail($id);
    
        // Return the single application as a resource
        return new ApplicationResource($application);
    }

    public function store(Request $request)
    {
        // Normalize the input
        $request->merge([
            'platform' => strtolower($request->input('platform')),
            'status' => strtolower($request->input('status')),
            'category' => strtolower($request->input('category')),
            'user_login' => strtolower($request->input('user_login')),
            'first_pic' => $request->input('first_pics', []),
            'backup_pic' => $request->input('backup_pics', []),
            'pic_ict' => $request->input('pic_icts', []),
            'pic_user' => $request->input('pic_users', []),
            'old_pic' => $request->input('old_pics', []),
        ]);
    
        // Validate the request
        $validator = Validator::make($request->all(), [
            'id' => Str::uuid(),
            'short_name' => 'required|unique:applications',
            'long_name' => 'required|unique:applications',

            // //penambahan company id di sini
            // 'company' => 'required|exists:companies,id',

            //multi company
            'company' => 'required',

            'group_area' => 'required|exists:group_areas,id',

            'description' => 'required',
            'business_process' => 'required',
            'platform' => 'required|in:mobile,dekstop,website',
            'status' => 'required|in:up,down,maintenance,delete',
            'tier' => 'required|in:1,2,3,4,5,6,7,8,9,10',
            'category' => 'required|in:sap,non_sap,turunan,ot/it,collaboration',
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:1024',
            'db_connection_path' => 'required',
            'ad_connection_path' => 'required',
            'sap_connection_path' => 'required',
            'technical_doc' => 'required|url',
            'user_login' => 'required|in:login sso,login ad,internal apps',
            'user_doc' => 'required|url',
            'other_doc' => 'required|url',
            'information' => 'required',
            'vm_prod' => 'required',
            'vm_dev' => 'required',
            'url_prod' => 'required|url',
            'url_dev' => 'required|url',
            'environment' => 'required|in:production,development,testing',

            //pic testing
            // 'backup_pics' => 'required|array|exists:pics,id',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        // Store the image in public/storage/application with relative path in the database
        if ($request->hasFile('image')) {
            // Generate the image name with a timestamp to avoid conflicts
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
        
            // Store the image in 'public/application' and get the relative path
            $relativePath = $request->image->storeAs('application', $imageName, 'public');
        
            // Store the relative path in the database
            $imageUrl = '/storage/' . $relativePath;
        } else {
            $imageUrl = null; // To handle cases where no image is uploaded
        }
    
        // Retrieve related entities
        $groupArea = GroupArea::find($request->input('group_area')) ?: GroupArea::where('short_name', $request->input('group_area'))->first();
        $companyId = Company::find($request->input('company_id')) ?: Company::where('short_name', $request->input('company_id'))->first();
    
        // Create the application
        $application = Application::with(['groupArea', 'companies'])->create([
            'short_name' => $request->input('short_name'),
            'long_name' => $request->input('long_name'),
            'description' => $request->input('description'),

            //penambahan company id di sini
            // 'company_id' => $request->input('company_id'),

            'status' => $request->input('status'),
            'image' => $imageUrl,
            'platform' => $request->input('platform'),
            'category' => $request->input('category'),
            'tier' => $request->input('tier'),
            'user_login' => $request->input('user_login'),

            //company
            // 'company_id' => $companyId->id,

            //multi company
            'company' => $request->input('company'),

            'group_area' => $groupArea->id,
            'business_process' => $request->input('business_process'),
            'db_connection_path' => $request->input('db_connection_path'),
            'ad_connection_path' => $request->input('ad_connection_path'),
            'sap_connection_path' => $request->input('sap_connection_path'),
            'technical_doc' => $request->input('technical_doc'),
            'user_doc' => $request->input('user_doc'),
            'other_doc' => $request->input('other_doc'),
            'information' => $request->input('information'),
            'vm_prod' => $request->input('vm_prod'),
            'vm_dev' => $request->input('vm_dev'),
            'url_prod' => $request->input('url_prod'),
            'url_dev' => $request->input('url_dev'),
            'environment' => $request->input('environment'),
        ]);
    
        // Attach related entities
        $virtual_machines = $request->input('virtual_machines', []);

        if (is_string($virtual_machines)) {
            $virtual_machines = explode(',', $virtual_machines);
        }

        foreach ($virtual_machines as $vm) {
            $virtual_machine = VirtualMachine::where('id', trim($vm))->orWhere('name', trim($vm))->first();
            if ($virtual_machine) {
                $application->virtual_machines()->attach($virtual_machine, ['environment' => $request->input('environment')]);
            }
        }

        $topologies = $request->input('topology', []);
        if (is_string($topologies)) {
            $topologies = explode(',', $topologies);
        } elseif (!is_array($topologies)) {
            $topologies = [$topologies];
        }

        foreach ($topologies as $topologyInput) {
            $topology = Topology::where('id', trim($topologyInput))->orWhere('group', trim($topologyInput))->first();
            if ($topology) {
                $application->topologies()->attach($topology);
            } else {
                Log::warning('Topology not found: ' . trim($topologyInput));
            }
        }

        $technologies = $request->input('technology', []);
        if (is_string($technologies)) {
            $technologies = explode(',', $technologies);
        } elseif (!is_array($technologies)) {
            $technologies = [$technologies];
        }

        foreach ($technologies as $technologyInput) {
            $technology = Technology::where('id', trim($technologyInput))->orWhere('name', trim($technologyInput))->first();
            if ($technology) {
                $application->technologies()->attach($technology);
            } else {
                Log::warning('Technology not found: ' . trim($technologyInput));
            }
        }

    
        $this->attachPic($request->input('old_pic', []), 'old_pic', $application);
        $this->attachPic($request->input('first_pic', []), 'first_pic', $application);
        $this->attachPic($request->input('backup_pic', []), 'backup_pic', $application);
        $this->attachPic($request->input('pic_ict', []), 'pic_ict', $application);
        $this->attachPic($request->input('pic_user', []), 'pic_user', $application);
    
        return new ApplicationResource($application);
    }
    
    private function attachPic($picInputs, $picType, $application)
    {
        if (!is_array($picInputs)) {
            $picInputs = [$picInputs];
        }
    
        foreach ($picInputs as $picInput) {
            if ($picInput) {
                // Check if input is numeric (assuming ID)
                if (is_numeric($picInput)) {
                    $pic = Pic::find($picInput); //sudah tidak terpakai bisa dihapus
                } else { // Otherwise, assume it's a name
                    $pic = Pic::where('name', $picInput)->orWhere('id', $picInput)->first();
                }
    
                if ($pic) {
                    // Check if the pic is already attached to avoid duplication
                    if (!$application->pics()->where('pic_id', $pic->id)->wherePivot('pic_type', $picType)->exists()) {
                        $application->pics()->attach($pic->id, [
                            'id' => (string) Str::uuid(),
                            'pic_type' => $picType]);
                    }
                }
            }
        }
    }

    public function update(Request $request, $id)
    {
        // Normalize the input
        $request->merge([
            'platform' => strtolower($request->input('platform')),
            'status' => strtolower($request->input('status')),
            'category' => strtolower($request->input('category')),
            'user_login' => strtolower($request->input('user_login'))
        ]);

        // Validate the request
        $validator = Validator::make($request->all(), [
            'short_name' => 'required|unique:applications,short_name,' . $id,
            'long_name' => 'required|unique:applications,long_name,' . $id,

            // penambahan validasi company id
            // 'company_id' => 'required|exists:companies,id',

            //multi company
            'company' => 'required',

            'group_area' => 'required|exists:group_areas,id',

            'description' => 'required',
            'business_process' => 'required',
            'platform' => 'required|in:mobile,dekstop,website',
            'status' => 'required|in:up,down,maintenance,delete',
            'tier' => 'required|in:1,2,3,4,5,6,7,8,9,10',
            'category' => 'required|in:sap,non_sap,turunan,ot/it,collaboration',
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:1024',
            'db_connection_path' => 'required',
            'ad_connection_path' => 'required',
            'sap_connection_path' => 'required',
            'technical_doc' => 'required|url',
            'user_login' => 'required|in:login sso,login ad,internal apps',
            'user_doc' => 'required|url',
            'other_doc' => 'required|url',
            'information' => 'required',
            'vm_prod' => 'required',
            'vm_dev' => 'required',
            'url_prod' => 'required|url',
            'url_dev' => 'required|url',
            'environment' => 'required|in:production,development,testing',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $application = Application::findOrFail($id);

        // Store the image in public/storage/application
        if ($request->hasFile('image')) 
        {
            // Generate the new image name with a timestamp to avoid conflicts

        // Store the new image in 'public/application' and get the relative path
        // Delete the old image if it exists
            if ($application->image)
            {
                $oldImagePath = str_replace('/storage/', 'public/', $application->image);
                if (Storage::exists($oldImagePath)) {
                    Storage::delete($oldImagePath);
                }
                
                $imageName = time() . '.' . $request->image->getClientOriginalExtension();
                $relativePath = $request->image->storeAs('application', $imageName, 'public');
                // $request->image->storeAs('public/application', $imageName);
                $imageUrl = '/storage/' . $relativePath;
                $application->image = $imageUrl;
            }
        }

        // Retrieve related entities
        $groupArea = GroupArea::find($request->input('group_area')) ?: GroupArea::where('short_name', $request->input('group_area'))->first();
        $companyId = Company::find($request->input('company_id')) ?: Company::where('short_name', $request->input('company_id'))->first();

        // Update the application
        $application->update([
            'short_name' => $request->input('short_name'),
            'long_name' => $request->input('long_name'),

            // penambahan update company id
            // 'company_id' => $companyId->id,

            //multi company
            'company' => $request->input('company'),


            'description' => $request->input('description'),
            'status' => $request->input('status'),
            'platform' => $request->input('platform'),
            'category' => $request->input('category'),
            'tier' => $request->input('tier'),
            'user_login' => $request->input('user_login'),
            'group_area' => $groupArea->id,
            'business_process' => $request->input('business_process'),
            'db_connection_path' => $request->input('db_connection_path'),
            'ad_connection_path' => $request->input('ad_connection_path'),
            'sap_connection_path' => $request->input('sap_connection_path'),
            'technical_doc' => $request->input('technical_doc'),
            'user_doc' => $request->input('user_doc'),
            'other_doc' => $request->input('other_doc'),
            'information' => $request->input('information'),
            'vm_prod' => $request->input('vm_prod'),
            'vm_dev' => $request->input('vm_dev'),
            'url_prod' => $request->input('url_prod'),
            'url_dev' => $request->input('url_dev'),
        ]);

        // Detach and re-attach related entities
        $application->virtual_machines()->detach();
        $virtual_machines = $request->input('virtual_machines', []);
        foreach ($virtual_machines as $vm) {
            $virtual_machine = VirtualMachine::where('id', $vm)->orWhere('name', $vm)->first();
            if ($virtual_machine) {
                $application->virtual_machines()->attach($virtual_machine, ['environment' => $request->input('environment')]);
            }
        }

        $application->topologies()->detach();
        $topologies = $request->input('topologies', []);
        foreach ($topologies as $topologyInput) {
            $topology = Topology::where('id', $topologyInput)->orWhere('group', $topologyInput)->first();
            if ($topology) {
                $application->topologies()->attach($topology);
            }
        }

        $application->technologies()->detach();
        $technologies = $request->input('technologies', []);
        foreach ($technologies as $technologyInput) {
            $technology = Technology::where('id', $technologyInput)->orWhere('name', $technologyInput)->first();
            if ($technology) {
                $application->technologies()->attach($technology);
            }
        }

        $this->updatePics($request->input('old_pic', []), 'old_pic', $application);
        $this->updatePics($request->input('first_pic', []), 'first_pic', $application, true);
        $this->updatePics($request->input('backup_pic', []), 'backup_pic', $application);
        $this->updatePics($request->input('pic_ict', []), 'pic_ict', $application);
        $this->updatePics($request->input('pic_user', []), 'pic_user', $application);

        return new ApplicationResource($application);
    }

    private function updatePics($picInputs, $picType, $application, $isFirstPic = false)
{
    if (!is_array($picInputs)) {
        $picInputs = [$picInputs];
    }

    if ($isFirstPic && $picInputs) {
        // Ambil first_pic yang ada saat ini
        $currentFirstPic = $application->pics()->wherePivot('pic_type', 'first_pic')->first();

        // Jika first_pic baru berbeda dengan yang ada saat ini, baru lakukan pemindahan
        if ($currentFirstPic && $currentFirstPic->id !== $picInputs[0]) {
            // Pindahkan current first_pic ke old_pic
            if (!$application->pics()->where('pic_id', $currentFirstPic->id)->wherePivot('pic_type', 'old_pic')->exists()) {
                $application->pics()->attach($currentFirstPic->id, [
                    'id' => (string) Str::uuid(),
                    'pic_type' => 'old_pic'
                ]);
            }
        }
    }

    // Sinkronisasi pic baru
    $this->syncPic($picInputs, $picType, $application);
}


    private function syncPic($picInputs, $picType, $application)
    {
        // Detach existing pics of the specified type
        $application->pics()->wherePivot('pic_type', $picType)->detach();

        foreach ($picInputs as $picInput) {
            if ($picInput) {
                // Check if input is numeric (assuming ID)
                if (is_numeric($picInput)) {
                    $pic = Pic::find($picInput);
                } else { // Otherwise, assume it's a name
                    $pic = Pic::where('name', $picInput)->orWhere('id', $picInput)->first();
                }

                if ($pic) {
                    // Attach the pic with the specified type
                    $application->pics()->attach($pic->id, [
                        'id' => (string) Str::uuid(),
                        'pic_type' => $picType]);
                }
            }
        }
    }

    
    public function destroy(Application $application)
    {
        if ($application->image)
            {
                $oldImagePath = str_replace('/storage/', 'public/', $application->image);
                if (Storage::exists($oldImagePath)) {
                    Storage::delete($oldImagePath);
                }
            }
        return new ApplicationResource($application);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);
    
        Excel::import(new ApplicationImport, request()->file('file'));
    
        return response()->json(['message' => 'Import successful'], 200);
    }

    // public function exportData()
    // {
    //     return Excel::download(new ApplicationsExport, 'applications.xlsx');
    // }
}
