<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    protected $fillable = ['neighbourgood_id','details'];

    public function neighbourhood()
    {
        return $this->belonngsTo(Neighbourhood::class);
    }
}
