<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\User;

class UsersController extends Controller
{
    public function login()
    {
        return view('users.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect('/');
        }
        return redirect('/login');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        return redirect('/login');
    }

    public function create()
    {
        return view('users.register');
    }

    public function store(Request $request)
    {
        $password = bcrypt($request->password);
        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $password
        ]);
        return redirect('/login');
    }

    public function guestLogin()
    {
        return redirect('/');
    }
}
