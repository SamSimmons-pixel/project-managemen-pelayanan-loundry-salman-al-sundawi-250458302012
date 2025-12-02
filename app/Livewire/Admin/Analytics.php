<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.admindashboard')]
class Analytics extends Component
{
    public function mount()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
    }
    public function render()
    {
        $branchAdmins = User::where('role', 'branch_admin')->get()->map(function ($admin) {
            $orders = Order::where('branch_admin_id', $admin->id)->get();

            return [
                'name' => $admin->name,
                'email' => $admin->email,
                'total_orders' => $orders->count(),
                'total_revenue' => $orders->where('payment_status', 'paid')->sum('price'),
                'active_orders' => $orders->whereNotIn('status', ['completed', 'cancelled'])->count(),
            ];
        });

        $totalSystemRevenue = Order::where('payment_status', 'paid')->sum('price');
        $totalSystemOrders = Order::count();

        return view('livewire.admin.analytics', [
            'branchAdmins' => $branchAdmins,
            'totalSystemRevenue' => $totalSystemRevenue,
            'totalSystemOrders' => $totalSystemOrders,
        ]);
    }
}
