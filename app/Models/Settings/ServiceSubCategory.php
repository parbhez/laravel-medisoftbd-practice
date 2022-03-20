<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class ServiceSubCategory extends Model
{
    public function serviceCategory()
    {
    	return $this->belongsTo('App\Models\Settings\ServiceCategory','service_category_id','service_category_id');
    }
    public function tests()
    {
        return $this->hasMany('App\Models\Diagnostic\DiagnosticTest', 'service_sub_category_id', 'service_sub_category_id');
    }
}
