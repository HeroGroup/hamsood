<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AvailableProductDetail extends Model
{
    protected $fillable = [
        'available_product_id',
        'level',
        'discount'
    ];

    public function availableProduct()
    {
        return $this->belongsTo(AvailableProduct::class);
    }
}
