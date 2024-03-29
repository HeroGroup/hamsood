<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'customer_id',
        'transaction_sign',
        'transaction_type',
        'title',
        'amount',
        'online_payment_method',
        'tr_status',
        'token',
        'trans_id'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
