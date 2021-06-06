<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionsController extends Controller
{
    public function create()
    {
        return view('login');
    }
    
    public function store()
    {
        if (auth()->attempt(request(['email', 'password'])) == false) {
            return back()
            ->withInput()
            ->withErrors([
                'message' => 'El email o la contraseña son incorrectos'
            ]);
        }

       
        
        return redirect()->to('/');
    }
    
    public function destroy()
    {
        auth()->logout();
        
        return redirect()->to('/');
    }
}

