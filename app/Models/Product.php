<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Product extends Model
{
    //
    use Notifiable;
    use SoftDeletes;
    protected $fillable = [
        'name', 'slug', 'image','stock','price','sale','position','is_active','is_hot','views','category_id','url',
        'color','memory','brand_id','vendor_id','summary','description','meta_title','meta_description','user_id'
    ];
    public function categories()
    {
        return $this->belongsTo('App\Models\Category',"category_id","id");

    }
    public function images() {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
    public function attributes()
    {
        return $this->hasMany('App\Models\ProductAttribute');
    }
    function orders(){
        return $this->belongsToMany('App\Models\Order');
    }

}
