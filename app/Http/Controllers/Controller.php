<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Http\Request;
use App\Models\User;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index(){
        return view('index');
    }

    public function renderForm(){
        return view('site.register');
    }

    public function logout(){
        auth::logout();
        return redirect(route('index'));
    }

    public function login(string $email = null){

        return view('site.login', ['email' => $email]);
    }

    
}
