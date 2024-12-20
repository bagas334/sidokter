<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LineChart extends Component
{
    public array|object $labels;
    public array|object $value;

    /**
     * Create a new component instance.
     */
    public function __construct($labels, $value)
    {
        $this->labels = $labels;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.line-chart');
    }
}
