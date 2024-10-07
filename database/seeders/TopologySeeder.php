<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TopologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $users = DB::table('users')->where('name', 'admin123')->first()->id;

        for ($i = 1; $i <= 2; $i++) {
            DB::table('topologies')->insert([
                'id' => (string) Str::uuid(),
                'group' => 'Direct DB',
                'link' => 'https://' . str::random(10) . '.sig.id',
                'description' => Str::random(10),
                'status' => 'Not Use',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'created_by' => $users,
                'updated_by' => $users,
                'deleted_at' => null, 
            ]);
        }
        for ($i = 1; $i <= 2; $i++) {
            DB::table('topologies')->insert([
                'id' => (string) Str::uuid(),
                'group' => 'API',
                'link' => 'https://' . str::random(10) . '.sig.id',
                'status' => 'In Use',
                'description' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'created_by' => $users,
                'updated_by' => $users,
                'deleted_at' => null, 
            ]);
        }
    }
}
