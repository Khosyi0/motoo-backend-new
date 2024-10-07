<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class UserDetailController extends Controller
{
    public function indexClient()
    {
        //get posts
        $users = User::where('role', 'client')->get();

        //return collection of posts as a resource
        return UserResource::collection($users);
    }

    public function indexTeknisi()
    {
        //get posts
        $users = User::where('role', 'teknisi')->get();

        //return collection of posts as a resource
        return UserResource::collection($users);
    }
}
