<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.branchadmindashboard')]
class BranchAnalytics extends Component
{
    public function mount()
    {
        if (Auth::user()->role !== 'branch_admin') {
            abort(403);
        }
    }

    public function render()
    {
        $user = Auth::user();
        $orders = Order::where('branch_admin_id', $user->id)->get();

        $totalOrders = $orders->count();
        $totalRevenue = $orders->where('payment_status', 'paid')->sum('price');
        $activeOrders = $orders->whereNotIn('status', ['completed', 'cancelled'])->count();
        $completedOrders = $orders->where('status', 'completed')->count();

        // Calculate monthly revenue for the current year
        $monthlyRevenue = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyRevenue[] = $orders->where('payment_status', 'paid')
                ->filter(function ($order) use ($i) {
                    return $order->created_at->month == $i && $order->created_at->year == now()->year;
                })->sum('price');
        }

        return view('livewire.admin.branch-analytics', [
            'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue,
            'activeOrders' => $activeOrders,
            'completedOrders' => $completedOrders,
            'monthlyRevenue' => $monthlyRevenue,
        ]);
    }
}
