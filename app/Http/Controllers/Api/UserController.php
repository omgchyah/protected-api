<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use HasApiTokens, HasFactory, Notifiable;

    //POST [username, email, password]
    public function register(Request $request)
    {
        //Validation
        $request->validate([
            "username" => "nullable|string",
            "email" => "required|string|email|unique:users",
            "password" => "required|string|min:6"
        ]);

        if ($request->username === null) {
            $username = "anonymous";
            $role = "guest";
        } else {
            $username = $request->username;
            $role = "user";
        }

        //Create User
        $user = User::create([
            "username" => $username,
            "role" => $role,
            "email" => $request->email,
            "password" => bcrypt($request->password)
        ]);

        return response()->json([
            "status" => true,
            "message" => "User registered succesfully",
            "data" => $user
        ], 200);
    
    }
    
    //POST [email, password]
    public function login(Request $request)
    {
        //Validation
        $request->validate([
            "email" => "required|string|email",
            "password" => "required|string"
        ]);

        //Email check
        $user = User::where("email", $request->email)->first();

        if(!empty($user)) {
            if(Hash::check($request->password, $user->password)) {
                $token = $user->createToken("myToken")->accessToken;
                return response()->json([
                    "status" => true,
                    "message" => "Login successful",
                    "data" => [
                        $user->only(['id', 'username', 'email', 'role']),
                        "token" => $token,
                    ]  
                ], 200);
            } else {
                return response()->json([
                    "status" => false,
                    "message" => "Password didn't match",
                ], 401);
            }

        } else {
            return response()->json([
                "status" => false,
                "message" => "Email doesn't exist",
            ], 401);
        }
    }
    
    //GET [Auth: Token]
    public function profile()
    {
        $userData = auth()->user();

        return response()->json([
            "status" => true,
            "message" => "Profile information",
            "data" => $userData,
        ]);
    
    }

    //GET [Auth: Token]
    public function logout()
    {
        $token = auth()->user()->token();

        $token->revoke();

        return response()->json([
            "status" => true,
            "message" => "User logged out successfully",
        ]);

    }
}
