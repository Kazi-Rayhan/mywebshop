<?php

namespace App\View\Components;

use App\Models\Area as ModelsArea;
use App\Models\Product;
use Illuminate\View\Component;

class Area extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $areas;
    public $product;
    public function __construct(Product $product)
    {
        $this->areas = ModelsArea::all();  
        $this->product =  $product;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.area');
    }
}
