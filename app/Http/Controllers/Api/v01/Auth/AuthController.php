<?php

namespace App\Http\Controllers\Api\v01\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Register New User
     * @method Post
     * @param Request $request
     */
    public function register(Request $request)
    {
        //validate Form Inputs
        $request->validate([
            'name'      =>  ['required'],
            'email'     =>  ['required','email','unique:users'],
            'password'  =>  ['required']
        ]);
        //Insert User To Database
        User::create([
           'name'=> $request->name,
           'email'=> $request->email,
            'password'=> Hash::make($request->password)

        ]);

        return response()->json([
            'message' => "user created successfully"
        ],'201');
    }

    public function login(Request $request)
    {

    }

    public function logout()
    {

    }
}
