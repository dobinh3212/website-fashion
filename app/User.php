<?php

namespace App;

use App\Models\Permission;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'provider', 'provider_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    function role() {
        return $this->belongsTo('App\Models\Role', 'role_id');
    }

    public function hasPermission(Permission $permission) {
        return !!optional(optional($this->role)->permissions)->contains($permission);
    }


}
