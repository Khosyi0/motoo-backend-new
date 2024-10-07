<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Application;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CompanySeeder::class,
            GroupAreaSeeder::class,
            VirtualMachineSeeder::class,
            ApplicationSeeder::class,
            TopologySeeder::class,
            TechnologySeeder::class,
            PicSeeder::class,
            AppVmSeeder::class,
            AppTopoSeeder::class,
            AppTechnoSeeder::class,
            AppPicSeeder::class,
            ReviewSeeder::class,
        ]);
    }
}
