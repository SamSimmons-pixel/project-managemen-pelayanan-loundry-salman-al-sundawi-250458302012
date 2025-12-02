<?php

namespace App\Livewire\User;

use App\Models\Machine as MachineModel;
use App\Models\Rental;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Midtrans\Config as MidtransConfig;
use Midtrans\Snap as MidtransSnap;

class Machine extends Component
{
    #[Layout('layouts.userdashboard', ['title' => 'Machine'])]
    public function render()
    {
        $machines = MachineModel::with('branchAdmin')->get();
        $userRentals = Rental::where('user_id', Auth::id())->where('status', 'in_use')->pluck('machine_id')->toArray();

        // Group machines by branch admin
        $groupedMachines = $machines->groupBy('branch_admin_id');

        return view('livewire.user.machine', [
            'groupedMachines' => $groupedMachines,
            'userRentals' => $userRentals,
        ]);
    }

    public function rentMachine($machineId)
    {
        $machine = MachineModel::findOrFail($machineId);

        if ($machine->status !== 'available') {
            session()->flash('error', 'This machine is not available for rent.');
            return;
        }

        $machine->status = 'pending';
        $machine->save();

        $rental = Rental::create([
            'user_id' => Auth::id(),
            'machine_id' => $machine->id,
            'rental_time' => now(),
            'price' => 10000,
            'status' => 'unpaid',
        ]);

        MidtransConfig::$serverKey = config('midtrans.server_key');
        MidtransConfig::$isProduction = config('midtrans.is_production');
        MidtransConfig::$isSanitized = true;
        MidtransConfig::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => 'RENTAL-' . $machine->machine_id . '-' . $rental->id . '-' . time(),
                'gross_amount' => $rental->price,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
            'custom_field1' => json_encode(['rental_id' => $rental->id]),
        ];

        $snapToken = MidtransSnap::getSnapToken($params);

        $this->dispatch('openMidtransSnap', $snapToken);
    }

    #[On('finishRental')]
    public function finishRental($machineId)
    {
        $machine = MachineModel::findOrFail($machineId);

        $rental = Rental::where('machine_id', $machineId)
            ->where('user_id', Auth::id())
            ->where('status', 'in_use')
            ->first();


            $machine->status = 'unpaid';
            $machine->save();

            if ($rental) {
                $rental->status = 'unpaid';
                $rental->save();
            }

            $this->dispatch('rental-finished');
    }

    public function cancelRental($machineId)
    {
        $machine = MachineModel::findOrFail($machineId);

        // Find rental that is either pending (unpaid) or already in use
        $rental = Rental::where('machine_id', $machineId)
            ->where('user_id', Auth::id())
            ->whereIn('status', ['unpaid', 'pending'])
            ->first();

        if ($rental) {
            $machine->status = 'available';
            $machine->save();

            $rental->status = 'cancelled';
            $rental->save();

            session()->flash('success', 'You have canceled your rental.');
        } else {
            session()->flash('error', 'You do not have a pending rental for this machine.');
        }
    }
}
