<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use GuzzleHttp\Middleware;

#[Middleware('auth')]
class Dashboard extends Component
{
    public function render()
    {
        $this->authorize('admin');
        return view('livewire.admin.dashboard');
    }
}
