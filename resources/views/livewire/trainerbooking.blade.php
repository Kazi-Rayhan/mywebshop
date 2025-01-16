<main>

    <form action="{{ route('manager.booking.services.post', $user) }}" id="trainer-form" method="post">

        @csrf
        <div class="container font mb-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    @if (!$trainer)
                        <div class="d-flex mt-5 align-items-center">

                            <input wire:model="subscription" type="checkbox" id="switch" /><label id="switch-label"
                                for="switch">Toggle</label>
                            <h3 class="ml-3">{{ __('words.subscriptions') }}</h3>
                        </div>
                    @endif
                    <!-- pt lavel section -->
                    <div class="mt-5">

                        <h3 class="mt-5">{{ __('words.pt_level') }}</h3>
                        <p>{{ __('words.pt_level_instruction') }}</p>
                        <div class="card border notify-card shadow-sm p-2 mt-3">
                            <div id="accordion">
                                @if ($trainer)
                                    <div class="card mt-2" x-data="{ open: false }">
                                        <div
                                            class="card-header bg-transparent  d-flex justify-content-between align-items-center">
                                            <div class="form-check">

                                                <input wire:model="pt_input" name="trainer" class="form-check-input"
                                                    type="radio" value="{{ $trainer->id }}"
                                                    id="trainer{{ $trainer->id }}" name="trainer">
                                                <label class="form-check-label h5 ml-4"
                                                    for="trainer{{ $trainer->id }}">
                                                    {{ $trainer->fullName }} <br>
                                                    <!-- <small>
                                                        @if ($trainer->level)
{{ $trainer->level()->title }} ,
@endif
                                                        {{ $trainer->sub_title }}
                                                    </small> -->
                                                </label>
                                            </div>
                                            <div>
                                                <img class="rounded-circle mr-4"
                                                    src="{{ Iziibuy::image($trainer->avatar) }}"
                                                    style="width:40px;height:40px" alt="User Image">
                                                <i class="fa fa-arrow-down  toggle " data-toggle="collapse1"
                                                    data-active='false' onClick="toggle(this)"></i>
                                            </div>

                                        </div>

                                        <div class="collapse " id="collapse1">
                                            <div class="card-body">
                                                {{ $trainer->details }}
                                            </div>
                                        </div>

                                    </div>
                                @else
                                    @foreach ($trainers as $user)
                                        <div class="card mt-2" x-data="{ open: false }">
                                            <div
                                                class="card-header bg-transparent  d-flex justify-content-between align-items-center">
                                                <div class="form-check">

                                                    <input wire:model="pt_input" name="trainer" class="form-check-input"
                                                        type="radio" value="{{ $user->id }}"
                                                        id="trainer{{ $user->id }}" name="trainer">
                                                    <label class="form-check-label h5 ml-4"
                                                        for="trainer{{ $user->id }}">
                                                        {{ $user->fullName }}
                                                        <!-- <small>
                                                            @if ($user->level)
{{ $user->level()->title }} ,
@endif
                                                            {{ $user->sub_title }}
                                                        </small> -->
                                                    </label>

                                                </div>
                                                <div>
                                                    <img class="rounded-circle mr-4" style="width: 40px;height:40px"
                                                        src="{{ Iziibuy::image($user->avatar) }}" height="40"
                                                        alt="User Image">
                                                    <i class="fa fa-arrow-down  toggle "
                                                        data-toggle="collapse{{ $loop->iteration }}"
                                                        data-active='false' onClick="toggle(this)"></i>
                                                </div>
                                            </div>

                                            <div class="collapse " id="collapse{{ $loop->iteration }}">
                                                <div class="card-body">
                                                    {{ $user->details }}
                                                </div>
                                            </div>

                                        </div>
                                    @endforeach
                                @endif

                            </div>

                        </div>
                    </div>
                    <!-- pt label section end -->
                    <p style="font-size: 20px;" class="mt-5">{{ __('words.session_packages_header') }}</p>
                    <!-- session section start -->
                    @foreach ($packages as $package)
                        <div class="card mt-4 py-4 border notify-card shadow-sm">
                            <div class="card-header border-0 mx-3 bg-white" style="font-size: 20px;">
                                <input wire:model="sessionI" class="form-check-input" value="{{ $package->id }}"
                                    type="radio" name="package" id="package-{{ $package->id }}">
                                <label for="package-{{ $package->id }}" class="ms-3 d-flex justify-content-between">

                                    <h3 class="font">{{ $package->title }}
                                        <small class="h6">
                                            {{ $package->type == 'subscription' ? '- (Subscription)' : '' }}</small>
                                    </h3>
                                    <div>
                                        <h3 class="font text-danger d-inline">

                                            {{ Iziibuy::price($package->getPrice($pt_input) / $package->sessions, $shop) }}
                                        </h3>
                                        <span class="mt-5">{{ __('words.per_session') }}</span>
                                    </div>

                                </label>
                            </div>

                            <div class="card-body ml-5 p-0">
                                <p>{{ $package->details }} </p>
                            </div>
                        </div>
                    @endforeach

                </div>

                <div class="col-md-3 ">
                    <div class="card mt-4 border notify-card shadow-sm">

                        <div class="card-body ml-4">
                            <h3 class="notify-title">{{ __('words.summery') }}</h3>
                            <p>{{ __('words.your_pt_package') }}</p>
                            @if ($session)
                                <div>
                                    <p class="p-0 mb-1"><i class="fas fa-check text-success"></i> {{ $session->title }}
                                    </p>
                                </div>
                            @endif

                        </div>
                        <div class="card-footer border-0 text-muted" style=" font-weight:500">
                            <p class="text-end" style="font-size: 16px;">{{ __('words.your_price') }}</p>
                            <div class="text-end">
                                <h3 id="labelShowVal" class="font text-danger d-inline font-italic"
                                    style=" font-weight:800">
                                    {{ Iziibuy::price($this->total_price, $shop) }}
                                </h3>

                            </div>

                            <div class="text-end mt-2">
                                <h4 class="font text-dark d-inline" id="sessionShowVal">
                                    {{ Iziibuy::price($this->price, $shop) }}
                                </h4>
                                <span class="mt-5 text-muted">{{ __('words.per_session') }}</span>
                            </div>

                            <input type="hidden" name="sub_price" value="{{ $this->sub_price }}">
                            <input type="hidden" name="total_price" value="{{ $this->total_price }}">
                            <input type="hidden" name="tax" value="{{ $this->tax }}">

                            <div class="form-check">
                                <input class="form-check-input" name="renew" type="checkbox" value="1"
                                    id="" checked>
                                <label class="form-check-label" for="">
                                    {{ __('words.renew') }}
                                </label>
                            </div>
                            @php
                                $split = App\Models\Package::find($sessionI);
                                
                            @endphp
                            @if ($split && $split->split)
                                <div class="form-check">
                                    <input class="form-check-input" wire:model="split" name="split"
                                        type="checkbox" id="" checked>

                                    <label class="form-check-label" for="">
                                        {{ __('words.split_amount') }} {{ $split->split }} {{ __('words.times') }}
                                    </label>
                                </div>
                            @endif
                            @if (!Auth()->check())
                                <button type="button" class="btn btn-success w-100 mt-3" data-toggle="modal"
                                    data-target="#exampleModalCenter">
                                    {{ __('words.next') }}
                                </button>
                            @else
                            <span class="spinner-border mt-3 mx-auto" role="status" wire:loading>

                            </span>
                            <button wire:loading.remove type="submit"
                            class="btn btn-success w-100 mt-3">{{ __('words.next') }}</button>
                            @endif
                            <p class="mt-3" style="font-size: 14px;"> {{ __('words.note') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content container py-3">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button onclick="disableRegister()" class="nav-link active" id="ex1-tab-1"
                                data-toggle="tab" data-target="#login" type="button" role="tab"
                                aria-controls="login" aria-selected="true">{{ __('words.login') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button onclick="disableLogin()" class="nav-link" id="ex1-tab-2" data-toggle="tab"
                                data-target="#register" type="button" role="tab" aria-controls="register"
                                aria-selected="true">{{ __('words.register') }}</button>
                        </li>

                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="home-tab">
                            <div class="card-header mb-3">{{ __('words.reg_sec_title') }}</div>
                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label for="name">{{ __('words.checkout_form_first_name_label') }}</label>
                                    <input id="name" class="form-control @error('name') is-invalid @enderror"
                                        name="user[register][name]" disabled type="text" autocomplete="on"
                                        value="{{ old('name', request()->first_name) }}">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="last_name">{{ __('words.checkout_form_lastname') }}</label>
                                    <input id="last_name"
                                        class="form-control @error('last_name') is-invalid @enderror"
                                        name="user[register][last_name]" disabled type="text"
                                        value="{{ old('last_name', request()->last_name) }}">
                                    @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="email">{{ __('words.checkout_form_email') }}</label>
                                    <input id="emailField" class="form-control @error('email') is-invalid @enderror"
                                        name="user[register][email]" disabled type="text"
                                        value="{{ old('email', request()->email) }}">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="phone">{{ __('words.invoice_tel') }}</label>
                                    <input id="phone" class="form-control @error('phone') is-invalid @enderror"
                                        name="user[register][phone]" disabled type="text"
                                        value="{{ old('phone') }}">
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="password">{{ __('words.password') }}</label>
                                    <input id="password" class="form-control @error('password') is-invalid @enderror"
                                        name="user[register][password]" disabled type="password" />
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>





                            </div>
                            <button class="btn btn-primary btn-block" type="submit">{{ __('words.next') }}</button>


                        </div>
                        <div class="tab-pane fade  show active" id="login" role="tabpanel"
                            aria-labelledby="profile-tab">
                            <div class="card-header">{{ __('words.login_sec_title') }}</div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="form-group">
                                        <input placeholder="{{ __('words.checkout_form_email') }}" id="email"
                                            type="text" class="form-control @error('email') is-invalid @enderror"
                                            name="user[login][email]" value="{{ old('email') }}"
                                            autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <input placeholder="{{ __('words.password') }}" id="password"
                                            type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            name="user[login][password]" autocomplete="current-password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <div class="text-right text-small mt-2">
                                            <a
                                                href="{{ route('password.request') }}">{{ __('words.forgot_password_label') }}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="custom-control custom-checkbox text-small">
                                        <input type="checkbox" class="custom-control-input" id="sign-in-remember">
                                        <label class="custom-control-label"
                                            for="sign-in-remember">{{ __('words.login_remember_me_label') }}</label>
                                    </div>

                                    <button class="btn btn-primary btn-block"
                                        type="submit">{{ __('words.login_btn') }}</button>

                                </div>
                            </div>
                        </div>




                    </div>




                </div>
            </div>
        </div>
        <!-- Modal End -->

    </form>
</main>
