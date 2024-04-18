<?php

use App\Livewire\Order\Index\Page;
use Illuminate\Support\Facades\Route;

Route::get('/store/{store}/orders', Page::class)
    ->middleware('can:view,store');
