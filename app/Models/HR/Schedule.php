<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    public function user()
    {
        return $this->hasOne('App\User', 'user_id', 'user_id');
    }

    public function scheduleslots()
    {
        return $this->hasMany('App\Models\HR\ScheduleSlot', 'schedule_id', 'schedule_id');
    }
}
