<x-dashboard.shop>
    <h3>{!! __('words.store_edit_sec_title') !!}</h3>

    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('shop.storage.update', $storage) }}" method="post">
                        @csrf
                        @method('patch')
                        @include('dashboard.shop.storage.includes.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.shop>
