<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Booking;
use App\Models\Service;
use Carbon\CarbonPeriod;

class Period
{
    private $endTime;
    private $bookings = [];
    private $startTime;
    private int $interval;
    private $requestedDate;
    protected User $manager;
    protected Service $service;

    public function __construct(Service $service, User $manager, $requestedDate)
    {
        $this->service = $service;
        $this->manager = $manager;
        $this->requestedDate = Carbon::createFromFormat('m/d/Y', $requestedDate);
        $this->setInterval($service->needed_time);
        $this->setBookings();
    }

    public function getManagerSchedule()
    {
        $schedule = $this->manager->schedules()
            ->where('day', $this->requestedDate->format('l'))
            ->first();

        return $schedule;
    }

    public function getServiceSchedule()
    {
        $schedule = $this->service->resource->schedules()
            ->where('day', $this->requestedDate->format('l'))
            ->first();

        return $schedule;
    }

    public function getPeriods()
    {
        $isAvailable = $this->setPeriodLength();

        if (!$isAvailable || !$this->isValidationPassed()) {
            return [];
        }

        return $this->make();
    }
    public function make()
    {
        $times = CarbonPeriod::since($this->startTime)
            ->minutes(15)
            ->until($this->endTime);

        $availableTime = [];

        foreach ($times as $time) {
            if ($time->copy()->addMinutes($this->interval)->gt($this->endTime)) {
                break;
            }

            $period = CarbonPeriod::since($time->copy())
                ->minutes($this->interval)
                ->until($time->copy()->addMinutes($this->interval));

            foreach ($this->bookings as $book) {
                $csk = $period->overlaps($book->start_at, $book->end_at);

                if ($csk) {
                    continue 2;
                }
            }

            $end = $time->copy()->addMinutes($this->interval)->format('h:ia');

            $availableTime[] = [
                'id'    => uniqid(),
                'name' => $time->format('h:ia') . ' - ' . $end,
                'date' => $this->requestedDate->format('F d, Y'),
                'type' => 'event',
                'slot'  => $time->format('H:i'),
            ];
        }

       

        return $availableTime;
    }
    // public function make()
    // {
    //     $times = CarbonPeriod::since($this->startTime)
    //         ->minutes(15)
    //         ->until($this->endTime);

    //     $availableTime = [];

    //     foreach ($times as $time) {
    //         if ($time->copy()->addMinutes($this->interval)->gt($this->endTime)) {
    //             break;
    //         }
    //         if (Booking::select('id', 'start_at', 'end_at')
    //             ->where('manager_id', $this->manager->id)
    //             ->whereDate('start_at', $this->requestedDate->copy()->startOfDay())->whereTime('start_at', $time)->count() >= $this->service->booking_per_slot
    //         ) {
    //             continue;
    //         }
    //         // $period = CarbonPeriod::since($time->copy())
    //         //     ->minutes($this->interval)
    //         //     ->until($time->copy()->addMinutes($this->interval));

    //         // foreach ($this->bookings->whereTime as $book) {
    //         //     $csk = $period->overlaps($book->start_at, $book->end_at);

    //         //     if ($csk) {
    //         //         continue 2;
    //         //     }
    //         // }

    //         $end = $time->copy()->addMinutes($this->interval)->format('h:ia');

    //         $availableTime[] = [
    //             'id'    => uniqid(),
    //             'name' => $time->format('h:ia') . ' - ' . $end,
    //             'date' => $this->requestedDate->format('F d, Y'),
    //             'type' => 'event',
    //             'slot'  => $time->format('H:i'),
    //         ];
    //     }

    //     // dd($this->endTime, $time);

    //     return $availableTime;
    // }

    public function setStartTime($time)
    {
        $this->startTime = $this->requestedDate->copy()->setTimeFromTimeString($time);

        return $this;
    }

    public function setEndTime($time)
    {
        $this->endTime = $this->requestedDate->copy()->setTimeFromTimeString($time);

        return $this;
    }

    public function setBookings()
    {
        $bookings = Booking::select('id', 'start_at', 'end_at')
            ->where('manager_id', $this->manager->id)
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

    public function setPeriodLength($managerSchedule = null, $serviceSchedule = null)
    {
        $managerSchedule = $managerSchedule ?? $this->getManagerSchedule();
        $serviceSchedule = $serviceSchedule ?? $this->getServiceSchedule();

        if (
            !$managerSchedule ||
            !$serviceSchedule ||
            !$managerSchedule->from_time ||
            !$managerSchedule->to_time ||
            !$serviceSchedule->from_time ||
            !$serviceSchedule->to_time ||
            !$managerSchedule->is_open ||
            !$serviceSchedule->is_open
        ) {
            return false;
        }

        $biggerTime = $this->getBiggerTime($managerSchedule->from_time, $serviceSchedule->from_time);

        $this->setStartTime($biggerTime);

        $smallerTime = $this->getBiggerTime($managerSchedule->to_time, $serviceSchedule->to_time, false);

        $this->setEndTime($smallerTime, false);

        return $this;
    }

    private function getBiggerTime($time1, $time2, $needBigger = true)
    {
        $converted1 = strtotime($time1);
        $converted2 = strtotime($time2);

        $time = $time1;

        $time = $converted1 > $converted2 ? $time1 : $time;

        $time = $converted1 < $converted2 ? $time2 : $time;

        if (!$needBigger) {
            $time = strtotime($time) > $converted1 ? $time1 : $time2;
        }

        return $time;
    }

    public function isValidationPassed(): bool
    {
        if ($this->requestedDate->lt(today())) {
            return false;
        }

        return true;
    }
}
