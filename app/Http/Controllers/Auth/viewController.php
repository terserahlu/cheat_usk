<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class viewController extends Controller
{
    public function loginView(){
        return view('auth.login');
    }
}
