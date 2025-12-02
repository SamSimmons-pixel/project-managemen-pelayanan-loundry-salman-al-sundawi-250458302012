<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.admindashboard')]
class Dashboard extends Component
{
    public function mount()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
    }
    public function updateStatusToWashing($orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->status = 'washing';
        $order->save();
        session()->flash('success', 'Order status updated to washing.');
    }

    public function render()
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('price');
        $activeBranches = \App\Models\User::where('role', 'branch_admin')->count();
        $recentOrders = Order::with(['user', 'branchAdmin'])->latest()->take(5)->get();

        return view('livewire.admin.dashboard', [
            'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue,
            'activeBranches' => $activeBranches,
            'recentOrders' => $recentOrders,
        ]);
    }
}
