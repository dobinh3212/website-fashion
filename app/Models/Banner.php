<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Banner extends Model
{
    use Notifiable;
    use SoftDeletes;
    //
    protected  $table='banners';
}
