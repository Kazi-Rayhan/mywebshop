<x-dashboard.manager>
  <div x-data="managerAvailability">
    <h3>
      <span class="text-primary opacity-25">
        <i class="fas fa-list" aria-hidden="true"></i>
      </span>
      {{ __('words.add_availability') }}
    </h3>

    <div class="row">

      <div class="col-lg-12">
        <div class="card">

          <div class="card-body shadow-lg">
            <form action="{{ route('manager.availability.store') }}" method="POST">
              @csrf
              <div class="col-12 pt-4">
                <h6 class="text-muted">{{ __('words.resource_time_label') }}</h6>
              </div>
              <div class="row" id="weeks">
                @foreach (config('app.days') as $key => $day)
                  @php
                    $schedule = auth()
                        ->user()
                        ->getScheduleFor($day);
                  @endphp

                  <div class="col-4">
                    <div class="form-check">
                      <input class="form-check-input ml-1" name="days[{{ $key }}][is_open]" type="checkbox" value="1" id="date-{{ $day }}" {{ $schedule->is_open ? 'checked' : '' }}>
                      <input name="days[{{ $key }}][day]" type="hidden" value="{{ $day }}">
                      <label class="form-check-label ml-5" for="date-{{ $day }}">{{ ucfirst($day) }}</label>
                      <template x-if="{{ $schedule->id }}">
                        <a href="#" @click.prevent='open("{{ $day }}", `{{ route('manager.availability.break.index', [$day, 'parent_id' => $schedule->id]) }}`)' class="btn btn-info btn-sm">
                          {{ __('words.break') }}
                        </a>
                      </template>
                    </div>
                    <div class="row mt-2 mt-2 ml-2">
                      <div class="">
                        <input type="time" name="days[{{ $key }}][from_time]" value="{{ $schedule->formatTime($schedule->from_time) }}" class="form-control">
                      </div>
                      <div class="m-2 check">
                        <span>{{ __('words.to') }}</span>
                      </div>

                      <div>
                        <input type="time" name="days[{{ $key }}][to_time]" value="{{ $schedule->formatTime($schedule->to_time) }}" class="form-control">
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

    <div class="row mt-5">
      <div class="col-lg-12">
        <div class="card">

          <div class="card-body shadow-lg">
            <div class=" pt-4">
              <h6 class="text-muted"> {{ __('words.add_special_availability') }}</h6>
            </div>
            <div id="schedule-form">
              <h3 id="selected-date"></h3>
              <form action="{{ route('manager.availability.scheduled') }}" method="POST">
                @csrf
                <div class="row mt-3 d-print-none">
                  <div class="form-group col-md-4">
                    <label class="form-check-label" for="set-from-time">
                      {{ __('words.date') }}</label>
                    <input type="date" name="schedule_at" x-model="formSpecial.schedule_at" id="set-from-time" class="form-control">
                  </div>

                  <div class="form-group col-md-4">

                    <label class="form-check-label" for="set-end-time">
                      {{ __('words.end_date') }}
                      <span class="text-info">( {{ __('words.optional') }})</span>
                    </label>
                    <input type="date" name="end_schedule_at" x-model="formSpecial.end_schedule_at" id="set-end-time" class="form-control">
                  </div>
                  <div class="form-group col-md-4">
                    <label class="form-check-label" for="is-available">
                      {{ __('words.will_you_be_avialble') }}</label>
                    <select class="form-control" x-model.number="formSpecial.is_open" name="is_open" id="is-available">
                      <option value="1"> {{ __('words.yes') }}</option>
                      <option value="0"> {{ __('words.no') }}</option>
                    </select>
                  </div>
                  <template x-if="formSpecial.is_open === 1">
                    <div class="col-md-12">
                      <div class="row">
                        <div class="form-group col-md-6">
                          <label class="form-check-label" for="set-from-time">
                            {{ __('words.start_at') }}</label>
                          <input type="time" name="from_time" x-model="formSpecial.from_time" id="set-from-time" value="00:00" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                          <label class="form-check-label" for="set-to-time">
                            {{ __('words.end_at') }}</label>
                          <input type="time" name="to_time" x-model="formSpecial.to_time" id="set-to-time" value="23:59" class="form-control">
                        </div>
                      </div>
                    </div>
                  </template>
                </div>
                <button class="btn btn-primary mt-3 ml-2"> <i class="fa fa-plus-square" aria-hidden="true"></i>
                  {{ __('words.save_btn') }}</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-lg-12">
        <div class="card">

          <div class="card-body shadow-lg">
            <div class=" pt-4">
              <h6 class="text-muted">{{ __('words.list_special_availability') }}</h6>
            </div>
            <table class="table">
              <tr>
                <th>{{ __('words.date') }}</th>
                <th>{{ __('words.start_at') }}</th>
                <th>{{ __('words.end_at') }}</th>
                <th>{{ __('words.list_special_availability') }}</th>
                <th>{{ __('words.action') }}</th>
              </tr>
              @foreach ($futureSchedules as $futureSchedule)
                <tr>
                  <td>{{ $futureSchedule->schedule_at->format('d M Y') }}</td>
                  <td>{{ $futureSchedule->from_time }}</td>
                  <td>{{ $futureSchedule->to_time }}</td>
                  <td>{{ $futureSchedule->is_open ? 'Yes' : 'No' }}</td>
                  <td>
                    <template x-if="{{ $futureSchedule->id }}">
                      <a href="#" class="btn btn-info" @click.prevent="open("{{ $futureSchedule->schedule_at->format('l') }}", `{{ route('manager.availability.break.index', [$futureSchedule->schedule_at->format('l'), 'parent_id' => $futureSchedule->id]) }}`)">
                        {{ __('words.break') }}
                      </a>
                    </template>
                    <form action="{{ route('manager.availability.delete', $futureSchedule) }}" id="confirm-form" method="post" class="d-inline">
                      @csrf
                      <button class="btn btn-danger" type="submit">{{ __('words.delete') }}</button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </table>
          </div>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="card mt-2">
          <div class="card-body">
            <div id="calendar">


            </div>

          </div>
        </div>

      </div>
    </div>

    <template x-teleport="body">
      <div class="modal fade" tabindex="-1" role="dialog" id="manager-break">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              {{-- <h5 class="modal-title">Monday Break Time</h5> --}}
              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <template x-if="onEditMode">
                <h6 class="text-danger">{{ __('words.edit_mode') }}</h6>
              </template>
          
                <div class="">
                  <input type="time" x-model="form.from_time" class="form-control" required>
                </div>
                <div class="m-2 check">
                  <span>{{ __('words.to') }}</span>
                </div>

                <div>
                  <input type="time" x-model="form.to_time" class="form-control" required>
                </div>
                <button class="btn btn-primary mt-2  btn-sm" x-text="onEditMode ? 'Update' : 'Save'" @click.prevent="save(`{{ route('manager.availability.break.storeUpdate') }}`)">
                  {{ __('words.save') }}
                </button>
              </div>
        
            <div class="modal-footer">
              <table class="table table-bordered ">
                <tr>
                  <th>{{ __('words.from_time') }}</th>
                  <th>{{ __('words.to_time') }}</th>
                  <th>{{ __('words.action') }}</th>
                </tr>
                <template x-for="brk in breaks" :key="brk.id">
                  <tr>
                    <td x-text="brk.from_time"></td>
                    <td x-text="brk.to_time"></td>
                    <td>
                      <a href="#" @click.prevent="edit(brk)" class="btn btn-info">{{ __('words.edit') }}</a>
                      <a href="#" @click.prevent="destroy(brk.id, `{{ route('manager.availability.break.delete', 'schedule-id') }}`)" class="btn btn-danger">{{ __('words.delete') }}</a>
                    </td> 
                  </tr>
                </template>
              </table>
            </div>
          </div>
        </div>
      </div>
    </template>
  </div>


  @push('styles')
    <link href="{{ asset('fullcal/fullcalendar.min.css') }}" rel='stylesheet' />
    <link href="{{ asset('fullcal/fullcalendar.print.min.css') }}" rel='stylesheet' media='print' />
    <style>
      .fc-content {
        color: #fff
      }
    </style>
  @endpush

  @push('scripts')
    <script src="{{ asset('fullcal/lib/moment.min.js') }}"></script>
    <script src="{{ asset('fullcal/fullcalendar.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      document.getElementById('confirm-form').addEventListener('submit', (e) => {
        e.preventDefault();
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes'
        }).then(({
          isConfirmed
        }) => {
          if (isConfirmed) {
            e.target.submit();
          }
        })
      })
    </script>
    <script>
      $('#calendar').fullCalendar({
        header: {
          left: 'prev,next today',
          center: 'title',
          right: 'month'
        },
        defaultDate: Date.now(),
        navLinks: false, // can click day/week names to navigate views
        editable: false,
        eventLimit: true, // allow "more" link when too many events
        events: [],
        dayClick: function(date) {
          $.ajax({
            url: `${location.origin}/manager-dashboard/availability/${date.format()}/edit`,
            dataType: 'json'
          }).done(function(res) {
            if (res.schedule) {
              const toTime = moment(res.schedule.to_time, [moment.ISO_8601, 'HH:mm']).format(
                'HH:mm');
              const fromTime = moment(res.schedule.from_time, [moment.ISO_8601, 'HH:mm'])
                .format('HH:mm');

              $('#set-to-time').val(toTime);
              $('#set-from-time').val(fromTime);
            }

            if (!res.schedule) {
              $('#set-to-time').val(null);
              $('#set-from-time').val(null);
            }


          }).always((data) => {
            $('#selected-date').text(date.format('dddd Do MMMM YYYY'));
            $('#input-schedule-at').val(date.format());

            $('#schedule-form').removeClass('d-none');
          });
        }
      });
    </script>
  @endpush

</x-dashboard.manager>