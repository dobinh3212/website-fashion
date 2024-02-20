<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    //
    protected $guarded = [];


    public function products()
    {
        return $this->hasMany('App\Models\Product',"product_id","id");
    }
}
