<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable 
{
    use HasFactory;

    
    protected $fillable = [
        'email', 'password', 'userName', 'profile_pic', 'admin', 'phone', 'address_id', 'cpf'
    ];

    protected $protected = ['password'];

    public function address(){
        return $this->hasOne(Address::class);
    }

}
