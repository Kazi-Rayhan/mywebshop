@php

    $terms = TCG\Voyager\Models\Page::where('slug', 'betingelser')->first();

@endphp

@props(['id' => ''])
<!-- Modal trigger button -->
<a href="#" data-bs-toggle="modal" data-toggle="modal" data-target="#terms-and-service-{{ $id }}"
    data-bs-target="#terms-and-service-{{ $id }}">
    {{ __('words.betingelser') }}
</a>

<!-- Modal Body -->
<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
<div class="modal fade" id="terms-and-service-{{ $id }}" tabindex="10000000" data-bs-backdrop="static"
    data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId"> {{ __('words.betingelser') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-9 col-xl-8">
                        {!! $terms->body !!}

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
