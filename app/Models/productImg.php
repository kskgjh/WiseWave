<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class productImg extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'product_id'];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
