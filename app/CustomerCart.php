<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerCart extends Model
{
    protected $fillable = [
        'customer_id',
        'available_product_id',
        'weight',
        'base_price'
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
