<div class="d-flex flex-column justify-content-center align-items-center">
    <div>
        {!! QrCode::size($size)->generate($url) !!}
    </div>
    @if (!isset($disabled))
        <div class="btn btn-group">
            <a title="{!! __('words.qr_visit') !!}"  class="btn btn-outline-primary btn-sm" href="{{$url}}"><i class="fas fa-eye"></i></a>
            <button title="{!! __('words.print_qr') !!}" onclick="printDiv(this)" class="btn btn-outline-primary btn-sm" ><i class="fas fa-print"></i></button>
            <a title="{!! __('words.qr_visit') !!}"  class="btn btn-outline-primary btn-sm" href="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{$url}}"><i class="fas fa-download"></i></a>
        </div>
    @endif
</div>
