@props(['label', 'icon', 'link' => null, 'data', 'param' => []])
<div class="col-lg-4">
    <div class="card card-stats mb-4 ">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h5 class="card-title text-uppercase text-muted mb-0">{{ $label ?? '' }}</h5>
                    <span class="h3 font-weight-bold mb-0">{{ $data ?? '' }}</span>
                </div>
                <div class="col-auto">
                    <div class="bg-primary text-center text-white rounded-circle shadow" style="height:25px;width:25px">
                        <i class="{{ $icon ?? '' }}"></i>
                    </div>
                </div>
            </div>
            @if ($link)
                <a class="btn btn-outline-primary  float-right" href="{{ $link }}">{!! __('words.view_btn') !!}</a>
            @else
                <div class="p-3">

                </div>
            @endif
        </div>
    </div>
</div>
