<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Brand extends Model
{ use Notifiable;
    use SoftDeletes;
    protected $fillable = [
        'name', 'slug', 'image','website','position','is_active'
    ];
}
