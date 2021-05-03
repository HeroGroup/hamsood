<?php

namespace App;

use App\AvailableProduct;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'available_product_id',
        'weight',
        'real_price',
        'discount',
        'nth_buyer',
        'extra_discount'
    ];

    public function availableProduct()
    {
        return $this->belongsTo(AvailableProduct::class);
    }
}
