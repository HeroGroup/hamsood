<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [ 'mobile' , 'name' , 'token' ];

    public function addresses()
    {
        return $this->hasMany(CustomerAddress::class);
    }
}
