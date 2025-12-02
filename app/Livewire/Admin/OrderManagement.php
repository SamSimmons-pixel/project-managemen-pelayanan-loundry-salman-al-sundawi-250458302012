<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use App\Models\Promo;   

#[Layout('layouts.branchadmindashboard')]
class OrderManagement extends Component
{
    use WithPagination;

    public $selectedOrderId;
    public $showConfirmationModal = false;
    public $showEditModal = false;
    public $orderIdToUpdate;
    public $promo;

    public function mount()
    {
        $this->promo = Promo::all();
    }

    protected $listeners = ['orderUpdated' => 'handleOrderUpdated'];

    public function handleOrderUpdated()
    {
        $this->selectedOrderId = null;
        session()->flash('success', 'Order status updated to Ready for Pickup and final amount set.');
    }

    public function showUpdateForm($orderId)
    {
        $this->selectedOrderId = $orderId;
    }

    public function updateStatusToWashing($orderId)
    {
        $order = Order::find($orderId);
        if ($order && $order->branch_admin_id == Auth::id()) {
            $order->update(['status' => 'washing']);
            session()->flash('success', 'Order status updated to washing.');
        }
    }

    public function confirmStatusUpdate($orderId)
    {
        $this->orderIdToUpdate = $orderId;
        $this->showConfirmationModal = true;
    }

    public function finishOrder($orderId)
    {
        $order = Order::find($orderId);
        if ($order && $order->branch_admin_id == Auth::id()) {
            $order->update(['status' => 'completed']);
            session()->flash('success', 'Order status updated to completed.');
        }
    }

    public function updateStatusToCompleted()
    {
        $order = Order::find($this->orderIdToUpdate);
        if ($order && $order->branch_admin_id == Auth::id()) {
            $order->update(['status' => 'completed']);
            session()->flash('success', 'Order status updated to completed.');
        }
        $this->showConfirmationModal = false;
    }

    public $status;
    public $editOrderId;

    public function openEditModal($orderId)
    {
        $this->editOrderId = $orderId;
        $order = Order::find($orderId);
        if ($order) {
            $this->status = $order->status;
            $this->showEditModal = true;
        }
    }

    public function updateOrderStatus()
    {
        $this->validate([
            'status' => 'required|in:completed,ready_for_pickup,delivering,washing,unpaid',
        ]);

        $order = Order::find($this->editOrderId);
        if ($order && $order->branch_admin_id == Auth::id()) {
            $order->update(['status' => $this->status]);
            session()->flash('success', 'Order status updated successfully.');
        }

        $this->showEditModal = false;
        $this->editOrderId = null;
        $this->status = null;
    }



    public function render()
    {
        $orders = Order::where('branch_admin_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('livewire.admin.order-management', [
            'orders' => $orders,
        ]);
    }
}
