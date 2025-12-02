<?php

namespace App\Http\Livewire\User;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TrackOrder extends Component
{
    public $orders;

    public function mount()
    {
        $this->orders = Order::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
    }

    public function render()
    {
        return view('livewire.user.track-order');
    }

    public function showDetails($orderId)
    {
        $order = Order::where('custom_order_id', $orderId)->first();
        // This will be implemented later to show order details in a modal or a separate page.
        session()->flash('message', 'Showing details for order #' . $order->custom_order_id);
    }
}
