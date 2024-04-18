<?php

namespace App\Livewire\Order\Index;

use Livewire\WithPagination;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\Attributes\Renderless;
use Livewire\Attributes\Reactive;
use App\Models\Store;
use App\Models\Order;

class Table extends Component
{
    use WithPagination, Sortable, Searchable;

    public Store $store;

    #[Reactive]
    public Filters $filters;

    public $selectedOrderIds = [];

    public $orderIdsOnPage = [];

    #[Renderless]
    public function export()
    {
        return $this->store->orders()->toCsv();
    }

    public function refundSelected()
    {
        $orders = $this->store->orders()->whereIn('id', $this->selectedOrderIds)->get();

        foreach ($orders as $order) {
            $this->refund($order);
        }
    }

    public function refund(Order $order)
    {
        $this->authorize('update', $order);

        $order->refund();
    }

    public function archiveSelected()
    {
        $orders = $this->store->orders()->whereIn('id', $this->selectedOrderIds)->get();

        foreach ($orders as $order) {
            $this->archive($order);
        }
    }

    public function archive(Order $order)
    {
        $this->authorize('update', $order);

        $order->archive();
    }

    public function render()
    {
        $query = $this->store->orders();

        $query = $this->applySearch($query);

        $query = $this->applySorting($query);

        $query = $this->filters->apply($query);

        $orders = $query->paginate(5);

        $this->orderIdsOnPage = $orders->map(fn ($order) => (string) $order->id)->toArray();

        return view('livewire.order.index.table', [
            'orders' => $orders,
        ]);
    }

    public function placeholder()
    {
        return view('livewire.order.index.table-placeholder');
    }
}
