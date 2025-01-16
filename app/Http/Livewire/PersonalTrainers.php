<?php

namespace App\Http\Livewire;

use App\Models\Package;
use Livewire\Component;

class PersonalTrainers extends Component
{
    public $shop;
    public $packagetype = 'session';
    public $trainers;
    public $trainer;
    public $session;
    public $packages;
    public $sPackage;
    public $split = false;


    public $pt_input;
    public $sessionI;

    public $selectedSession;

    public $price = 0;
    public $tax = 0;
    public $total_tax = 0;
    public $sub_price = 0;
    public $total_price = 0;

    public function mount($shop, $session,  $trainer)
    {
        $this->trainer = $trainer;
        $this->session = $session;

        if ($this->trainer) {
            $this->packages  = Package::where('shop_id', $this->shop->id)->when(!$this->trainer->provideServiceAll, function ($query) {
                $query->when($this->packagetype == 'offline_subscription', fn ($query) => $query->where('type', 'subscription'))
                    ->when($this->packagetype == 'online_subscription', fn ($query) => $query->where('type', 'subscription_online'))
                    ->when($this->packagetype == 'session', fn ($query) => $query->where('type', 'default'));
            })->get();
        } else {
            $this->packages  = Package::where('shop_id', $this->shop->id)->when($this->packagetype == 'offline_subscription', fn ($query) => $query->where('type', 'subscription'))
                ->when($this->packagetype == 'online_subscription', fn ($query) => $query->where('type', 'subscription_online'))
                ->when($this->packagetype == 'session', fn ($query) => $query->where('type', 'default'))->get();
        }
        $this->trainers = $this->shop->users()->personalTrainer()
            ->where(function ($query) {
                $query
                    ->when($this->packagetype == 'offline_subscription', function ($query) {
                        $query->where('service_type', 'LIKE', '%offline%');
                    })
                    ->when($this->packagetype == 'online_subscription', function ($query) {
                        $query->where('service_type', 'LIKE', '%online%');
                    })
                    ->when($this->packagetype == 'session', function ($query) {
                        $query->where('service_type', 'LIKE', '%default%');
                    })
                    ->orWhere('service_type', '["default","Offline","online"]');
            })->get();


        $this->pt_input = $this->trainer->id ??  $this->trainers[0]->id ?? null;

        $this->shop = $shop;
        $this->pt_input = $trainer->id ??  $this->trainers[0]->id ?? null;
        $this->sessionI =  $this->packages->first()?->id;
        $this->sPackage =  $this->packages->first();

        $this->updatePrice();
    }

    public function updatedSessionI()
    {
        $this->updatePrice();
    }

    public function updatedPackagetype()
    {

        $this->trainers = $this->shop->users()->personalTrainer()
            ->where(function ($query) {
                $query->when($this->packagetype == 'offline_subscription', function ($query) {
                    $query->where('service_type', 'LIKE', '%offline%');
                })
                    ->when($this->packagetype == 'online_subscription', function ($query) {
                        $query->where('service_type', 'LIKE', '%online%');
                    })
                    ->when($this->packagetype == 'session', function ($query) {
                        $query->where('service_type', 'LIKE', '%default%');
                    })
                    ->orWhere('service_type', '["default","Offline","online"]');
            })->get();


        if ($this->trainer) {

            $this->packages  = Package::where('shop_id', $this->shop->id)->when(!$this->trainer->provideServiceAll, function ($query) {
                $query->when($this->packagetype == 'offline_subscription', fn ($query) => $query->where('type', 'subscription'))
                    ->when($this->packagetype == 'online_subscription', fn ($query) => $query->where('type', 'subscription_online'))
                    ->when($this->packagetype == 'session', fn ($query) => $query->where('type', 'default'));
            })->get();
        } else {
            $this->packages  = Package::where('shop_id', $this->shop->id)->when($this->packagetype == 'offline_subscription', fn ($query) => $query->where('type', 'subscription'))
                ->when($this->packagetype == 'online_subscription', fn ($query) => $query->where('type', 'subscription_online'))
                ->when($this->packagetype == 'session', fn ($query) => $query->where('type', 'default'))->get();
        }
        $this->pt_input = $this->trainer->id ??  $this->trainers[0]->id ?? null;
        $this->sessionI =  $this->packages->first()?->id;
    }

    public function updatedIsOnline()
    {


        $this->packages  = Package::where('shop_id', $this->shop->id)->where('type', $this->isOnline ? 'subscription_online' : 'subscription')->get();

        $this->sessionI =  $this->packages->first()?->id;
    }

    public function updatedPtinput()
    {
        $this->updatePrice();
    }

    public function render()
    {
        return view('livewire.personal-trainers');
    }

    public function setpackagetype($value)
    {
        $this->packagetype = $value;
        $this->updatedPackagetype();
    }

    public function updatedSplit()
    {

        $this->updatePrice();
    }
    public function updatePrice()
    {
        $this->selectedSession = Package::find($this->sessionI);
        if ($this->selectedSession) {
            $this->sub_price = $this->selectedSession->getPrice($this->pt_input, $this->split);
            $this->total_price =  $this->selectedSession->getPrice($this->pt_input);
            $this->tax =  ($this->sub_price * $this->selectedSession->tax) / 100;
            $this->price = $this->total_price / $this->selectedSession->sessions;
        }
    }
}
