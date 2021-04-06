<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'customer_id',
        'transaction_type',
        'title',
        'amount',
        'online_payment_method',
        'tr_status',
        'token'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
