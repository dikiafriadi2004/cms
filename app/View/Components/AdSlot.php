<?php

namespace App\View\Components;

use App\Models\Ad;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AdSlot extends Component
{
    public $ads;
    public $position;
    public $context;

    /**
     * Create a new component instance.
     */
    public function __construct(string $position, array $context = [])
    {
        $this->position = $position;
        $this->context = $context;
        $this->ads = Ad::getByPosition($position, $context);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ad-slot');
    }
}
