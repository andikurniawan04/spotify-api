<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ResponseJson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    use ResponseJson;

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['register', 'login', 'logout', 'refresh']]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required',
            'password'  => 'required'
        ]);

        if ($validator->fails()) {
            return $this->respondError($validator->errors(), 'Validation Error', 422);
        }

        $credentials = $request->only('email', 'password');

        $token = Auth::guard('api')->attempt($credentials);

        if (!$token) {
            return $this->respondError(null, 'Email or password is wrong', 401);
        }

        return response()->json([
            "status" => true,
            "user" => auth()->guard('api')->user(),
            "access-token" => $token
        ]);
    }

    public function logout()
    {
        Auth::guard('api')->logout();
        return $this->respondSuccess(null, 'Successfully logged out');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return $this->respondError($validator->errors(), 'Validation Error', 422);
        }

        User::create(array_merge(
            $validator->validated(),
            [
                'password' => bcrypt($request->password),
                "role_id" => "USER"
            ]
        ));

        return $this->respondSuccess(null, 'User successfully registered', 201);
    }

    public function refresh()
    {
        $token = JWTAuth::parseToken()->refresh();
        return response()->json([
            'status' => true,
            'refresh-token' => $token
        ]);
    }
}
