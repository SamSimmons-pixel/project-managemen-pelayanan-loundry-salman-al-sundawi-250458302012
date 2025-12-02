<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Layout;

class Invoice extends Component
{
    #[Layout('layouts.userdashboard', ['title' => 'Invoice'])]
    public function render()
    {
        $orders = \App\Models\Order::where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->where('payment_status', 'paid')
            ->latest()
            ->get();

        return view('livewire.user.invoice', ['orders' => $orders]);
    }
}
