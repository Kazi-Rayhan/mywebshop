<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $dates = ['schedule_at'];
    protected $casts = ['from_time' => 'datetime', 'to_time' => 'datetime'];

    protected $fillable = [
        'day',
        'is_open',
        'to_time',
        'is_break',
        'from_time',
        'schedule_at',
        'parent_id'
    ];

    public function scopeOnlyBreaks($query)
    {
        return $query->where('is_break', true);
    }

    public function scopeWorkingHour($query)
    {
        return $query->where('is_break', false);
    }

    public function formatTime($time = null, $format = 'H:i')
    {
        if (is_null($time)) {
            return null;
        }

        $time = strtotime($time);

        return date($format, $time);
    }

    public function breaks()
    {
        return $this->hasMany(Schedule::class, 'parent_id', 'id');
    }
}
