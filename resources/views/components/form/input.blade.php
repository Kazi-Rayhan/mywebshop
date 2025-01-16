@props(['label', 'value' => old($name), 'name', 'type', 'placeholder' => '', 'options' => [], 'id' => '', 'checked' => false])

@php
    $classes = 'form-control';
    if (in_array($type, ['checkbox', 'radio'])) {
        $classes .= '-input';
    }
@endphp

<div class="mb-3">
    @if($label)
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    @endif
    @if ($type === 'textarea')
        <textarea class="{{ $classes }} @error($name) is-invalid @enderror" id="{{ $id }}"
            name="{{ $name }}" placeholder="{{ $placeholder }}" {{ $attributes }}>{!! $value !!}</textarea>
    @elseif ($type === 'select')
        <select class="{{ $classes }} @error($name) is-invalid @enderror"id="{{ $id }}"
            name="{{ $name }}" {{ $attributes }}>
                <option value="">{{ __('words.chose_an_option') }}</option>
        @foreach ($options as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}" @if ($value == $optionValue) selected @endif>
                    {{ $optionLabel }}</option>
            @endforeach
        </select>
    @else
        <input type="{{ $type }}" class="{{ $classes }} @error($name) is-invalid @enderror"
            id="{{ $id }}" name="{{ $name }}" value="{{ $value }}"
            placeholder="{{ $placeholder }}" {{ $attributes }} @if ($checked) checked @endif>
    @endif
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
