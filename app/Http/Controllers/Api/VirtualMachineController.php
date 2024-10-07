<?php


namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\VirtualMachine;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\VirtualMachineResource;

class VirtualMachineController extends Controller
{
    public function index()
    {
        $vm = VirtualMachine::with('applications')->get();
        return VirtualMachineResource::collection($vm);
    }

    public function show($id)
    {
        $virtualMachine = VirtualMachine::with('applications')->findOrFail($id);
        return new VirtualMachineResource($virtualMachine);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => Str::uuid(),
            'name' => 'required',
            'group' => 'required',
            'description' => 'required',
            'ip_address' => 'required|ip',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = Auth::user();

        $virtualmachine = VirtualMachine::create([
            'group' => $request->group,
            'name' => $request->name,
            'description' => $request->description,
            'ip_address' => $request->ip_address,
            'created_by' => $user->id, 
            'updated_by' => $user->id,  
        ]);

        return new VirtualMachineResource($virtualmachine);
    }

    public function update(Request $request, VirtualMachine $virtualMachine)
    {
        $validator = Validator::make($request->all(), [
            'id' => Str::uuid(),
            'name' => 'required',
            'group' => 'required',
            'description' => 'required',
            'ip_address' => 'required|ip',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        $user = Auth::user();

        $virtualMachine->update([
            'name' => $request->name,
            'group' => $request->group,
            'description' => $request->description,
            'updated_by' => $user->id,
            'ip_address' => $request->ip_address,
        ]);
        
        return new VirtualMachineResource($virtualMachine);
    }
    public function destroy(VirtualMachine $virtualMachine)
    {
         $virtualMachine->delete();
         return new VirtualMachineResource($virtualMachine);
    }
}
