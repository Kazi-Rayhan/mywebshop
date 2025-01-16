<x-form.input type="text" name="method" label="{!! __('words.shipping_method') !!}"
    value="{{ $shipping->shipping_method ?? old('method') }}" />


<x-form.input type="text" name="cost" label="{!! __('words.shipping_cost') !!}"
    value="{{ $shipping->shipping_cost ?? old('cost') }}" />

<div class="form-group" id="locationsdiv">
    <label for="">Locations</label>
    <select name="locations[]" class="form-control" id="locations" multiple style="width:100% !important">
        @foreach (auth()->user()->shop->sellingLocations() as $country)
            @if ($shipping->locations)
                <option @if (in_array($country, $shipping->locations)) selected @endif>{{ $country }}</option>
            @else
                <option @if ($country == 'Norway') selected @endif>{{ $country }}</option>
            @endif
        @endforeach
    </select>
</div>
<button class="btn btn-primary"> <i class="fa fa-plus-square" aria-hidden="true"></i> {!! __('words.save_btn') !!}</button>
