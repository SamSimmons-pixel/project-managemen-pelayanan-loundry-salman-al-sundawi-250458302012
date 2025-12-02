<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.branchadmindashboard')]
class BranchAdminDashboard extends Component
{
    public $totalOrders;
    public $revenueToday;
    public $activeMachines;
    public $pendingOrders;
    
    public $revenueLabels = [];
    public $revenueValues = [];
    public $machineLabels = [];
    public $machineValues = [];

    public function mount()
    {
        if (Auth::user()->role !== 'branch_admin') {
            abort(403);
        }
        $this->calculateMetrics();
    }

    public function calculateMetrics()
    {
        $branchId = Auth::id();
        $today = \Carbon\Carbon::today();

        // Stats
        $this->totalOrders = Order::where('branch_admin_id', $branchId)->count();
        $this->revenueToday = Order::where('branch_admin_id', $branchId)
            ->whereDate('created_at', $today)
            ->sum('price'); // Using 'price' as corrected before
        
        $totalMachines = \App\Models\Machine::where('branch_admin_id', $branchId)->count();
        $activeMachinesCount = \App\Models\Machine::where('branch_admin_id', $branchId)
            ->where('status', 'in_use') // Assuming 'in_use' is the status for active
            ->count();
        $this->activeMachines = "{$activeMachinesCount}/{$totalMachines}";

        $this->pendingOrders = Order::where('branch_admin_id', $branchId)
            ->where('status', 'pending')
            ->count();

        // Charts Data
        
        // Weekly Revenue (Last 7 days)
        $revenueData = Order::where('branch_admin_id', $branchId)
            ->select(
                \Illuminate\Support\Facades\DB::raw('sum(price) as sum'), 
                \Illuminate\Support\Facades\DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date")
            )
            ->where('created_at', '>=', \Carbon\Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
            
        $this->revenueLabels = $revenueData->pluck('date')->map(function($date) {
            return \Carbon\Carbon::parse($date)->format('D');
        })->toArray();
        $this->revenueValues = $revenueData->pluck('sum')->toArray();

        // Machine Usage (by Status)
        $machineData = \App\Models\Machine::where('branch_admin_id', $branchId)
            ->select('status', \Illuminate\Support\Facades\DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        $this->machineLabels = $machineData->pluck('status')->toArray();
        $this->machineValues = $machineData->pluck('count')->toArray();
    }

    public function render()
    {
        $orders = Order::where('branch_admin_id', Auth::id())->latest()->paginate(10);
        return view('livewire.admin.branch-admin-dashboard', [
            'orders' => $orders,
        ]);
    }
}
