<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_product',
        'id_request',
        'price',
        'amount',
        'status',
        'reference',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'purchase_product', 'purchase_id', 'product_id');
    }
}
