<?php

namespace App\Models\Diagnostic;

use Illuminate\Database\Eloquent\Model;

class ServiceGroupItem extends Model
{
    public function servicegroup()
    {
        return $this->belongsTo('App\Models\Diagnostic\ServiceGroup', 'service_group_id', 'service_group_id');
    }
    
    public function service()
    {
        return $this->hasOne('App\Models\Diagnostic\DiagnosticTest', 'diagnostic_test_id', 'diagnostic_test_id');
    }


}
