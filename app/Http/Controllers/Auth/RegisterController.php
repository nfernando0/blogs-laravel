<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function checkUsername(Request $request)
    {
        $username = $request->username;
        $available = !User::where('username', $username)->exists();
        return response()->json(['available' => $available]);
    }
    public function checkEmail(Request $request)
    {
        $email = $request->email;
        $available = !User::where('email', $email)->exists();
        return response()->json(['available' => $available]);
    }

    public function register(Request $request)
    {

        $request->validate([
            'username' => 'required|unique:users', // Validasi username unik
            'email' => 'required|email', // Validasi email unik
            'password' => 'required|string|min:6',
        ]);
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'Register Successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Register Failed'
            ]);
        }
    }
}
