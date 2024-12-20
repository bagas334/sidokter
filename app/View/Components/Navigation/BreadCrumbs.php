<?php

namespace App\View\Components\Navigation;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BreadCrumbs extends Component
{
    public array $breadcrumbs;

    /**
     * Create a new component instance.
     *
     * @param array $breadcrumbs
     */
    public function __construct(array $breadcrumbs = [])
    {
        $this->breadcrumbs = $breadcrumbs;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.navigation.bread-crumbs');
    }
}
