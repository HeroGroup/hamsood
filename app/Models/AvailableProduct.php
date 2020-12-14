<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AvailableProduct extends Model
{
    protected $fillable = ['product_id', 'price', 'available_until_datetime', 'quantity', 'total_group_members'];
}
