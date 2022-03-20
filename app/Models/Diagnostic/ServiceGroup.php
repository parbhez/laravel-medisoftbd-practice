<?php

namespace App\Models\Diagnostic;

use Illuminate\Database\Eloquent\Model;

class ServiceGroup extends Model
{
    protected $primaryKey = 'service_group_id';

    public function serviceGroupItem()
    {
        return $this->hasMany('App\Models\Diagnostic\ServiceGroupItem', 'service_group_id', 'service_group_id');
    }

    public function servicecategory()
    {
        return $this->hasOne('App\Models\Settings\ServiceCategory', 'service_category_id', 'service_category_id');
    }

    public function servicesubcategory()
    {
        return $this->hasOne('App\Models\Settings\ServiceSubCategory', 'service_sub_category_id', 'service_sub_category_id');
    }
}
