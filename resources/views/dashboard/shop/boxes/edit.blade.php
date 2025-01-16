<x-dashboard.shop>
    <h3><span class="text-primary opacity-25"><i class="fas fa-box" aria-hidden="true"></i></span> Edit Subscription Boxes
    </h3>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body shadow-lg">
                    <form action="{{ route('shop.boxes.update', $box) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
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

        <script>
            $('#products').val({{ $box->products->pluck('id') }});
            $('#products').trigger('change');
        </script>
    @endpush

</x-dashboard.shop>
