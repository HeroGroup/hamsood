<?php

namespace App;

use App\Customer;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'discount',
        'total_price',
        'status'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function getDetails()
    {
        $details = "";
        $items = OrderItem::where('order_id', $this->id)->get();
        for ($i=0;$i<count($items);$i++) {
            $details .= $items[$i]->availableProduct->product->name;
            if ($i != count($items)-1) $details .= ', ';
        }
        return $details;
    }
}
