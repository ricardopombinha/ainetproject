<?php

namespace App\View\Components\screening;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class movieTable extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public object $movies,
    )
    {
        //
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.screening.movie-table');
    }
}
