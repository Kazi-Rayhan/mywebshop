<x-shop-front-end>
    @push('style')
        <style>
            .avatar {
                height: 150px;
                object-fit: cover;
            }

            .list-group-item a {
                width: 100%;
                height: 100%;
                text-decoration: none;
                padding: 10px;
                color: var(--brandcolor) !important;
                transition: .2s ease-in;

                border-bottom: 2px solid var(--brandcolor);
                border-left: 2px solid var(--brandcolor);

            }

            .list-group-item {
                padding: 0px;
                margin-bottom: 5px;
                border: none;



            }

            .list-group-item a:hover {

                background: var(--brandcolor);
                color: #fff !important;

                padding-left: 30px;

            }

            .content {
                border-radius: 10px;
                border-left: 2px solid var(--brandcolor);
                border-bottom: 2px solid var(--brandcolor);
            }

            .content h3 {
                margin: 20px 0px;
                color: var(--brandcolor);
                padding-bottom: 30px;
                border-bottom: var(--brandcolor) 2px solid;
            }
        </style>
    @endpush
    <div class="container-fluid">

        @php
            $shop = App\Models\Shop::where('user_name', request()->user_name)->first();
        @endphp
        <div class="row my-4">
            <div class="col-md-3">
                <div class="border-rounded  text-center">
                    <img src="{{ Iziibuy::image(auth()->user()->avatar) }}" class=" avatar" alt="">
                    <h3 class="mt-2">{{ auth()->user()->fullName }}</h3>
                    <h6 class="mt-2">{{ auth()->user()->email }}</h6>
                </div>
                <ul class="list-group mt-4">
                    <li class="list-group-item">
                        <a href="{{ route('user.dashboard', request()->user_name) }}"> <i class="fa fa-home mr-2"></i>
                            {{ __('words.dashboard') }}</a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('user.profile', request()->user_name) }}"> <i class="fa fa-user mr-2"></i>
                            {!! __('words.profile_sec_title') !!}</a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('user.password.change', request()->user_name) }}"> <i
                                class="fa fa-key mr-2"></i> {{ __('words.dashboard_change_pass') }}</a>
                    </li>

                    <li class="list-group-item">
                        <a href="{{ route('user.booking', request()->user_name) }}"> <i class="fa fa-calendar mr-2"></i>
                            {{ __('words.booking') }}</a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('user.memberships', request()->user_name) }}"> <i
                                class="fa fa-boxes mr-2"></i>
                            {{ __('words.memberships') }}</a>
                    </li>

                    <li class="list-group-item">
                        <a href="{{ route('user.orders', request()->user_name) }}"><i
                                class="fa fa-file-invoice mr-2"></i> {{ __('words.dashboard_order_title') }}</a>
                    </li>
                    @HasTrainer($shop)
                        <li class="list-group-item">
                            <a href="{{ route('user.pt_trainer', request()->user_name) }}"><i class="fa fa-users mr-2"></i>
                                {{ __('words.personal_trainer_header') }}</a>
                        </li>
                    @endHasTrainer

                
                </ul>
            </div>
            <div class="col-md-8 content shadow p-md-5">

                {{ $slot }}
            </div>


        </div>
    </div>

</x-shop-front-end>
