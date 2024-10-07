<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VirtualMachineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $users = DB::table('users')->where('name', 'admin123')->first()->id;


        for ($i = 1; $i <= 2; $i++) {
            DB::table('virtual_machines')->insert([
                'id' => (string) Str::uuid(),
                'group' => 'FE',
                'name' => 'vm1',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit perspiciatis voluptate aperiam eum soluta, quidem, atque sed voluptatum culpa reiciendis facilis explicabo porro tempora fuga debitis, facere minima quas optio.',
                'ip_address' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'created_by' => $users,
                'updated_by' => $users,
                'deleted_at' => null, 
            ]);
        }
        for ($i = 1; $i <= 2; $i++) {
            DB::table('virtual_machines')->insert([
                'id' => (string) Str::uuid(),
                'group' => 'BE',
                'name' => 'vm2',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit perspiciatis voluptate aperiam eum soluta, quidem, atque sed voluptatum culpa reiciendis facilis explicabo porro tempora fuga debitis, facere minima quas optio.',
                'ip_address' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'created_by' => $users,
                'updated_by' => $users,
                'deleted_at' => null, 
            ]);
        }
        for ($i = 1; $i <= 2; $i++) {
            DB::table('virtual_machines')->insert([
                'id' => (string) Str::uuid(),
                'group' => 'BFE',
                'name' => 'vm3',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit perspiciatis voluptate aperiam eum soluta, quidem, atque sed voluptatum culpa reiciendis facilis explicabo porro tempora fuga debitis, facere minima quas optio.',
                'ip_address' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'created_by' => $users,
                'updated_by' => $users,
                'deleted_at' => null, 
            ]);
        }
    }
}
