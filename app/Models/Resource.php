<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasCleanUpSchedule;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Resource extends Model
{
    use HasFactory;
    use HasCleanUpSchedule;

    protected $fillable = ['name', 'available_seats'];

    /**
     * Get all of the resource's schedule.
     */
    public function schedules()
    {
        return $this->morphMany(Schedule::class, 'scheduleable');
    }

    /**
     * get resource's schedule for specific day
     *
     * @param string $day
     * @return \App\Models\Schedule
     */
    public function getScheduleFor($day)
    {
        $schedule = $this->schedules->where('day', $day)->first();

        if ($schedule) {
            return $schedule;
        };

        return new Schedule;
    }
}
