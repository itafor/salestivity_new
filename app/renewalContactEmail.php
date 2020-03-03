<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class renewalContactEmail extends Model
{
    use SoftDeletes;
    protected $fillable = ['renewal_id','contact_id'];
}
