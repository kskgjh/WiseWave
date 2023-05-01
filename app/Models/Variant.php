<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\variantOptions;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;

    protected $fillable = ["title"];

    public function variantOptions(){
        return $this->hasMany(variantOptions::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }
}
