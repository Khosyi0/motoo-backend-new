<?php

namespace Database\Seeders;

use App\Models\Pic;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class PicSeeder extends Seeder
{
    public function run()
    {

        // Dapatkan semua pengguna dengan peran teknisi atau client
        $users = User::whereIn('role', ['teknisi', 'client'])->get();

        foreach ($users as $user) {
            Pic::create([
                'id' => (string) Str::uuid(),
                'user_id' => $user->id,
                'company' => $user->company,
                'name' => $user->name,
                'role' => $user->role,
                'contact' => $user->phone,
                'photo' => $user->photo,
                'status' => 'excomunicado',
                'jobdesc' => 'farming',
            ]);
        }
    }
}

