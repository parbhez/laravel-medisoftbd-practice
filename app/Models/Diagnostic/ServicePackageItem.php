<?php

namespace App\Models\Diagnostic;

use Illuminate\Database\Eloquent\Model;

class ServicePackageItem extends Model
{
    public function servicePackage()
    {
    	return $this->belongsTo('App\Models\Diagnostic\ServicePackage','service_package_id','service_package_id');
    }
}
