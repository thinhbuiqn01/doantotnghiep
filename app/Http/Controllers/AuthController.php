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

    public function users($role)
    {
        $users = User::where('role', "=", $role)->get();
        if (count($users) > 0) {
            return response([
                "status" => 200,
                'users' => $users
            ]);
        }
    }

    public function signup(Request $request)
    {
        $data = $request->all();
        $user = User::create([
            "name" => $data['name'],
            "email" => $data['email'],
            'role' => 3,
            'phone' => "",
            'status' => false,
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

        $data = $request->all();
        for ($i = 0; $i < count($data); $i++) {
            User::create([
                'name' => $data[$i]['name'],
                'role' => 1,
                'status' => 1,
                'email' => $data[$i]['email'],
                'phone' => $data[$i]['phone'],
                'password' => bcrypt($data[$i]['password'])
            ]);
        }

        $user = User::all();

        return response([
            "status" => 200,
            '$user' => $user
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

    public function update($id, Request $request)
    {
        $user = User::find($id);
        $user->status = $request->status;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);

        $user->update();
        return response([
            "status" => 200,
            "data" => $user
        ]);
    }
}
