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
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
