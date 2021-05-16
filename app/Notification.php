<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'customer_id',
        'notification_title',
        'notification_text',
        'save_inbox',
        'notification_type',
        'viewed_at'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
