<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\DocBlock\Tags\Throws;
use Symfony\Component\HttpFoundation\Response;

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
        $user = resolve(UserRepository::class)->create($request);

        $defaultSuperAdminEmail = config('permission.default_super_admin_email');
        $user->email == $defaultSuperAdminEmail ? $user->assignRole('Super Admin') : $user->assignRole('User');


        return response()->json([
            'message' => "user created successfully"
        ],Response::HTTP_CREATED);
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
            return response()->json(Auth::user(),Response::HTTP_OK);
        }
        throw ValidationException::withMessages([
           'email' => "incorrect credentials."
        ]);
    }

    public function user()
    {
        return response()->json(Auth::user(),Response::HTTP_OK);
    }
    /**
     *Logout User
     */
    public function logout()
    {
        Auth::logout();
        return response()->json([
           'message' => "logged out successfully"
        ],Response::HTTP_OK);
    }


}
