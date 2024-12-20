<?php

namespace App\View\Components\Buttons;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Seeder extends Component
{
    public string $route;
    public string $modal_id;
    /**
     * Create a new component instance.
     */
    public function __construct(string $route, string $modal_id)
    {
        $this->route = $route;
        $this->modal_id = $modal_id;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.button.seeder');
    }
}
