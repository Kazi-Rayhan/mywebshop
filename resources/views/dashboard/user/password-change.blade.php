<x-dashboard.user>
    <h3 class="">{{ __('words.dashboard_change_pass') }}</h3>
    <form method="POST" action="{{ route('user.password.change', request()->user_name) }}">
        @csrf
        <div class="col-md-12">
            <div class="form-group">
                <label for="current_password">{{ __('words.dashboard_current_password_label') }}</label>
                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                    id="current_password" placeholder="{{ __('words.dashboard_current_password_label') }}"
                    name="current_password">
                @error('current_password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="new_password">{{ __('words.dashboard_new_pass') }}</label>
                <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                    id="new_password" placeholder="{{ __('words.dashboard_new_pass') }}" name="new_password">
                @error('new_password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="new_confirm_password">{{ __('words.confirm_pass_label') }}</label>
                <input type="password" class="form-control @error('new_confirm_password') is-invalid @enderror"
                    id="new_confirm_password" placeholder="{{ __('words.confirm_pass_label') }}"
                    name="new_confirm_password">
                @error('new_confirm_password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <button class="btn btn-inline" type="submit">
                    {{ __('words.Update') }}</button>
            </div>
        </div>
    </form>
</x-dashboard.user>
