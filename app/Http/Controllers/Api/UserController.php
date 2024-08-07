<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class UserController extends Controller
{
    use HasApiTokens, HasFactory, Notifiable;

    //POST [username, email, password]
    public function register(Request $request)
    {
    
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
