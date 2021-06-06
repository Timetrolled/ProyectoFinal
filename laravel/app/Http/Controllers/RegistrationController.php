<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class RegistrationController extends Controller
{
    public function create()
    {
        return view('register');
    }
    
    public function store()
    {

        $customMessages = [
            'required' => 'El campo :attribute es obligatorio.',
            'email' => 'Este email ya está registrado',
            'confirmed' => 'Las contraseñas no coinciden'
        ];

        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ],$customMessages);
        
        $user = User::create(request(['name', 'email', 'password']));
        
        auth()->login($user);
        
        return view('index')->with(compact('user'));
    }
}
