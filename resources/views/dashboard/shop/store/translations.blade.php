<x-dashboard.shop>
    <h3>{!! __('words.store_translations_sec_title') !!}</h3>

    <div class="row row-cols-1 mt-3">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('shop.languages.update') }}" method="post">
                    @csrf

                    <div class="form-group">
                        <h5>Default Language</h5>
                        <div class="row row-cols-lg-6 row-cols-md-4 row-cols-2">
                            @foreach (App\Constants\Constants::LANGUAGES['list'] as $language => $key)
                                <div class="form-check">
                                    <input class="form-check-input" name="default" type="radio"
                                        @if ($key == auth()->user()->shop->default_language) checked @endif value="{{ $key }}"
                                        id="default-{{ $language }}">
                                    <label class="form-check-label" for="default-{{ $language }}">
                                        {{ $language }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('words.set_language') }}</button>
                </form>

            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('shop.terms.update') }}" method="post">
                    @csrf
                    @foreach (App\Constants\Constants::LANGUAGES['list'] as $language)
                        <div class="col-md-12">
                            <x-form.input type="textarea" name="terms[{{ $language }}]"
                                label="{!! __('words.shop_terms') !!} ({{ $language }}) " :value="old(
                                    'terms',
                                    auth()
                                        ->user()
                                        ->shop->translate($language)->terms,
                                )" />
                        </div>
                    @endforeach
                    <button type="submit" class="btn btn-primary">{{ __('words.set_terms') }}</button>
                </form>

            </div>
        </div>
    </div>
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    @endpush
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

        <script>
            $(document).ready(function() {
                $('textarea').summernote({
                    height: 300
                });

            });
        </script>
    @endpush
</x-dashboard.shop>
