<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Variant;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'status', 'text', 'amount', 'variant_id', 'category_id', 'price'
    ];

    public function variants(){
        return $this->belongsTo(Variant::class, 'variant_id');
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function productImgs(){
        return $this->hasMany(productImg::class);
    }

    public function volumes(){
        return $this->hasMany(Volume::class);
    }
}
