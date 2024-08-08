<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\User;

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
            "password" => "required|string|min:8"
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
        ]);
    
    }
    
    //POST [email, password]
    public function login(Request $request)
    {
        
    }
    
    //GET [Auth: Token]
    public function profile()
    {
    
    }

    //GET [Auth: Token]
    public function logout()
    {

    }
}
