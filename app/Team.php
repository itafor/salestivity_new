<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'team_name', 'main_acct_id', 'created_by_id', 'description'
    ];

    public function members()
    {
    	return $this->hasMany(TeamMember::class, 'team_id', 'id');
    }
}
