<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_product extends Model
{
    //
    protected $fillable = [
        'name', 'fullname', 'image', 'sku', 'user_id', 'order_id','product_id', 'price','qty'];
}
