<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;
    protected $table = 'features';
    protected $fillable = [
        'title', 'text', 'type'
    ];

    public function items(){
        return $this->hasMany(FeatureItem::class);
    }

    public function products(){
        return $this->hasMany(ProductFeature::class);
    }
}
