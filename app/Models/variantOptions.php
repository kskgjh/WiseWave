<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Variant;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class variantOptions extends Model
{
    use HasFactory;

    protected $fillable = [
        'option', 'color', 'variant_id'
    ];

    public function Variant(): BelongsTo{
        return $this->belongsTo(Variant::class);
    }
}
