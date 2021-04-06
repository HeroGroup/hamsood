<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'mobile',
        'name',
        'token',
        'gender',
        'profile_image_url',
        'balance'
    ];

    public function addresses()
    {
        return $this->hasMany(CustomerAddress::class);
    }

    public function getCartList()
    {
        $details = "";
        $items = CustomerCartItem::where('customer_id', $this->id)->get();
        for ($i=0;$i<count($items);$i++) {
            $details .= $items[$i]->availableProduct->product->name . ($items[$i]->weight > 0 ? ' ' . $items[$i]->weight . ' کیلو' : '');
            if ($i != count($items)-1) $details .= ', ';
        }
        return $details;
    }
}
