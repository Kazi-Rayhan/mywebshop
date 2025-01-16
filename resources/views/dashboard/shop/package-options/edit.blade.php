<x-dashboard.shop>
<h3><span class="text-primary opacity-25">{{ __('words.options') }}</span> </h3>
    <div class="card">
        <div class="card-body">
            <form class="row" action="{{ route('shop.packageoptions.update',$packageoption) }}" method="post">
                @method('put')
                @csrf
                @include('dashboard.shop.package-options.form')
            </form>
        </div>
    </div>
</x-dashboard.shop>