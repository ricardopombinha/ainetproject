<?php

namespace App\View\Components\movie;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class filterCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $filterAction,
        public string $resetUrl,
        public ?string $title = null,
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.movie.filter-card');
    }
}
