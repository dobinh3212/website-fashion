<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Category extends Model
{
    use Notifiable;
    use SoftDeletes;
    //

    protected $fillable = [
        'name', 'slug', 'image','parent_id','position','is_active'
    ];
    public function products()
    {
        return $this->hasMany('App\Models\Product',"category_id","id");
    }

}
