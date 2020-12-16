<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AvailableProduct extends Model
{
    protected $fillable = [
        'product_id',
        'price',
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
}
