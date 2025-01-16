<x-shop-front-end>
    <div class="container mt-5">
        <div class="row product-card-parent">
            @foreach ($services as $service)
                <div class="col-6 col-sm-6 col-md-4 col-lg-4 mb-4">
                    <x-service :service="$service" />
                </div>
            @endforeach
        </div>
    </div>
</x-shop-front-end>
