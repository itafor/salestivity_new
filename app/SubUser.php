<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\SoftDeletes;

class SubUser extends Authenticatable
{
    use SoftDeletes, Notifiable;

    protected $guard = 'sub_user';
    protected $table = 'sub_users';
    protected $guarded = ['id',];

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsTo('App\Role', 'role_id');
    }

    public function dept()
    {
        return $this->belongsTo('App\Department', 'department_id');
    }

    public function unit()
    {
        return $this->belongsTo('App\Unit', 'unit_id');
    }

    public function reportsTo()
    {
        return $this->belongsTo('App\User', 'reports_to');
    }
}

    

