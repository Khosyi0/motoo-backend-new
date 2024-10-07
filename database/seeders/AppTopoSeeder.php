<?php

namespace Database\Seeders;

use App\Models\Topology;
use App\Models\Application;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AppTopoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Get all Topologies and Apps
        $topologies = Topology::all();
        $apps = Application::all();
    
        // Iterate over Apps
        $apps->each(function ($app) use ($topologies) {
            // Get a random topology
            $randomTopology = $topologies->random();
    
            // Attach the app with the selected topology
            // $app->topologies()->attach($randomTopology->id);

            //perbaikan disini karena uuid
            DB::table('topo_apps')->insert([
                //'id' => (string) Str::uuid(),
                'app_id' => $app->id,
                'topo_id' => $randomTopology->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });
    }
}
