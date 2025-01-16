<div>
    <button type="button" wire:click="add" class="btn btn-sm btn-primary">{{__('words.add')}} <i class="fas fa-plus"></i></button>


    @foreach ($links as $key => $link)
        @php
            $link = (array) $link;
        @endphp
        <div class="row ">


            <div class="col-md-2">
                <x-form.input type="text" name="meta[socials][{{ $loop->iteration }}][platform]"
                    label="{!! __('words.platform') !!}" :value="old('meta.socials.' . $key . '.platform', $link['platform'])" />
            </div>
            <div class="col-md-3">
                <x-form.input type="url" name="meta[socials][{{ $loop->iteration }}][url]"
                    label="{!! __('words.url') !!}" :value="old('meta.socials.' . $key . '.url', $link['url'])" />
            </div>
            <div class="col-md-3">
                @php
                    $footer = __('words.menu_footer');
                    $nav = __('words.menu_nav');
                @endphp

                <x-form.input type="select" name="meta[socials][{{ $loop->iteration }}][position]" required
                    label="{!! __('words.nav_link_postions') !!}" :value="old('meta.socials.' . $key . '.position', @$link['position'])" :options="['footer' => $footer, 'nav' => $nav]" />

            </div>
            <div class="col-md-3 d-flex align-items-center">
                <div class="form-group">
                    <input type="checkbox" name="meta[socials][{{ $loop->iteration }}][new_window]"
                        id="new_window_{{ $key }}" @if (@$link['new_window']) checked @endif>
                    <label for="new_window_{{ $key }}">{{ __('words.new_window') }}</label>
                </div>

            </div>
            <div class="col-md-1">
                @if (count($links) > 1)
                    <button type="button" class="btn btn-sm btn-danger" wire:click="remove({{ $key }})"><i
                            class="fas fa-times "></i></button>
                @endif
            </div>
        </div>
    @endforeach
</div>
