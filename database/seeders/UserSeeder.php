<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'id' => (string) Str::uuid(),
            'company' => 'SISI, PP',
            'name' => 'admin123',
            'role' => 'admin',
            'email' => 'admin123@gmail.com',
            'photo' => '/images/user/riqi.jpg',
            'phone' => '081299875369',
            'job' => 'wasd',
            'team' => 'a',
            'password' => Hash::make('admin12345'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null,
            'google2fa_secret' => '76RRVSJUMGHE7ARA',
        ]);

        DB::table('users')->insert([
            'id' => (string) Str::uuid(),
            'company' => 'SISI, ADHI, SBI',
            'name' => 'reporter123',
            'role' => 'reporter',
            'email' => 'reporter123@gmail.com',
            'photo' => '/images/user/bogor.jpg',
            'phone' => '081299875369',
            'job' => 'wasd',
            'team' => 'a',
            'password' => Hash::make('reporter12345'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null,
            'google2fa_secret' => '76RRVSJUMGHE7ARB',
        ]);

        DB::table('users')->insert([
            'id' => (string) Str::uuid(),
            'company' => 'UTSG, SBI',
            'name' => 'M Syuja Ramadhan',
            'role' => 'client',
            'email' => 'syuja@gmail.com',
            'photo' => '/images/user/suja.jpg',
            'phone' => '081299875369',
            'job' => 'wasd',
            'team' => 'a',
            'password' => Hash::make('user12345'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null,
            'google2fa_secret' => '76RRVSJUMGHE7ARC',
        ]);

        DB::table('users')->insert([
            'id' => (string) Str::uuid(),
            'company' => 'UTSG, ADHI, PP',
            'name' => 'Utbah Ghazwan',
            'role' => 'teknisi',
            'email' => 'utbah@gmail.com',
            'photo' => '/images/user/utbah.jpg',
            'phone' => '081299875369',
            'job' => 'wasd',
            'team' => 'a',
            'password' => Hash::make('teknisi12345'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null,
            'google2fa_secret' => '76RRVSJUMGHE7ARD',
        ]);

        DB::table('users')->insert([
            'id' => (string) Str::uuid(),
            'company' => 'SBI, SISI',
            'name' => 'Faisal A Hermawan',
            'role' => 'teknisi',
            'email' => 'faisal@gmail.com',
            'photo' => '/images/user/bogor.jpg',
            'phone' => '081299875369',
            'job' => 'wasd',
            'team' => 'a',
            'password' => Hash::make('teknisi12345'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null,
            'google2fa_secret' => '76RRVSJUMGHE7ARE',
        ]);

        DB::table('users')->insert([
            'id' => (string) Str::uuid(),
            'company' => 'ADHI, SBI, SISI',
            'name' => 'pino',
            'role' => 'client',
            'email' => 'pino@gmail.com',
            'photo' => '/images/user/riqi.jpg',
            'phone' => '081299875369',
            'job' => 'wasd',
            'team' => 'a',
            'password' => Hash::make('user12345'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null,
            'google2fa_secret' => '76RRVSJUMGHE7ARF',
        ]);
    }
}
