<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Layout;

class UpdateOrder extends Component
{
    public Order $order;
    public $final_amount;

    public function mount($orderId)
    {
        $this->order = Order::findOrFail($orderId);
        $this->final_amount = $this->order->final_amount;
    }

    public function updateOrder()
    {
        $this->validate([
            'final_amount' => 'required|numeric|min:0',
        ]);

        $this->order->update([
            'final_amount' => $this->final_amount,
            'status' => 'ready_for_pickup',
        ]);

        session()->flash('message', 'Order updated successfully!');
        return redirect()->route('admin.dashboard');
    }

    #[Layout('layouts.admindashboard', ['title' => 'Update Order'])]
    public function render()
    {
        return view('livewire.admin.update-order');
    }
}
