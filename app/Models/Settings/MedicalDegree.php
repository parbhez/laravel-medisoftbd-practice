<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class MedicalDegree extends Model
{
    public function doctor()
    {
        return $this->belongsTo('App\Models\HR\Doctor', 'medical_degree_id', 'medical_degree_id');
    }
}
