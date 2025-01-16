<x-dashboard.shop>
    <h3><span class="text-primary opacity-25">{!! __('words.store_create_sec_title') !!}</h3>

    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('shop.storage.store') }}" method="post">
                        @csrf
                        @include('dashboard.shop.storage.includes.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.shop>
