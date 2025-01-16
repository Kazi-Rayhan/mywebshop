<x-dashboard.external>
    <div class="card">
        <div class="card-header">
           <h4>
            {{ __('words.profile_sec_title') }}
           </h4>
        </div>
        <div class="card-body">
            <form action="{{route('external.settings.update')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <x-form.input type='text' name='name' label="{{ __('words.name') }}"
                            value='{{auth()->user()->name}}' />
                    </div>
                    <div class="col-md-6">
                        <x-form.input type='text' name='last_name' label="{{ __('words.last_name') }}"
                            value='{{auth()->user()->last_name}}' />
                    </div>
                    {{-- <div class="col-md-6">
                        <x-form.input type='text' name='email' label="{{ __('words.email') }}"
                            value='{{auth()->user()->email}}' />
                    </div> --}}
                    
                </div>
                <button class="btn btn-primary"> <i class="fa fa-save"></i> Update</button>
            </form>
        </div>
    </div>
    <div class="card mt-5">
        <div class="card-header">
           <h4>
            {{ __('words.password_change_sec_title') }}
           </h4>
        </div>
        <div class="card-body">
            <form action="{{route('external.password.update')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <x-form.input type='password' name='old_pass' label="{{ __('words.old_password') }}"
                            value='' />
                            @error('old_pass')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <x-form.input type='password' name='new_pass' label="{{ __('words.new_password') }}"
                            value='' />
                    </div>
                 
                    
                </div>
                <button class="btn btn-primary"> <i class="fa fa-save"></i> "{{ __('words.contract_order_btn') }}"</button>
            </form>
        </div>
    </div>
</x-dashboard.external>