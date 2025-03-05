<?php

namespace App\View\Components\cartcontent;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class table extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public array $seats, public Object $screenings, public int $price, public int $discount,public bool $showAddToCart = false, public bool $showRemoveFromCart = false,)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cartcontent.table');
    }
}
