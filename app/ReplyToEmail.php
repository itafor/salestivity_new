<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReplyToEmail extends Model
{
    use HasFactory, SoftDeletes;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'main_acct_id', 'reply_to_email'
    ];

    public function parent_user()
    {
        return $this->belongsTo('App\User', 'main_acct_id','id');
    }

}
