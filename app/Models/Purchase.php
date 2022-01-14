<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    public function products()
    {
        return $this->hasMany(product::class);
    }

    protected $fillable = [
        'id_product',
        'price',
        'amount',

    ];
}
