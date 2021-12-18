<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
        'code', 'fullname', 'phone', 'email', 'address', 'address2','discount', 'note','coupon','product_id', 'product_qty', 'total', 'payment', 'status','customer_id'];


    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    function products(){
        return $this->belongsToMany('App\Models\Product');
    }


}
