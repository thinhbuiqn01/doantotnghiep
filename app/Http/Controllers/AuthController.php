<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function signup(SignupRequest $request)
    {
        $data = $request->validated();
        $user = User::create([
            "name" => $data['name'],
            "email" => $data['email'],
            "password" => bcrypt($data['password']),
        ]);

        $token = $user->createToken('main')->plainTextToken;

        return response([
            "user" => $user,
            'token' => $token
        ]);
    }

    public function insertList(Request $request)
    {
        /* can fig bug cho nay */
        $user = User::all();
        $data = $request->all();
        for ($i = 0; $i < count($data); $i++) {
            User::create([
                'name' => $data[$i]['name'],
                'email' => $data[$i]['email'],
                'password' => bcrypt($data[$i]['password'])
            ]);
        }

        return response([
            "status" =>  $data,
        ]);
    }
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $remember = $credentials['remember'] ?? false;
        unset($credentials['remember']);

        if (!Auth::attempt($credentials, $remember)) {
            return response([
                'error' => 'Thông tin đăng nhập cung cấp không chính xác '
            ], 442);
        }

        $user = Auth::user();

        $token = $user->createToken('main')->plainTextToken;
        return response([
            "user" => $user,
            'token' => $token,
        ]);
    }
    public function logout(Request $request)
    {
        $user = Auth::user();
        $user->currentAccessToken()->delete();

        return response([
            'success' => true
        ]);
    }
}
