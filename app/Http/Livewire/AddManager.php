<?php

namespace App\Http\Livewire;

use App\Services\PaymentService;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddManager extends Component
{
    public $managers;
    public $charge;

    public function mount()
    {
        $this->managers = [
            [
                'photo' => '',
                'first_name' => '',
                'last_name' => '',
                'email' => '',
                'phone' => '',
                'tax' => '',
                'password' => '',
                'permissions' => 
                [
                    'manage_product' => 0,
                    'manage_order' => 0,
                    'manage_profile' => 0,
                ]
            ]
        ];
    }
    

    public function addRow()
    {
        $this->managers[] =
            [
                'photo' => '',
                'first_name' => '',
                'last_name' => '',
                'email' => '',
                'phone' => '',
                'tax' => '',
                'password' => '',
                'permissions' => 
                [
                    'manage_product' => 0,
                    'manage_order' => 0,
                    'manage_profile' => 0,
                ]
            ];
        
     
    }

    public function removeRow($index)
    {
        unset($this->managers[$index]);
        $this->managers = array_values($this->managers);
    }

    public function render()
    {
        return view('livewire.add-manager');
    }
}
