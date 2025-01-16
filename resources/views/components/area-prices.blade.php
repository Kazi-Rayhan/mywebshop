@php
    $inputs = ['price', 'saleprice', 'quantity', 'retailerprice'];
@endphp
<div>

    @foreach ($areas as $area)
        <label for="">
            {{ $area->name }}
        </label> <!-- checkbox -->
        <div style="margin-bottom:10px;display:flex;align-items:center;gap:10px">
            <div>
                <input class="form-check-input toggle-area mt-0" name="area[{{ $area->id }}]" type="checkbox"
                    data-class="{{ $area->key }}" value="{{ $area->id }}"
                    @if ($product->areas->contains($area)) checked @endif name="area"
                    aria-label="Checkbox for following text input">
            </div>
            @foreach ($inputs as $input)
                <div>
                    <label for="">{{ ucwords($input) }}</label>
                    <input type="number" name="area[{{ $area->id }}][{{ $input }}]"
                        class="form-control {{ $area->key }}" @if (!$product->areas->contains($area)) disabled @endif
                        required aria-label="Text input with checkbox" placeholder="{{ ucwords($input) }}"
                        value="{{ @$product->areas()->find($area)->pivot->$input }}">
                </div>
            @endforeach


        </div>
    @endforeach

</div>
