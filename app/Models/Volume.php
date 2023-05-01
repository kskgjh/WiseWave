<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volume extends Model
{
    use HasFactory;
    protected $fillable = [
        'width', 'height', 'weight', 'length', 'product_id', 'amount'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
