<?php


namespace App\Repositories;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function find($id)
    {
        return User::find($id);
    }
    /**
     * @return User
     * @param Request $request
     */
    public function create(Request $request): User
    {
       return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)

        ]);
    }
}
