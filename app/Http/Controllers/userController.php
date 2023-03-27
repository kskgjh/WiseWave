<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Http\Request;
use App\Models\User;

class userController extends Controller
{
    use HasApiTokens;

    

    public function all() {
        return User::all();
    }

    public function selectById (Request $get) {
        $dados = User::find($get->id);
        return $dados;
    }
    
    public function search(Request $get){
        return User::where($get->key, $get->value);

    }

    public function submit(RegisterUserRequest $req) {
        $first = User::get();
        if($first){
            $admin = true;
        } else{
            $admin = false;
        }

        $res = User::create([
            'email'=> $req->email,
            'userName'=> $req->userName,
            'password'=> bcrypt($req->password),
            'admin'=> $admin,
        ]);

        if($res) return redirect()->route('user.login', ['email'=>$req->email]);

        return 'Não foi possivel cadastrar a conta. Tente novamente mais tarde.';
    } 

    public function authenticate(Request $req){
        $credentials = $req->validate([
            'email'=> ['required', 'email'], 
            'password'=> 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $req->session()->regenerate();

            $isAdmin = User::where('email', $req->email)->first()->admin;

            if ($isAdmin) return redirect()->route('admin.index');

            return redirect()->intended(route('index'));
        }

        return back()->withErrors([
            'email'=> 'As informações não coincidem com nenhum registro'
        ]);
    }

}
