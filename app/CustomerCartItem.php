<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerCartItem extends Model
{
    protected $fillable = [
        'customer_id',
        'available_product_id',
        'weight',
        'real_price',
        'discount'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function availableProduct()
    {
        return $this->belongsTo(AvailableProduct::class);
    }
}
