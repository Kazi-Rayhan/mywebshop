<?php
namespace App\Services\Subscription;
use App\Models\Shop;
use App\Services\Subscription\ElavonSubscriptionServiceTrait;
class ShopSubscriptionService{
    use ElavonSubscriptionServiceTrait, QuickpaySubscriptionServiceTrait;
    protected $shop;

    public function __construct(Shop $shop)
    {
        $this->shop = $shop;
    }

    public static function createSubscription(Shop $shop)
    {
        return (new self($shop))->subscibe();
    }

    public static function confirmSubscription(Shop $shop)
    {
        return (new self($shop))->confirm();
    }

    protected function subscibe()
    {
        switch ($this->shop->subscriptionMethod) {
            case 'elavon':
                return $this->createSubscriptionWithElavon();
                break;
            default:
                return $this->createSubscriptionWithQuickPay();
                break;
        }
    }

    protected function confirm()
    {
        switch ($this->shop->subscriptionMethod) {
            case 'elavon':
                return $this->confirmSubscriptionWithElavon();
                break;
            default:
                return $this->confirmSubscriptionWithQuickPay();
                break;
        }
    }
}
