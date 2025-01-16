<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Booking;
use Carbon\CarbonPeriod;
use App\Models\Packageoption;
use Illuminate\Database\Eloquent\Collection;

class ServicePeriod
{
    private $endTime;
    private $bookings = [];
    private Collection $breaks;
    private $startTime;
    private int $interval;
    private $requestedDate;
    protected User $manager;
    protected Packageoption $option;

    public function __construct(Packageoption $option, User $manager, $requestedDate)
    {
        $this->option = $option;
        $this->manager = $manager;
        $this->requestedDate = Carbon::createFromFormat('m/d/Y', $requestedDate);
        $this->setInterval($option->minutes);
        $this->setBookings();
    }

    public function getManagerSchedule()
    {
        $schedule = $this->manager->schedules()
            ->whereDate('schedule_at', $this->requestedDate)
            ->first();

        if (!$schedule) {
            $schedule = $this->manager->schedules()
                ->workingHour()
                ->where('day', $this->requestedDate->format('l'))
                ->first();
        }

        return $schedule;
    }

    public function getPeriods()
    {
        $isAvailable = $this->setPeriodLength();

        if (!$isAvailable || !$this->isValidationPassed()) {
            return [];
        }

        $this->setBreaks();

        return $this->make();
    }

    private function setBreaks(): static
    {
        $this->breaks =  $this->getManagerSchedule()->breaks;

        return $this;
    }

    public function make()
    {
        $times = CarbonPeriod::since($this->startTime)
        ->minutes(30)
        ->until($this->endTime);

    $availableTime = [];

    foreach ($times as $time) {
        if ($time->copy()->addMinutes($this->interval)->gt($this->endTime)) {
            break;
        }

        $period = CarbonPeriod::since($time->copy())
            ->minutes($this->interval)
            ->until($time->copy()->addMinutes($this->interval));

        if ($this->onBreak($period)) {
            continue;
        }

        $isOverlap = false;

        foreach ($this->bookings as $book) {
            $csk = $period->overlaps(
                $book->start_at,
                $book->end_at->addMinutes($this->option->buffer)
            );

            if ($csk) {
                $isOverlap = true;
                break;
            }
        }

        if (!$isOverlap) {
            $end = $time->copy()->addMinutes($this->interval)->format('h:ia');

            $availableTime[] = [
                'id' => uniqid(),
                'name' => $time->format('h:ia') . ' - ' . $end,
                'date' => $this->requestedDate->format('F d, Y'),
                'type' => 'event',
                'slot' => $time->format('H:i'),
            ];
        }
    }

    return $availableTime;
    }

    public function setStartTime($time)
    {
                
        $this->startTime = $this->requestedDate->copy()->setTimeFromTimeString($time->format('H:i'));

        return $this;
    }

    public function setEndTime($time)
    {
        $this->endTime = $this->requestedDate->copy()->setTimeFromTimeString($time->format('H:i'));

        return $this;
    }

    public function setBookings()
    {
        $bookings = Booking::select(['id', 'start_at', 'end_at'])
            ->where('manager_id', $this->manager->id)
            ->where('status', '!=', 3)
            ->whereDate('start_at', $this->requestedDate->copy()->startOfDay())
            ->get();
        

        $this->bookings = $bookings;

        return $this;
    }

    public function setInterval($time)
    {
        $this->interval = $time;

        return $this;
    }

    public function setPeriodLength($managerSchedule = null)
    {
        $managerSchedule = $managerSchedule ?? $this->getManagerSchedule();

        if (
            !$managerSchedule ||
            !$managerSchedule->from_time ||
            !$managerSchedule->to_time ||
            !$managerSchedule->is_open
        ) {
            return false;
        }

        $this->setStartTime($managerSchedule->from_time);

        $this->setEndTime($managerSchedule->to_time);

        return $this;
    }

    public function isValidationPassed(): bool
    {
        if ($this->requestedDate->lt(today())) {
            return false;
        }

        return true;
    }

    private function onBreak($period): bool
    {
        foreach ($this->breaks as $brk) {
            $startTime = $this->requestedDate->copy()->setTimeFromTimeString($brk->from_time);
            $endTime = $this->requestedDate->copy()->setTimeFromTimeString($brk->to_time);

            if ($period->overlaps($startTime, $endTime)) {
                return true;
            }
        }

        return false;
    }
}
