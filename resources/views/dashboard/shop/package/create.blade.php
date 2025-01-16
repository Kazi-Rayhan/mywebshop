<x-dashboard.shop>

    <h3><span class="text-primary opacity-25">{{ __('words.packages') }}</span> </h3>
    <div class="card">
        <div class="card-body">
            <form class="row" action="{{ route('shop.packages.store') }}" method="post">
                @csrf
                @include('dashboard.shop.package.form')
            </form>
        </div>
    </div>
</x-dashboard.shop>