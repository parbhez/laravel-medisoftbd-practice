<?php

namespace App\Models\Diagnostic;

use Illuminate\Database\Eloquent\Model;

class ServicePackage extends Model
{
    public function servicePackageItems()
    {
    	return $this->hasMany('App\Models\Diagnostic\ServicePackageItem','service_package_id','service_package_id');
    }
}
