<?php

namespace App\Http\Livewire\User;

use App\Livewire\Forms\PickupForm;
use App\Livewire\Forms\RentalForm;
use App\Models\Order;
use App\Models\Rental;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\ServicePackage;

class PlaceOrder extends Component
{
    public PickupForm $pickupForm;
    public RentalForm $rentalForm;
    public $packages;
    public $activeTab = 'pickup';

    public function mount()
    {
        $this->pickupForm->reset();
        $this->rentalForm->reset();
        $this->packages = ServicePackage::all();
        }

    public function render()
    {
        $branchAdmins = User::where('role', 'branch_admin')->get();
        return view('livewire.user.place-order', compact('branchAdmins'));
    }

    public function submitPickup()
    {
        $this->pickupForm->validate();

        Order::create([
            'order_id' => 'ORD-' . strtoupper(Str::random(8)),
            'user_id' => Auth::id(),
            'order_type' => 'online',
            'service_type' => $this->pickupForm->service_type,
            'weight' => $this->pickupForm->weight,
            'pickup_address' => $this->pickupForm->pickup_address,
            'pickup_time' => $this->pickupForm->pickup_time,
            'branch_admin_id' => $this->pickupForm->branch_admin_id,
            'status' => 'pending',
            'price' => 10000,
            'payment_status' => 'pending',
        ]);

        session()->flash('message', 'Order placed successfully! Please complete the payment within 5 minutes.');
        return redirect()->route('user.track-order');
    }

    public function submitRental()
    {
        $this->rentalForm->validate();

        Rental::create([
            'user_id' => Auth::id(),
            'machine_id' => $this->getMachineId($this->rentalForm->machine_type),
            'rental_duration' => $this->rentalForm->rental_duration,
            'rental_time' => $this->rentalForm->rental_time,
            'status' => 'booked',
        ]);

        session()->flash('message', 'Machine rental order placed successfully!');
        return redirect()->route('user.track-order');
    }

    private function getMachineId($machine_type)
    {
        // This is a placeholder. You should implement logic to get the actual machine ID based on the type.
        return 1;
    }
}
