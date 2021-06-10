<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class UserController extends Controller
{
    public function show($userId)
    {
        $user = User::where('id',$userId)->first();
        // dd($user->films);
        // dd(json_encode($user->films));
        // dd(json_encode($user->films));
        return json_encode($user->films);
    }
}
