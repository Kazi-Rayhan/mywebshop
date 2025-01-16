<?php

namespace App\Http\Controllers\Dashboard\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\ManagerScheduleRequest;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class AvailabilityController extends Controller
{
    public function create()
    {
        $futureSchedules = Auth::user()
        ->schedules()
        ->select('*')
        ->selectRaw("DATE_FORMAT(from_time,'%h:%i %p') as from_time")
        ->selectRaw("DATE_FORMAT(to_time,'%h:%i %p') as to_time")
        ->whereNotNull('schedule_at')
        ->workingHour()
        ->whereDate('schedule_at', '>=', today())
        ->orderBy('schedule_at')
        ->get();


    return view('dashboard.manager.availability.create', [
        'futureSchedules' => $futureSchedules,
    ]);
    }
    public function store(ManagerScheduleRequest $request)
    {
        foreach ($request->validated() as $schedule) {
            Auth::user()->schedules()->updateOrCreate(
                ['day' => $schedule['day']],
                $schedule
            );
        }

        return redirect()
            ->back()
            ->with('success', 'Schedule updated successfully');
    }
    public function scheduled(Request $request)
    {

       
        $schedules = $this->getFormattedData($request);

        Schedule::upsert($schedules, [
            'schedule_at',
            'scheduleable_id',
            'scheduleable_type',
        ]);

        return redirect()
            ->back()
            ->with('success', 'Schedule updated successfully');
    }

    private function getFormattedData(Request $request)
    {
        $data = $this->validateData($request);

        if ($request->filled('end_schedule_at')) {
            $schedules = [];

            $period = Carbon::parse($data['schedule_at'])
                ->daysUntil($data['end_schedule_at']);

            foreach ($period as $date) {
                $schedule = [
                    'scheduleable_id' => auth()->id(),
                    'scheduleable_type' => User::class,
                    'schedule_at'   => $date,
                    'is_open'       => $data['is_open'],
                ];

                if ($request->boolean('is_open')) {
                    $schedule['to_time'] = $data['is_open'];
                    $schedule['from_time'] = $data['from_time'];
                }

                $schedules[] = $schedule;
            }

            return $schedules;
        }

        unset($data['end_schedule_at']);

        $data['scheduleable_id'] = auth()->id();
        $data['scheduleable_type'] = User::class;

        return $data;
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'from_time' => [
                Rule::requiredIf($request->boolean('is_open')),
                'nullable',
                'date_format:H:i',
            ],
            'to_time' => [
                'nullable',
                Rule::requiredIf($request->boolean('is_open')),
                'date_format:H:i',
                function ($attribute, $value, $fail) use ($request) {
                    $fromTimeKey = str_replace('to_time', 'from_time', $attribute);

                    $toTime = strtotime($value);
                    $fromTime = strtotime($request->{$fromTimeKey});

                    if ($fromTime >= $toTime) {
                        $fail('Please insert bigger for to time');
                    }
                }
            ],
            'is_open'           => ['required', 'boolean'],
            'schedule_at'       => ['required', 'date', 'after_or_equal:today'],
            'end_schedule_at'   => ['nullable', 'date', 'after:schedule_at'],
        ]);
    }

    public function availabilityDestroy(Schedule $schedule)
    {
        $schedule->delete();
        
        return redirect()
            ->back()
            ->with('success', 'Schedule deleted successfully');
    }
}
