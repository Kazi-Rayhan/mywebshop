@php
    $inputs = ['price', 'saleprice'];
@endphp
<div>

    @foreach ($areas as $area)
        <label for="">
            {{ $area->name }}
        </label> <!-- checkbox -->

        <div style="margin-bottom:10px;display:flex;align-items:center;gap:10px">
            <div>
                <input class="form-check-input toggle-area mt-0" name="area[{{ $area->key }}]" type="checkbox"
                    data-class="{{ $area->key }}" value="{{ $area->key }}" 
                    aria-label="Checkbox for following text input" @if (isset($product->areas[$area->key])) checked @endif >
            </div>
            @foreach ($inputs as $input)
            
                <div>
                    <label for="">{{ ucwords($input) }}</label>
                    <input type="number" name="area[{{ $area->key }}][{{ $input }}]"
                        class="form-control {{ $area->key }}" @if (!isset($product->areas[$area->key])) disabled @endif
                        required aria-label="Text input with checkbox" placeholder="{{ ucwords($input) }}"
                        value="{{ @$product->areas[$area->key]->$input }}">
                </div>
            @endforeach


        </div>
    @endforeach

</div>
