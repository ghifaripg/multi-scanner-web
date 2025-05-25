<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validate the request data
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed',
        ]);

        // Create a new user instance and save it to the database
        DB::table('users')->insert([
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        dd($request);

        // Redirect to the login page with a success message
        return redirect('/login')->with('status', 'Registration successful! You can now log in.');
    }
}

