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

    public function students($role)
    {
        $users = User::where('role', "=", $role)->get();
        if (count($users) > 0) {
            return response([
                "status" => 200,
                'users' => $users
            ]);
        }
    }

    public function index()
    {
        $users = User::all();
        return response([
            "status" => 'success',
            "users" => $users
        ]);
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
            'data' => $data,
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
                'status' => 'error',
                'message' => 'Thông tin đăng nhập cung cấp không chính xác '
            ], 442);
        }

        $user = Auth::user();

        $token = $user->createToken('main')->plainTextToken;
        return response([
            "user" => $user,
            "status" => "success",
            "message" => "Đăng nhập thành công",
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

    public function getInform($id)
    {
        $inform = User::find($id)->notifications->toArray();

        if ($inform) {
            return response([
                'status' => 'success',
                'inform' => $inform,
            ]);
        } else {
            return response([
                'status' => 'error',
                'inform' => [],
            ]);
        }
    }

    public function getInfo($id)
    {
        $info =  User::find($id)->businesses;
        if ($info) {
            return response([
                'status' => 'success',
                'data' => $info->toArray(),
            ]);
        } else {
            return response([
                'status' => 'error',
            ]);
        }
    }


    public function closeAccount($id)
    {
        $account = User::find($id);
        $account->status = 0;
        $account->update();

        return response([
            'status' => 'success',
            'user' => $account
        ]);
    }

    public function openAccount($id)
    {
        $account = User::find($id);
        $account->status = 1;
        $account->update();

        return response([
            'status' => 'success',
            'user' => $account
        ]);
    }
}
