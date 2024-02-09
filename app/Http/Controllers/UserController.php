<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

use App\Models\User;



class UserController extends Controller
{
    public function register(RegisterRequest $request) {
        $requests = $request->validated();
        User::create($requests);

        if(Auth::attempt($requests)){
            $request->session()->regenerate();
            return redirect()->route('/');
        } else {
            return redirect()->route('login');
        }
    }

    public function login(LoginRequest $request) {
        $requests = $request->validated();
        if(Auth::attempt($requests)){
            $request->session()->regenerate();
            return redirect()->route('/');
        } else {
            return back()->withErrors(['login' => 'Неправильный логин или пароль']);
        }
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->regenerate();
        return redirect()->route('/');
    }
}
