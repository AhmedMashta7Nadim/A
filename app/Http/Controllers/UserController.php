<?php

namespace App\Http\Controllers;

use App\Models\Repo\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
// use App\Repositories\UserRepository;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    private UserRepository $userRepo;

    // حقن التابع (Dependency Injection) للـ UserRepository
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }
    // private UserRepository $userRepo;
    // public function __construct( UserRepository $userRepo)
    // {
    //     $this->userRepo=$userRepo;
    // }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        // $token = JWTAuth::fromUser($user);
        $token = Auth::login($user);

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Logged out successfully']);
    }
}
