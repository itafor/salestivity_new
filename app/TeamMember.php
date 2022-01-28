<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamMember extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'team_id', 'sub_user_id'
    ];

    public function getMember()
    {
    	return $this->belongsTo(SubUser::class,'sub_user_id', 'id');
    }
}
