
<div class="col-md-12">
    <x-form.input type="text" label="{{ __('words.title') }}" name="title"
        value="{{ old('title', $package->title) }}" />
</div>
<div class="col-12 col-md-4">
    <x-form.input type='number' min="0" name='sessions' label="{{ __('words.sessions') }}"
        value="{{ old('sessions', $package->sessions) }}" />
</div>
{{-- <div class="col-12 col-md-3">
    <x-form.input type='number' name='price' label="{{ __('words.price') }}"
        value="{{ old('price', $package->price) }}" min="0" />
</div>

<div class="col-12 col-md-3">
    <x-form.input type='number' name='tax' label="{{ __('words.tax') }}" value="{{ old('tax', $package->tax) }}"
        min="0" max="100" />
</div> --}}
<div class="col-12 col-md-4">
    <x-form.input type='number' name='validity' label="{{ __('words.package_validity_days') }}"
        value="{{ old('validity', $package->validity) }}" min="0" />
</div>
<div class="col-12 col-md-4">
    <x-form.input type='select' name='type' id='type' :label="__('words.package_type')" :value="$package->type == null ? 'default' : $package->type" :options="[
        'default' => 'Default',
        'subscription' => 'Offline Subscription',
        'subscription_online' => 'Online Subscription',
    ]" />

</div>
<div class="col-12">
    <x-form.input type="textarea" name='details' label="{{ __('words.details') }}"
        value="{{ old('details', $package->details) }}" />
</div>
<div class="row" id="is_default">
    <div class="col-md-4">
        <x-form.input type='select' name='split_price' id='split_price' :label="__('words.split_price')" :value="$package->split == null ? 0 : 1"
            :options="[__('words.no'), __('words.yes')]" />
    </div>
    <div class="col-md-8">
        <x-form.input type='number' min="0" name='split' id='split' label="{{ __('words.split') }}"
            value="{{ old('split', $package->split) }}" />
    </div>
</div>

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4>{{ __('words.levels') }}</h4>


        </div>
        <div class="card-body">
            @if ($levels->count() > 0)
                @foreach ($levels as $level)
                    <label for="level{{ $level->id }}"> {{ $level->title }}</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend ">
                            <div class="input-group-text h-100">
                                <input @if ($package->levels->contains($level->id)) checked @endif
                                    data-id="level{{ $level->id }}" onchange="toggle(this)" type="checkbox"
                                    aria-label="Checkbox for following text input">
                            </div>
                        </div>

                        <input @if (!$package->levels->contains($level->id)) disabled @endif id="level{{ $level->id }}"
                            type="number"
                            class="form-control @error('levels.' . $level->id . '.price') is-invalid @enderror"
                            name="levels[{{ $level->id }}][price]" placeholder="{{ $level->title }}"
                            value="{{ @$package->levels->find($level->id)->pivot->price }}">
                    </div>
                @endforeach
            @else
                <h1 class="text-center @error('levels') text-danger @enderror">
                    {{ __('words.level_is_missing') }}
                </h1>
            @endif

        </div>
    </div>

    <button class=" btn btn-primary mt-2">
        + Save
    </button>
    @push('scripts')
        <script>
            const toggle = (e) => {
                if (e.checked) {
                    document.getElementById(e.dataset.id).disabled = false
                } else {
                    document.getElementById(e.dataset.id).disabled = true

                }
            }
        </script>
        <script>
            // $("#is_default").hide()
            $("#split").attr('readonly', true)

            $("#split_price").change(event => {

                switchSplit()
            })

            $("#type").change(event => {

                switchSplitFileds()
            })

            const switchSplit = () => {
                switch ($('#split_price').val()) {
                    case '1':
                        $("#split").attr('readonly', false)
                        break;

                    default:
                        $("#split").attr('readonly', true)
                        break;
                }
            }

            
            const switchSplitFileds = () => {
                switch ($('#type').val()) {
                    case 'default':
                        $("#is_default").show()
                        break;

                    default:
                        $("#is_default").hide()
                        break;
                }
            }

            switchSplitFileds()
            switchSplit()
        </script>
    @endpush
