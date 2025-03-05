<?php

namespace App\View\Components\seats;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class table extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public object $seats, public object $screening, public bool $showAddToCart = false, public bool $showRemoveFromCart = false,)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.seats.table');
    }
}
