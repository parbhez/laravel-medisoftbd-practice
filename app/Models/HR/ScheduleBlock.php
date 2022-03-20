<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Model;

class ScheduleBlock extends Model
{
    protected $fillable = [
        'schedule_slot_id', 'schedule_block_date'
    ];

    public function isBlock($value, $appointment_Date)
    {
        if ($this->attributes['schedule_slot_id'] === $value) {
            $blockDate = date('Y-m-d', strtotime($this->attributes['schedule_block_date']));
            $appointmentDate = date('Y-m-d', strtotime($appointment_Date));
            $date1 = date_create($blockDate);
            $date2 = date_create($appointmentDate);
            $diff = date_diff($date1, $date2);
            return $diff->format("%r%a") > 0 ? false : true;
        } else {
            return false;
        }
    }
}
