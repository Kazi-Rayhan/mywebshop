<?php

namespace App\Providers;

use App\Models\Charge;
use App\Models\Meta;
use App\Models\Product;
use App\Models\Shop;
use App\Observers\ChargeObserver;
use App\Observers\MetaObserver;
use App\Observers\ProductObserver;
use App\Observers\ShopObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Meta::observe(MetaObserver::class);
        Product::observe(ProductObserver::class);
        Charge::observe(ChargeObserver::class);
        Shop::observe(ShopObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
