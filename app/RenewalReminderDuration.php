<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RenewalReminderDuration extends Model
{
    protected $fillable = ['renewal_id','first_duration','second_duration','third_duration'];

    public function renewal()
    {
    	return $this->belongsTo(Renewal::class, 'renewal_id', 'id');
    }
}
