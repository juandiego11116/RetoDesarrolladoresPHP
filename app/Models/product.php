<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'stock_number',
        'id_category',
        'description',
        'photo',
        'visible',
    ];

    public function categories(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'id_category');
    }

    public function purchases(): BelongsToMany
    {
        return $this->belongsToMany(Purchase::class, 'purchase_product', 'purchase_id', 'product_id');
    }

    public function scopeSearch(Builder $query, $search): Builder
    {
        if ($search) {
            return $query->where('name', 'LIKE', "%$search%");
        }
        return $query;
    }

    public function getPhotoAttribute(): string
    {
        return $this->attributes['photo'] = '/storage/'.$this->attributes['photo'];
    }
}
