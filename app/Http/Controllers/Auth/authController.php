<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class authController extends Controller
{
    public function login(Request $request){
        $validator = validator($request->all(),[
            'username' => 'string|required|max:30',
            'password' => 'string|required|min:3',
        ]);

        if ($validator->fails()){
            return redirect()->route('login')->withErrors($validator)->withInput();
        }
        $credential = $request->only(['username', 'password']);
        if(Auth::attempt($credential)){
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Login Berhasil');
        }
        return redirect()->route('login')->withInput()->with('error', 'Login Gagal');
    }

    public function logout(Request $request){
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logout Berhasil');
    }
}
