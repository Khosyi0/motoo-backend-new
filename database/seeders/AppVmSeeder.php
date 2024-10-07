<?php

namespace Database\Seeders;

use App\Models\Application;
use Illuminate\Support\Str;
use App\Models\VirtualMachine;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppVmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Get all Virtual Machines
        $vms = VirtualMachine::all();
        $apps = Application::all();
    
        // Define possible environments
        $environments = ['development', 'production', 'testing'];
    
        // Iterate over Applications
        $apps->each(function ($app) use ($vms, $environments) {
            // Get a random environment for the application
            $randomEnvironment = $environments[array_rand($environments)];
    
            // Get two random VMs
            $randomVms = $vms->random(2);
    
            // Attach the VMs with the selected app and the specific environment
            // foreach ($randomVms as $randomVm) {
            //     $app->virtual_machines()->attach($randomVm->id, [
            //         'environment' => $randomEnvironment
            //     ]);
            // }

            //perbaikan di sini karena uuid
            foreach ($randomVms as $randomVm) {
                DB::table('vm_apps')->insert([
                    //'id' => (string) Str::uuid(),
                    'app_id' => $app->id,
                    'vm_id' => $randomVm->id,
                    'environment' => $randomEnvironment,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });
    }
}
