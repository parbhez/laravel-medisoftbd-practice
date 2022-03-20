<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Model;

class ScheduleSlot extends Model
{
    public function block()
    {
        return $this->hasOne('App\Models\HR\ScheduleBlock', 'schedule_slot_id', 'schedule_slot_id');
    }
}
