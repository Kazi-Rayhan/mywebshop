@props(['key', 'value'])
<div class="small-box bg-primary">
    <div class="inner ">

        @if (is_array($value))
            
        <h3>
                {{ implode(' / ', $value) }}
            </h3>
        @else
            <h3>
                {{ $value }}
            </h3>
        @endif
        <p>{{ __('words.' . $key) }}</p>
    </div>
    <div class="icon">
        <i style="font-size:40px" class="far fa-chart-bar"></i>
    </div>
</div>
