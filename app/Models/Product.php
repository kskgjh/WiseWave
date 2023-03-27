<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use App\Models\Variant;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'status', 'text', 'amount', 'variants_id'
    ];

    public function variants(){
        return $this->hasMany(Variant::class);
    }

    public function productImgs() :HasMany{
        return $this->hasMany(productImg::class);
    }
}
