<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'cart_id', 'amount', 'variant_id', 'current_price'];
    
    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function cart(){
        return $this->belongsTo(Cart::class);
    }

    public function variantOption(){
        return $this->belongsTo(variantOptions::class, 'variant_id');
    }

}
