<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Cart;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Http\Request;
use App\Models\User;

class userController extends Controller
{
    use HasApiTokens;

    

    public function all() {
        return User::all();
    }

    public function find (Request $req) {
        $user = User::with('address')->with('cart')->find($req->id);
        //dd($user);
        return $user;
    }
    
    public function search(Request $get){
        return User::where($get->key, $get->value);

    }

    public function registerAdmin(Request $req){
        $req->validate([
            'userName'=> 'required',
            'password'=> 'required',
            'email'=> 'required'
        ]);

        $user = new User([
            'userName'=> $req->userName,
            'password'=> bcrypt($req->password),
            'email'=> $req->email,
            'admin'=> true
        ]);

        if($user->save()) return $this->authenticate($req);

        dd("ocorreu um problema");
    }

    public function submit(RegisterUserRequest $req) {
        $address = Address::where('street', $req->street)->where('number',$req->number)->first();

        if(!$address) {
            $intCep = str_replace('-', '', $req->cep);

            $newAddress = new Address([
                'street'=> $req->street,
                'number'=>$req->number,
                'cep'=> $intCep,
                'neighborhood'=> $req->neighborhood,
                'complements'=> $req->complements?? '',
                "city"=> $req->city,
                'state'=> $req->state
            ]);
            $newAddress->save();

            $addressId = $newAddress->id;
        } else {
            $addressId = $address->id;
        }

        $intCpf = str_replace('-', '', str_replace('.','',$req->cpf));

        $res = User::create([
            'email'=> $req->email,
            'userName'=> $req->userName,
            'password'=> bcrypt($req->password),
            "cpf"=> $intCpf,
            'phone'=> $req->phone,
            'address_id'=> $addressId
        ]);

        if($res) return $this->authenticate($req);

        return back()->with('error', 'Não foi possivel cadastrar a conta. Tente novamente mais tarde.');
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
