<?php

namespace App\Livewire\Order\Index;

use Livewire\Component;
use App\Models\Store;

class Page extends Component
{
    public Store $store;

    public Filters $filters;

    public function mount()
    {
        $this->filters->init($this->store);
    }

    public function render()
    {
        return view('livewire.order.index.page');
    }
}
