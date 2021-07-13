<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum'
        , [
            'only' => [
                'me',

            ]
        ]);
    }


    function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        // print_r($data);
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['These credentials do not match our records.']
            ], 404);
        }

        $token = $user->createToken('my-app-token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function master_login(Request $request)
    {

        $user = User::where('email', $request->email)->whereIn('role_id', [1, 2, 4])->first();


        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['These credentials do not match our records.']
            ], 404);
        }

        $token = $user->createToken('my-app-token')->plainTextToken;

        return response()->json([
            'token' => $user->createToken('myApp')->plainTextToken,
            'user' => $user,
            'user_type' => 'master'
        ]);
    }


    public function me(Request $request)
    {
        Auth::user();
        return response()->json(['user' => Auth::user()], 200);
    }

    public function logout()
    {

        return Auth::user();
        Auth::user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response()->json([
            'logout' => true,
            'message' => 'logout successfully'
        ]);
    }
}
