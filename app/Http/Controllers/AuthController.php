<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use http\Env\Response;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function Register(Request $request)
    {
        $request->validate([
                'First_name' => 'required',
                'Last_name' => 'required',
                'mobile' => ['required', 'unique:users,mobile'],
                'password' => ['required'],
            ]
        );

        $user = User::query()->create([
            'First_name' => $request->First_name,
            'Last_name' => $request->Last_name,
            'mobile' => $request->mobile,
            'password' => bcrypt($request->password)

        ]);
        if (!$user) {
            return response()->json([
                'success' => false,
                'massage' => 'Registration failed '
            ]);
        }
        $token = $user->createToken('Personal Access Token')->token;
        $user['remember_token'] = $token;
        return Response([
            'user' => $user,
            'Access_Token' => $token
        ]);

    }

    public function Login(Request $request)
    {
        $login = $request->validate([
            'mobile' => 'required|exists:users',
            'password' => ' required'
        ]);
        if (!auth()->attempt($login)) {
            return response()->json([
                'errors' => ['massage' => 'Can not log in Please verify your data']
            ], status: 422);

        }
        $user = $request->user();
        $token = $user->createToken('Personal Access Token');
        $user['remember_token'] = $token;
        $token->token->save();
        return response()->json([
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);

    }

    public function logout()
    {
        $user = Auth::user()->token()->revoke();
        return response()->json([
            'success' => 'logged out successfully'
        ]);
    }

    public function profile()
    {
        $profile = Auth::user();
        $fullName = [$profile->First_name, $profile->Last_name];
        return response()->json([$fullName]);
    }







}
