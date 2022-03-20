<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class EducationalQualification extends Model
{
    public function employee()
    {
        return $this->belongsTo('App\Models\HR\Employee', 'educational_qualification_id', 'educational_qualification_id');
    }
    public function doctor()
    {
        return $this->belongsTo('App\Models\HR\Doctor', 'educational_qualification_id', 'educational_qualification_id');
    }
}

// educational_qualification_id