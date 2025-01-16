<x-dashboard.user>
    <form method="POST" action="{{ route('user.update', request()->user_name) }}">
        @csrf
        <div class="row">
            <div class="col-md-12 mb-2">
                <h3>Profile update</h3>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">{{ __('words.checkout_form_first_name_label') }}</label>
                    <input value="{{ Auth::user()->name }}" type="text"
                        class="form-control @error('name') is-invalid @enderror" id="name"
                        placeholder="{{ __('words.checkout_form_first_name_label') }}" name="name">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="last_name">{{ __('words.checkout_form_lastname') }}</label>
                    <input value="{{ Auth::user()->last_name }}" type="text"
                        class="form-control @error('last_name') is-invalid @enderror" id="last_name"
                        placeholder="{{ __('words.checkout_form_lastname') }}" name="last_name">
                    @error('last_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="email">{{ __('words.checkout_form_email') }}</label>
                    <input value="{{ Auth::user()->email }}" type="text" class="form-control" id="email"
                        placeholder="{{ __('words.checkout_form_email') }}" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="phone">{{ __('words.checkout_form_phone') }}</label>
                    <input value="{{ Auth::user()->phone }}" type="tel" class="form-control" id="phone"
                        name="phone" placeholder="{{ __('words.checkout_form_phone') }}">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="address">{{ __('words.invoice_address') }}</label>
                    <input value="{{ old('address', Auth::user()->address) }}" type="text"
                        class="form-control @error('address') is-invalid @enderror" id="address"
                        placeholder="{{ __('words.invoice_address') }}" name="address">
                    @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <label for="country">{{ __('words.invoice_country') }}</label>
                    <select name="country" id="country" class="form-control">
                        @foreach (App\Constants\Constants::COUNTRIES as $country)
                            <option @if ($country == auth()->user()->country) selected @endif>
                                {{ $country }}</option>
                        @endforeach
                    </select>
                    @error('country')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="city">{{ __('words.invoice_state') }}</label>
                    <input value="{{ old('state', Auth::user()->state) }}" type="text"
                        class="form-control @error('state') is-invalid @enderror" id="state"
                        placeholder="{{ __('words.invoice_state') }}" name="state">
                    @error('state')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="city">{{ __('words.invoice_place') }}</label>
                    <input value="{{ old('city', Auth::user()->city) }}" type="text"
                        class="form-control @error('city') is-invalid @enderror" id="city" placeholder="Sted"
                        name="city">
                    @error('city')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="post_code">{{ __('words.invoice_postcode') }}</label>
                    <input value="{{ old('post_code', Auth::user()->post_code) }}" type="number" step="1"
                        class="form-control @error('post_code') is-invalid @enderror" id="post_code"
                        placeholder="Postnummer" name="post_code">
                    @error('post_code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <button class="btn btn-inline" type="submit">
                        {{ __('words.Update ') }}</button>
                </div>
            </div>
    </form>
    </div>
</x-dashboard.user>
