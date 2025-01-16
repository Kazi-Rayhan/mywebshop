<x-dashboard.shop>
    
    <h3>{{ __('words.group_edit_sec_title') }}</h3>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body shadow-lg">
                    <form action="{{route('shop.booking.price-groups.update',$priceGroup)}}" method="POST">
                            @csrf
                            @method('put')
                            @include('dashboard.shop.booking.groups.includes.fields')
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    @endpush
</x-dashboard.shop>
