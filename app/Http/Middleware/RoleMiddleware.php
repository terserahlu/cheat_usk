<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,... $roles): Response
    {
        if(!(Auth::check())){
            return redirect()->route('login')->with('failed','Anda Tidak Memiliki Akses, Silahkan Login Terlebih Dahulu');
        }
        
        if(!(in_array(Auth::user()->role, $roles))){
            return redirect()->route('dashboard')->with('failed','Akses Anda Ditolak, Kunci Akses Tidak sesuai');
        }

        return $next($request);
    }
}
