<x-shop-front-end>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body ">
                <h2 class="ml-2 mt-4 mb-2">{{ $service->name }}</h2>
                <p class="ml-2 mt-4">
                    {!! $service->details !!}
                </p>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-body ">
                <h5 class="ml-2 mt-2">{{ __('words.dashboard_managers') }} :</h5>
                <div class="list-group mt-3">
                    @foreach ($service->managers as $manager)
                        <div class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <img class="rounded-circle" src="{{ Voyager::image($manager->avatar) }}"
                                        alt="" height="60px" width="60px">
                                    <span class="ml-3"><a class="text-dark"
                                            href="">{{ $manager->full_name }}</a></span>
                                </div>
                                <div>
                                    <a href="{{ route('timeSlot', [request('user_name'), $service->slug, $manager]) }}"
                                        class="btn btn-inline">{{ __('words.shop_nav_booking') }}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-shop-front-end>
