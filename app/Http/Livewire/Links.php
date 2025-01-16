<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Links extends Component
{
    public $links;
    protected $shop;
    public function mount($shop=null)
    { 
        $this->shop  =$shop ?? auth()->user()->shop ;
     
        $this->links = $this->shop->links;
       
    }
    public function add()
    {
        array_push($this->links, ['platform' => '', 'url' => '','position' => 'footer']);
    }
    public function remove($index)
    {
  
        unset($this->links[$index]);
    }
    public function render()
    {
        return view('livewire.links', ['links' => $this->links, 'shop' => $this->shop]);
    }
}
