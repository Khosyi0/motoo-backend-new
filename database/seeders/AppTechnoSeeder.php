<?php

namespace Database\Seeders;

use App\Models\Technology;
use App\Models\Application;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AppTechnoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Get all Technologies and Apps
        $technologies = Technology::all();
        $apps = Application::all();
    
        // Iterate over Apps
        $apps->each(function ($app) use ($technologies) {
            // Get a random technology
            $randomTechnology = $technologies->random();
    
            // Attach the app with the selected technology
            // $app->technologies()->attach($randomTechnology->id);

            //perbaikan disini karena uuid
            DB::table('techno_apps')->insert([
                //'id' => (string) Str::uuid(),
                'app_id' => $app->id,
                'techno_id' => $randomTechnology->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });
    }
}
