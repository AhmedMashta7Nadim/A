<?php

namespace App\Http\Controllers;

use App\Models\Repo\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    private UserRepository $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function getUsers()
    {
        try {
            return $this->userRepo->getAll();
            return response()->json(["data" => $data], 200);
        } catch (Exception $exp) {
            return response()->json(["error" => $exp->getMessage()], 404);
        }
    }

    // http://127.0.0.1:8000/api/user/getByIdUser/ ال اي دي الخاص بالمستخم الذي تيد عرضه
    public function getByIdUser($id)
    {
        return $this->userRepo->getById($id);
    }

    public function AddUser(Request $request)
    {
        $data = $request->only(['name', 'email', bcrypt('password')]);
        // $data["password"]=bcrypt($data["password"]);
        $this->userRepo->add($data);
        return response()->json(['message' => 'User added successfully'], 201);
    }

    public function updateUser($id, Request $item)
    {
        $data = $item->only(["name", "email", bcrypt("password"), "Role"]);
        return $this->userRepo->update($id, $data);
    }
    public function SoftDeleted($id)
    {
        return $this->userRepo->deleteSoft($id);
    }

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
