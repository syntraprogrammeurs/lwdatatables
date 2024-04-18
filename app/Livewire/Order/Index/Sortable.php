<?php

namespace App\Livewire\Order\Index;

use Livewire\Attributes\Url;

trait Sortable
{
    #[Url]
    public $sortCol;

    #[Url]
    public $sortAsc = false;

    public function sortBy($column)
    {
        if ($this->sortCol === $column) {
            $this->sortAsc = ! $this->sortAsc;
        } else {
            $this->sortCol = $column;
            $this->sortAsc = false;
        }
    }

    protected function applySorting($query)
    {
        if ($this->sortCol) {
            $column = match ($this->sortCol) {
                'number' => 'number',
                'status' => 'status',
                'date' => 'ordered_at',
                'amount' => 'amount',
            };

            $query->orderBy($column, $this->sortAsc ? 'asc' : 'desc');
        }

        return $query;
    }
}
