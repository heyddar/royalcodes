<?php

namespace App\Http\Controllers\Api\v01\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\DocBlock\Tags\Throws;

class AuthController extends Controller
{
    /**
     * Register New User
     * @method POST
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
        resolve(UserRepository::class)->create($request);

        return response()->json([
            'message' => "user created successfully"
        ],'201');
    }

    /**
     * Login User
     * @method GET
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        //validate Form Inputs
        $request->validate([
            'email'     =>  ['required','email'],
            'password'  =>  ['required']
        ]);
        //Check User Credentials For Login
        if(Auth::attempt($request->only(['email','password']))){
            return response()->json(Auth::user(),200);
        }
        throw ValidationException::withMessages([
           'email' => "incorrect credentials."
        ]);
    }

    public function user()
    {
        return response()->json(Auth::user(),200);
    }
    /**
     *Logout User
     */
    public function logout()
    {
        Auth::logout();
        return response()->json([
           'message' => "logged out successfully"
        ],200);
    }


}
