<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    
    public function serviceSubCategories()
    {
    	return $this->hasMany('App\Models\Settings\ServiceSubCategory','service_category_id','service_category_id');
    }
    public function tests()
    {
    	return $this->hasMany('App\Models\Diagnostic\DiagnosticTest','service_category_id','service_category_id');
    }
}
