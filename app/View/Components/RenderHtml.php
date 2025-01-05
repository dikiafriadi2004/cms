<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Component;

class RenderHtml extends Component
{
    public $html;
    public $data;

    public function __construct($html, $data = [])
    {
        $this->html = $html;
        $this->data = $data;
    }

    public function render()
    {
        return function (array $data) {
            $data = array_merge($data, $this->data);
            return Blade::render($this->html, $data);
        };
    }
}
