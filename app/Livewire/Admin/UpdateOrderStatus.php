<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Layout;

class UpdateOrderStatus extends Component
{
    public Order $order;
    public $finalAmount;

    public function mount(Order $order)
    {
        $this->order = $order;
    }

    public function updateOrder()
    {
        $this->validate([
            'finalAmount' => 'required|numeric|min:0',
        ]);

        $this->order->update([
            'status' => 'ready_for_pickup',
            'price' => $this->finalAmount,
        ]);

        $this->dispatch('orderUpdated');
    }

    public function render()
    {
        return view('livewire.admin.update-order-status');
    }
}
