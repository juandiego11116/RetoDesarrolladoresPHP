<?php

namespace App\Rules;

class ProductRules implements Rules
{
    public static function toArray(): array
    {
        return [
            'name' => 'required',
            'price' => 'required',
            'stock_number' => 'required',
            'id_category' => 'required',
            'description' => 'required',
            'photo' => 'required',
            'visible' => 'required',
        ];
    }
}
