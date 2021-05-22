<?php

namespace App;

use App\Customer;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'uid',
        'customer_id',
        'customer_name',
        'discount',
        'shippment_price',
        'total_price',
        'delivery_date',
        'delivery_time',
        'neighbourhood_id',
        'address',
        'payment_method',
        'payment_status',
        'status',
        'extra_description'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function neighbourhood()
    {
        return $this->belongsTo(Neighbourhood::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getDetails()
    {
        $details = "";
        $items = OrderItem::where('order_id', $this->id)->get();
        for ($i=0;$i<count($items);$i++) {
            $details .= $items[$i]->availableProduct->product->name . ($items[$i]->weight > 0 ? ' ' . $items[$i]->weight . ' کیلو' : '');
            if ($i != count($items)-1) $details .= ', ';
        }
        return $details;
    }
    public function getItemsIds()
    {
        $ids = "";
        $items = OrderItem::where('order_id', $this->id)->get();
        for ($i=0;$i<count($items);$i++) {
            $ids .= "#" . $items[$i]->availableProduct->id;
            if ($i != count($items)-1) $ids .= ', ';
        }
        return $ids;
    }
}
