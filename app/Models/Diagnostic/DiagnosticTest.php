<?php

namespace App\Models\Diagnostic;

use Illuminate\Database\Eloquent\Model;

class DiagnosticTest extends Model
{
    protected $primaryKey = 'diagnostic_test_id';

    public function service_category()
    {
        return $this->belongsTo('App\Models\Settings\ServiceCategory', 'service_category_id', 'service_category_id');
    }

    public function service_sub_category()
    {
        return $this->belongsTo('App\Models\Settings\ServiceSubCategory', 'service_sub_category_id', 'service_sub_category_id');
    }
    public function serviceGroupItem()
    {
        return $this->belongsTo('App\Models\Diagnostic\ServiceGroupItem', 'diagnostic_test_id', 'diagnostic_test_id');
    }
}

