<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $appId1 = DB::table('applications')->where('short_name', 'TPM')->first()->id;
        $appId5 = DB::table('applications')->where('short_name', 'Aplikasi lima')->first()->id;

        $users = DB::table('users')->where('name', 'admin123')->first()->id;

        for ($i = 1; $i <= 3; $i++) {
            DB::table('reviews')->insert([
                'id' => (string) Str::uuid(),
                'review_text' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit perspiciatis voluptate aperiam eum soluta, quidem, atque sed voluptatum culpa reiciendis facilis explicabo porro tempora fuga debitis, facere minima quas optio.',
                'rating' => 4,
                'app_id' => $appId1,
                'user_id' => $users,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null, 
            ]);
        }
        for ($i = 1; $i <= 3; $i++) {
            DB::table('reviews')->insert([
                'id' => (string) Str::uuid(),
                'review_text' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit perspiciatis voluptate aperiam eum soluta, quidem, atque sed voluptatum culpa reiciendis facilis explicabo porro tempora fuga debitis, facere minima quas optio.',
                'rating' => 3,
                'app_id' => $appId5,
                'user_id' => $users,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null, 
            ]);
        }
        for ($i = 1; $i <= 3; $i++) {
            DB::table('reviews')->insert([
                'id' => (string) Str::uuid(),
                'review_text' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit perspiciatis voluptate aperiam eum soluta, quidem, atque sed voluptatum culpa reiciendis facilis explicabo porro tempora fuga debitis, facere minima quas optio.',
                'rating' => 2,
                'app_id' => $appId5,
                'user_id' => $users,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null, 
            ]);
        }
    }
}
