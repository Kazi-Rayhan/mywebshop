@props([
    'link' => '',
    'title' => '',
    'icon' => '',
    'active' => true,
    'hasDropdown' => false,
    'id'=>''
])

@if($active)
@if ($hasDropdown)
    <li class="collapsed ">
        <a class="link" data-bs-toggle="collapse" aria-expanded="false" href="#collapse{{ $id }}" role="button"
            aria-controls="collapse{{ $id }}">
            <span class="fa {{ $icon }} mr-3"></span>
            <b>{!!
                 $title !!}</b>
        </a>
    @else
    <li class="@if ($link == url()->current()) active @endif">
        <a class="link" href="{{ $link }}">
            <span class="fa {{ $icon }} mr-3"></span>
            <b>{!! $title !!}</b>
        </a>
@endif

@if ($hasDropdown)
    <div class=" collapse multi-collapse ml-4" id="collapse{{ $id }}">
        <ul class="list-unstyled components">
            {{$slot}}
        </ul>
    </div>
@endif

</li>
@endif
