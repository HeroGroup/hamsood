<?php

namespace App;

use App\AvailableProduct;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'available_product_id'
    ];

    public function availableProduct()
    {
        return $this->belongsTo(AvailableProduct::class);
    }
}
