<?php

namespace App\Http\Controllers\Api\v1\User;

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

class UserController extends Controller
{
    public function userNotifications()
    {
        return \response()->json(\auth()->user()->unreadNotifications(), Response::HTTP_OK);
    }
}
