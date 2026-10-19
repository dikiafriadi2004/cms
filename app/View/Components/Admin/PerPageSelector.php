<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PerPageSelector extends Component
{
    public function __construct(
        public int $perPage = 20,
        public array $options = [5, 10, 20, 50],
        public ?LengthAwarePaginator $paginator = null,
    ) {}

    public function render()
    {
        return view('admin.partials.per-page-selector');
    }
}
