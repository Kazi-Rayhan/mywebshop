<h3>
    {{ __('words.settings_menu_header') }}
</h3>
<div class="row">

    @foreach ($user->shop->menus ?? [] as $key => $value)
        <div class="col-md-6">
            <div class="mb-3">
                <label for="" class="form-label">{{ __('words.std_' . $key) }}</label>
                <select class="form-control " name="meta[menu][{{ $key }}]" id="">

                    <option value="1" @if ($value == 1) selected @endif>{{ __('words.true') }}
                    </option>
                    <option value="0" @if ($value == 0) selected @endif>{{ __('words.false') }}
                    </option>

                </select>
            </div>
        </div>
    @endforeach
    <div class="col-md-6">
        <div class="mb-3">
            <label for="" class="form-label">{{ __('words.show_categories_on_home') }}</label>
            <select class="form-control" name="meta[show_categories_on_home]" id="">

                <option value="1" @if ($shop->show_categories_on_home == 1) selected @endif>{{ __('words.true') }}</option>
                <option value="0" @if ($shop->show_categories_on_home == 0) selected @endif>{{ __('words.false') }}
                </option>

            </select>
        </div>
    </div>

</div>
