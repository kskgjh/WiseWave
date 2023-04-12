<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class adminController extends Controller
{
    public function index(){
        return view('site.admin.adminPanel');
    }

    public function submit(Request $req){
        dd($req);
    }
}
