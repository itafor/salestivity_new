<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable 
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'last_name', 'company_name', 'phone', 'subdomain', 'email', 'password', 'profile_id','company_logo', 'company_logo_url'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
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
    public function renewalPayment(){
        return $this->hasMany(RenewalPayment::class);
    }

     public function subUsers(){
        return $this->hasMany(SubUser::class,'main_acct_id','id');
    }

     public function company_detail(){
        return $this->hasOne(CompanyDetail::class, 'main_acct_id', 'id');
    }

    public function myEmailMarketing(){
        return $this->hasMany(EmailMarketing::class,'main_acct_id','id');
    }

    
}
