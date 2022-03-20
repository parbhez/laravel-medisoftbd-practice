<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    public function employee()
    {
        return $this->belongsTo('App\Models\HR\Employee', 'designation_id', 'designation_id');
    }
    public function doctor()
    {
        return $this->belongsTo('App\Models\HR\Doctor', 'designation_id', 'designation_id');
    }
}
