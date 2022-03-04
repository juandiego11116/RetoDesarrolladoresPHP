<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    public function categories():HasOne
    {
        return $this->hasOne(Category::class);
    }

    protected $fillable = [
        'name',
        'price',
        'stock_number',
        'id_category',
        'description',
        'photo',
        'visible',
    ];

    public function getPhotoAttribute():string
    {
        return $this->attributes['photo'] = '/storage/'.$this->attributes['photo'];
    }

}
