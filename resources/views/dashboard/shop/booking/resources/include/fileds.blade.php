<div class="row">
    <div class="col-12">
        <x-form.input type="text" name="name" label="{{ __('words.dashboard_category_index_name') }}" value="{{ old('name') ?? $resource->name }}" />
    </div>

    <div class="col-12 pt-2">
        <x-form.input type="text" name="available_seats" label="{{ __('words.resourse_seat_label') }}" value="{{ old('available_seats') ?? $resource->available_seats }}" />
    </div>
    <div class="col-12 pt-4">
        <label for="">{{ __('words.resource_time_label') }}</label>

    </div>

    <div class="col-12 mb-2 ml-2">
        <div class="form-check">
            <input class="form-check-input" name="always_open" type="checkbox" onclick="availableDays()" id="mycheck">
            <label class="form-check-label" for="mycheck">
                {{ __('words.resource_24_hours_label') }}
            </label>
        </div>
    </div>

    <div class="row" id="weeks">
        @foreach (config('app.days') as $key => $day)
            @php
                $schedule = $resource->getScheduleFor($day);
            @endphp

            <div class="col-4">
                <div class="form-check">
                    <input class="form-check-input ml-1" name="days[{{ $key }}][is_open]" type="checkbox" value="1" id="date-{{ $day }}" {{ $schedule->is_open ? 'checked' : '' }}>
                    <input name="days[{{ $key }}][day]" type="hidden" value="{{ $day }}">
                    <label class="form-check-label ml-5" for="date-{{ $day }}">{{ ucfirst($day) }}</label>
                </div>
                <div class="row mt-2 mt-2 ml-2">
                    <div class="">
                        <input type="time" name="days[{{ $key }}][from_time]" value="{{ $schedule->formatTime($schedule->from_time) }}" class="form-control">
                    </div>
                    <div class="m-2 check">
                        <span>To</span>
                    </div>

                    <div>
                        <input type="time" name="days[{{ $key }}][to_time]" value="{{ $schedule->formatTime($schedule->to_time) }}" class="form-control">
                    </div>
                </div>
            </div>
        @endforeach

    </div>

    <div class="col-12">
        <button class="btn btn-primary ml-3 mt-2"> <i class="fa fa-plus-square" aria-hidden="true"></i> {{ __('words.save_btn') }}</button>
    </div>
</div>
