<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceContact extends Model
{
    use HasFactory;

      public function user()
    {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }
}
