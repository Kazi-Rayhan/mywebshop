<div class="product-card card-gape">
    <div class="product-content">
        <div class="product-name">
            <h6>
                <a href="{{ route('serviceSingle', [request('user_name'), $service->slug]) }}">
                    {{ $service->name }}
                </a>
            </h6>
        </div>
        <div class="product-price">
            <div class="product-rating">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
                <span></span>
            </div>
        </div>
    </div>
</div>
