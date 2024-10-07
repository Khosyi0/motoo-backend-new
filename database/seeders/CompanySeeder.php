<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            DB::table('companies')->insert([
                // 'id' => (string) Str::uuid(),
                'short_name' => "SISI",
                'long_name' => "PT Sinergi Informatika Semen Indonesia",
                'logo' => '/images/pt.sisi.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null, 
            ]);
            DB::table('companies')->insert([
                // 'id' => (string) Str::uuid(),
                'short_name' => "SBI",
                'long_name' => "PT Solusi Bangun Indonesia",
                'logo' => '/images/pt.sbi.jpeg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null, 
            ]);
            DB::table('companies')->insert([
                // 'id' => (string) Str::uuid(),
                'short_name' => "UTSG",
                'long_name' => "PT United Tractors Semen Gresik",
                'logo' => '/images/pt.utsg.jpeg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null, 
            ]);
            DB::table('companies')->insert([
                // 'id' => (string) Str::uuid(),
                'short_name' => "PP",
                'long_name' => "PT Pembangunan Perumahan",
                'logo' => '/images/ptpp.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null, 
            ]);
            DB::table('companies')->insert([
                // 'id' => (string) Str::uuid(),
                'short_name' => "ADHI",
                'long_name' => "PT Adhi Karya",
                'logo' => '/images/adhi.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null, 
            ]);
    }
}
