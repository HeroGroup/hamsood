<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image_url',
        'base_price_url',
        'is_active'
    ];

    public function categories()
    {
        $categories = "";
        $details = ProductCategory::where('product_id', $this->id)->get();
        for ($i=0;$i<count($details);$i++) {
            $categories .= $details[$i]->category->title;
            if ($i != count($details)-1) $categories .= ', ';
        }
        return $categories;
    }
}
