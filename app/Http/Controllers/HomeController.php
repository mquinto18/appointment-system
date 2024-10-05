<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function adminIndex(){
        $totalUsers = User::count();
        return view('dashboard', compact('totalUsers'));
    }

    public function profileSettings(){
        return view('components.profile');
    }

    public function securitySettings(){
        return view('components.security');
    }
}
