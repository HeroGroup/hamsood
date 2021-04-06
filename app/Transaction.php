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
        'tr_status',
        'token'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
