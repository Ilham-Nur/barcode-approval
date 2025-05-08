<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
   public function index()
   {

    return view ('login.login');
   }

   public function ajaxLogin(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Coba login
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate(); // regenerate session untuk keamanan
            return response()->json([
                'status' => true,
                'message' => 'Login berhasil',
                'redirect' => route('dashboard'), // ganti sesuai route dashboard kamu
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Email atau password salah',
        ], 401);
    }
}
