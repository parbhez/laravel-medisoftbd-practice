<?php

namespace App\Models\Outdoor;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    public function user()
    {
        return $this->hasOne('App\User', 'user_id', 'user_id');
    }
}
