<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $users = DB::table('users')->where('name', 'admin123')->first()->id;

        for ($i = 1; $i <= 2; $i++) {
            DB::table('technologies')->insert([
                'id' => (string) Str::uuid(),
                'group' => 'Front End',
                'name' => 'React JS',
                'version' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'created_by' => $users,
                'updated_by' => $users,
                'deleted_at' => null, 
            ]);
            for ($i = 1; $i <= 2; $i++) {
                DB::table('technologies')->insert([
                    'id' => (string) Str::uuid(),
                    'group' => 'Back End',
                    'name' => 'PHP',
                    'version' => Str::random(10),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'created_by' => $users,
                    'updated_by' => $users,
                    'deleted_at' => null, 
                ]);
            }
            for ($i = 1; $i <= 2; $i++) {
                DB::table('technologies')->insert([
                    'id' => (string) Str::uuid(),
                    'group' => 'FullStack',
                    'name' => 'Laravel',
                    'version' => Str::random(10),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'created_by' => $users,
                    'updated_by' => $users,
                    'deleted_at' => null, 
                ]);
            }
            for ($i = 1; $i <= 2; $i++) {
                DB::table('technologies')->insert([
                    'id' => (string) Str::uuid(),
                    'group' => 'Database',
                    'name' => 'PHP',
                    'version' => Str::random(10),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'created_by' => $users,
                    'updated_by' => $users,
                    'deleted_at' => null, 
                ]);
            }
        }
    }
}
