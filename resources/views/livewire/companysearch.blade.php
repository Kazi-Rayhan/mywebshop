<div class="row">
    <div class="col-md-3">


        <div class="form-group">
            <label for="company_country">{{ __('words.checkout_form_company_country') }}</label>
            <select wire:model="country" class="form-control" id="company_country_prefix" name="company_country_prefix">
                @foreach ($countries as $key => $value)
                    <option value="{{ $key }}" @if ($country == $key) selected @endif>
                        {{ __($value) }}</option>
                @endforeach
            </select>
            @error('company_country')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="company_name">{{ __('words.checkout_form_company_name') }}</label>

            <input wire:model="companyName" list="companies" value="{{ old('company_name') }}" type="text"
                class="form-control" id="company_name" name="company_name"
                placeholder="{{ __('words.checkout_form_company_name') }}" required>
            <span wire:loading>
                Loading...
            </span>

            <datalist id="companies">
                @if ($results)
                    @foreach ($results as $result)
                        <option value="{{ $result['name'] }}">{{ $result['id'] }} {{ $result['name'] }}</option>
                    @endforeach
                @endif
            </datalist>
            @error('company_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="company_number">{{ __('words.checkout_form_company_number') }} </label>

            <input list="companies2" wire:model="companyNumber" value="{{ old('company_number') }}" type="text"
                class="form-control" id="company_number" name="company_number"
                placeholder="{{ __('words.checkout_form_company_number') }}" required>
            <span wire:loading wire:target="companyNumber">
                Loading...
            </span>
            <datalist id="companies2">
                @if ($results)
                    @foreach ($results as $result)
                        <option value="{{ $result['id'] }}">{{ $result['id'] }} {{ $result['name'] }}</option>
                    @endforeach
                @endif
            </datalist>
            @error('company_number')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <x-form.input wire:model="address" type="text" name="address" label="{!! strip_tags(__('words.invoice_address')) !!}"
                :value="old('address', @auth()->user()->address)" />
        </div>
    </div>


    <div class="col-md-4">
        <x-form.input wire:model="city" type="text" name="city" label="{!! strip_tags(__('words.invoice_place')) !!}"
            :value="old('city', @auth()->user()->city)" />
    </div>

    <div class="col-md-4">
        <x-form.input wire:model="postcode" type="text" name="post_code" label="{!! strip_tags(__('words.invoice_postcode')) !!}"
            :value="old('post_code', @auth()->user()->post_code)" />
    </div>
</div>
