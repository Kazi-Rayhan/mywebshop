<x-dashboard.shop>
   
    <h3><span class="text-primary opacity-25"><i class="fas fa-list" aria-hidden="true"></i></span> {!! __('words.shipping_edit_sec_title') !!}
    </h3>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body shadow-lg">
                    <form action="{{route('shop.shippings.update',$shipping)}}" method="POST">

                            @method('put')
                            @csrf
                           @include('dashboard.shop.shippings.include.form')

                    </form>
                </div>
            </div>
        </div>
    </div>

</x-dashboard.shop>