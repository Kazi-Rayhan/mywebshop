<x-dashboard.shop>
    <h3><span class="text-primary opacity-25"><i class="fas fa-box" aria-hidden="true"></i></span> {!! __('words.subs_create_title') !!}
    </h3>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body shadow-lg">
                    <form action="{{route('shop.boxes.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @include('dashboard.shop.boxes.include.form')
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('#products').select2();
    </script>

  
@endpush

</x-dashboard.shop>
