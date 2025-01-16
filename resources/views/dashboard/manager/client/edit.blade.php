<x-dashboard.manager>
<h3><span class="text-primary opacity-25 mr-2"><i class="fas fa-users"
                aria-hidden="true"></i></span>{{ __('words.clients') }}</h3>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body ">
                    <form action="{{ route('manager.booking.client.update',$user) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        @include('dashboard.manager.client.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.manager>