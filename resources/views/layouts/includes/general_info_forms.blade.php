<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="">{{ __('words.selling_locations') }}</label>
            <select name="selling_location_mode" id="" class="form-control">
                <option @if (auth()->user()->shop->selling_location_mode == 0) selected @endif value="0">{{ __('words.all_countries') }}
                </option>
                <option @if (auth()->user()->shop->selling_location_mode == 1) selected @endif value="1">
                    {{ __('words.sell_to_specefic_countries') }}</option>
                <option @if (auth()->user()->shop->selling_location_mode == 2) selected @endif value="2">
                    {{ __('words.sell_to_all_countries_except_these') }}</option>
            </select>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group" id="locationsdiv">
            <label for="">{{ __('words.locations') }}</label>
            <select name="locations[]" class="form-control" id="locations" multiple style="width:100% !important">
                @php
                    $locations = is_array(auth()->user()->shop->locations) ? auth()->user()->shop->locations : [];
                @endphp
                @foreach (App\Constants\Constants::COUNTRIES as $country)
                    <option @if (in_array($country, $locations)) selected @endif>{{ $country }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
