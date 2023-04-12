<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $table = 'addresses';
    protected $fillable = [
        'street', 'number', 'cep', 'neighborhood', 'complements', 'city', 'state'
    ];

    public function users(){
        return $this->hasMany(User::class);
    }

}
