<div class="col-md-12">
    @foreach (App\Constants\Constants::LANGUAGES['list'] as $language)
    <x-form.input type="text" label="{{__('words.title')}} ({{ $language }})" name="title[{{ $language }}]" value="{{ old('title', $packageoption->title) }}" />
    @endforeach
</div>
<div class="col-12 col-md-4">
    <x-form.input type='number' min="0" name='minutes' :label="__('words.miniutes')" value="{{ old('minutes', $packageoption->minutes) }}" />
</div>

<div class="col-12 col-md-4">
    <x-form.input type='number' min="0" name='buffer' :label="__('words.buffer')" value="{{ old('buffer', $packageoption->buffer) }}" />
</div>
<div class="col-md-4 col-12">
    <div class="form-group">
        <label for="default_option">{{ __('words.set_as_default') }}</label>
        <select class="form-control" name="default_option" id="default_option">
            <option value="0">{{ __('words.no') }}</option>
            <option value="1" @if ($packageoption->default) selected @endif>{{ __('words.yes') }}</option>
        </select>
    </div>
</div>
@foreach (App\Constants\Constants::LANGUAGES['list'] as $language)
<div class="col-12">
    <x-form.input type='textarea' name='details[{{ $language }}]' label="{!!__('words.details')!!} ({{ $language }})" value="{{ old('details', $packageoption->getTranslatedAttribute('details',$language)) }}" />
</div>
@endforeach
<div class="col-md-3">
<button class=" btn btn-primary">
    + Save
</button>
</div>