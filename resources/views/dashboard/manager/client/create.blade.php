<x-dashboard.manager>
    <h3><span class="text-primary opacity-25 mr-2"><i class="fas fa-users" aria-hidden="true"></i></span>{{ __('words.clients') }}</h3>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body ">
                    <form action="{{ route('manager.client.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="card">
                            <div class="card-body">
                                <h5>
                                    {{ __('words.session') }}
                                </h5>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="session" id="session">
                                    <label class="form-check-label" for="session">Free Session</label>
                                </div>
                            </div>
                        </div>
                        @include('dashboard.manager.client.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.manager>