<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Article extends Model
{
    use Notifiable;
    use SoftDeletes;
    //
    protected $fillable = [
        '	title', 'slug', 'image','desc','content','is_active','type','position','status','url','is_active','user_id'
        ,'meta_title','meta_description'
    ];
}
