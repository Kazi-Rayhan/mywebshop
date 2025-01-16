<x-dashboard.shop>
    <div class="row mt-5">
        <div class="col-lg-12">
            <div class="card">

                <div class="card-body shadow-lg">
                    <form action="{{ route('shop.managers.schedule.update', $user) }}" method="POST">
                        @csrf
                        <div class="col-12 pt-4">
                            <label for="">{{ __('words.resource_time_label') }}</label>

                        </div>
                        <div class="row" id="weeks">
                            @foreach (config('app.days') as $key => $day)
                                @php
                                    $schedule = $user->getScheduleFor($day);
                                @endphp

                                <div class="col-4">
                                    <div class="form-check">
                                        <input class="form-check-input ml-1" name="days[{{ $key }}][is_open]"
                                            type="checkbox" value="1" id="date-{{ $day }}"
                                            {{ $schedule->is_open ? 'checked' : '' }}>
                                        <input name="days[{{ $key }}][day]" type="hidden"
                                            value="{{ $day }}">
                                        <label class="form-check-label ml-5"
                                            for="date-{{ $day }}">{{ ucfirst($day) }}</label>
                                    </div>
                                    <div class="row mt-2 mt-2 ml-2">
                                        <div class="">
                                            <input type="time" name="days[{{ $key }}][from_time]"
                                                value="{{ $schedule->formatTime($schedule->from_time) }}"
                                                class="form-control">
                                        </div>
                                        <div class="m-2 check">
                                            <span>To</span>
                                        </div>

                                        <div>
                                            <input type="time" name="days[{{ $key }}][to_time]"
                                                value="{{ $schedule->formatTime($schedule->to_time) }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button class="btn btn-primary mt-3 ml-2"> <i class="fa fa-plus-square" aria-hidden="true"></i>
                            {{ __('words.save_btn') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.shop>
