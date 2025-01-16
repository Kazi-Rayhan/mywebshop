<?php

namespace App\Http\Livewire;

use App\Models\Package;
use Livewire\Component;

class Trainerbooking extends Component
{
    public $shop;
    public $user;
    public $subscription = false;
 
    public $trainer;
    public $session;
    public $packages;

    public $pt_input;
    public $sessionI;
    
    public $split = false;

    public $selectedSession;

    public $price = 0;
    public $tax = 0;
    public $total_tax = 0;
    public $sub_price = 0;
    public $total_price = 0;

    public function mount($shop, $session,  $trainer,$user)
    {
        $this->user = $user;
        $this->trainer = $trainer;
        $this->session = $session;
        if ($this->trainer) {
            $this->subscription = $trainer->service_type == 'default' ? false : true;
            $this->packages  = Package::where('shop_id', $this->shop->id)->when($this->trainer->service_type != 'both', function ($query) {
                $query->when($this->subscription == true, fn ($query) => $query->where('type', 'subscription'))
                    ->when($this->subscription == false, fn ($query) => $query->where('type', 'default'));
            })->get();
        } else {
            $this->packages  = Package::where('shop_id', $this->shop->id)->where('type', $this->subscription ? 'subscription' : 'default')->get();
        }

      

        $this->pt_input = $this->trainer->id ??  $this->trainers[0]->id ?? null;

        $this->shop = $shop;
        $this->pt_input = $trainer->id ??  $this->trainers[0]->id ?? null;
        $this->sessionI =  $this->packages->first()?->id;

        $this->updatePrice();
    }

    public function updatedSessionI()
    {
        $this->updatePrice();
    }

    public function updatedSubscription()
    {
    


        $this->packages  = Package::where('shop_id', $this->shop->id)->where('type', $this->subscription ? 'subscription' : 'default')->get();
        $this->pt_input = $this->trainer->id ??  $this->trainers[0]->id ?? null;
        $this->sessionI =  $this->packages->first()?->id;
    }

    public function updatedPtinput()
    {
        $this->updatePrice();
    }

    public function render()
    {
        return view('livewire.trainerbooking');
    }

    public function updatePrice()
    {
        $this->selectedSession = Package::find($this->sessionI);
        if ($this->selectedSession) {
            $this->sub_price = $this->selectedSession->getPrice($this->pt_input,$this->split);
            $this->total_price =  $this->selectedSession->getPrice($this->pt_input);
            $this->tax =  ($this->sub_price * $this->selectedSession->tax) / 100 ;
            $this->price = $this->total_price / $this->selectedSession->sessions;
        }
    }
    public function updatedSplit(){
        
        $this->updatePrice();
    }
}
