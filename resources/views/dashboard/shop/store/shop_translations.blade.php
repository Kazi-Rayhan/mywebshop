<x-dashboard.shop>
    <h3>{!! __('words.store_lang_sec_title') !!}</h3>

    <div class="row row-cols-1 mt-3">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('shop.shop_translations_update') }}" method="post">
                    @csrf
                    @foreach ($languages as $language)
                        <div class="row">
                            @php
                                $shopLanguage = auth()
                                    ->user()
                                    ->getShop()
                                    ->mylanguages()
                                    ->find($language->id);
                            @endphp


                            <div class="col-md-3">
                                <div class="form-group">
                                    <label
                                        for="languages[{{ $language->id }}][english]">{{ __('words.default') }}
                                        ({{app()->getLocale()}})</label>
                                    <input type="text" class="form-control" readonly value="{{__('words.'.$language->key)}}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label
                                        for="languages[{{ $language->id }}][english]">{{ __('words.your_translation') }}
                                        (En)</label>
                                    <select name="languages[{{ $language->id }}][english]"
                                        id="languages[{{ $language->id }}][english]" data-lang="{{ $language->key }}"
                                        class="form-control">
                                        <option data-index="0" value="{{ $language->english }}">
                                            {{ $language->english }} ( {{ __('words.default') }} )</option>
                                        @foreach ($language->english_options_array as $option)
                                            <option data-index="{{ $loop->iteration }}"
                                                @if (@$shopLanguage?->pivot->english == $option) selected @endif
                                                value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>





                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="languages[{{ $language->id }}][norwegian]">
                                        {{ __('words.your_translation') }} (No)</label>
                                    <select name="languages[{{ $language->id }}][norwegian]"
                                        id="languages[{{ $language->id }}][norwegian]"
                                        data-lang="{{ $language->key }}" class="form-control">
                                        <option data-index="0" value="{{ $language->norwegian }}">
                                            {{ $language->norwegian }} ( {{ __('words.default') }} )</option>
                                        @foreach ($language->norwegian_options_array as $option)
                                            <option data-index="{{ $loop->iteration }}"
                                                @if (@$shopLanguage?->pivot->norwegian == $option) selected @endif
                                                value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>


                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="languages[{{ $language->id }}][spanish]">
                                        {{ __('words.your_translation') }} (Es)</label>
                                    <select name="languages[{{ $language->id }}][spanish]"
                                        id="languages[{{ $language->id }}][spanish]" data-lang="{{ $language->key }}"
                                        class="form-control">
                                        <option data-index="0" value="{{ $language->spanish }}">
                                            {{ $language->spanish }} ( {{ __('words.default') }} )</option>
                                        @foreach ($language->spanish_options_array as $option)
                                            <option data-index="{{ $loop->iteration }}"
                                                @if (@$shopLanguage?->pivot->spanish == $option) selected @endif
                                                value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>


                            </div>
                            @if ($language->help)
                                <button type="button" class="rounded-circle h-auto"
                                    style="position: absolute;width:auto;right:10px;t" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="{{ $language->help }}">
                                    <i class="fa fa-info" style="font-size:10px"></i>
                                </button>
                            @endif
                        </div>
                    @endforeach
                    <button class="btn btn-primary">{{ __('words.save') }}</button>
                </form>
            </div>


        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const selectElements = document.querySelectorAll('select[data-lang]');

                selectElements.forEach(select => {
                    select.addEventListener('change', function() {

                        const selectedOptionIndex = this.options[this.selectedIndex].getAttribute(
                            'data-index');

                        const dataLang = this.getAttribute('data-lang');

                        // Loop through all select elements with the same data-lang attribute
                        document.querySelectorAll(`select[data-lang="${dataLang}"]`).forEach(
                            otherSelect => {

                                otherSelect.options[selectedOptionIndex].selected = true;
                                console.log(otherSelect.options);
                            });
                    });
                });
            });
        </script>
    @endpush
</x-dashboard.shop>
