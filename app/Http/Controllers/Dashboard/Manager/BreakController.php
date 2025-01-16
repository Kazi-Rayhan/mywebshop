<?php

namespace App\Http\Controllers\Dashboard\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Schedule;

class BreakController extends Controller
{
    public function index($day)
    {
        $schedules = Auth::user()
            ->schedules()
            ->where('parent_id', request()->parent_id)
            ->select('id')
            ->selectRaw("DATE_FORMAT(from_time,'%h:%i %p') as from_time")
            ->selectRaw("DATE_FORMAT(to_time,'%h:%i %p') as to_time")
            ->onlyBreaks()
            ->get();

        return [
            'parent_id' => request()->parent_id,
            'breaks' => $schedules,
        ];
    }

    public function storeUpdate(Request $request)
    {

        $data = $this->validateData($request);

        $data['is_break'] = true;

        Auth::user()->schedules()
            ->updateOrCreate(['id' => $request->schedule_id, 'parent_id' => $request->parent_id], $data);

        return $this->index($request->day);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        //
    }

    public function destroy(Schedule $schedule)
    {

        $parent = $schedule->parent_id;


        $schedule->delete();

        $schedules = Auth::user()
            ->schedules()
            ->where('parent_id', $parent)
            ->select('id')
            ->selectRaw("DATE_FORMAT(from_time,'%h:%i %p') as from_time")
            ->selectRaw("DATE_FORMAT(to_time,'%h:%i %p') as to_time")
            ->onlyBreaks()
            ->get();

        return [
            'parent_id' => $parent,
            'breaks' => $schedules,
        ];
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'from_time' => ['required', 'date_format:H:i'],
            'to_time' => [
                'required',
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
            'schedule_id' => ['nullable', 'exists:schedules,id'],

            'parent_id' => ['required']
        ]);
    }
}
