<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AvailableProduct extends Model
{
    protected $fillable = [
        'product_id',
        'price',
        'until_day',
        'available_until_datetime',
        'quantity',
        'maximum_group_members',
        'is_active'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function details()
    {
        return $this->hasMany(AvailableProductDetail::class);
    }

    public function getDiscounts()
    {
        $discounts = "";
        $details = AvailableProductDetail::where('available_product_id', $this->id)->get();
        for ($i=0;$i<count($details);$i++) {
            $discounts .= $details[$i]->discount.'% ';
            if ($i != count($details)-1) $discounts .= ', ';
        }
        return $discounts;
    }

    public function getOrdersCount()
    {
        return OrderItem::where('available_product_id', $this->id)->count();
    }

    public function getSentOrdersCount()
    {
        $items = OrderItem::where('available_product_id', $this->id)->select('order_id')->distinct()->get();
        return Order::whereIn('id', $items)->where('status', 2)->count();
    }
}
