<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;


class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index(){
        return view('index');
    }

    public function adminForm(){
        return view('site.admin.adminRegister');
    }

    public function renderForm(){
        return view('site.register');
    }

    public function logout(){
        auth::logout();
        return redirect(route('index'));
    }

    public function login(){

        return view('site.loginPage');
    }

    public function accessDenied(){
        return view('site.deniedAccess');
    }
    
}
