<?php

namespace App\Rules;

class UpdateProductRules implements Rules
{
    public static function toArray(): array
    {
        return [
            'id' => 'nullable',
            'name' => 'required',
            'price' => 'required',
            'stock_number' => 'required',
            'id_category' => 'required',
            'description' => 'required',
            'visible' => 'required',
        ];
    }
}
