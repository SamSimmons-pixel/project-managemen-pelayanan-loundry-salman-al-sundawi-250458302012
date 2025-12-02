<?php

namespace App\Livewire\User;

use App\Models\User;
use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\ServicePackage;
use Illuminate\Support\Facades\Auth;

class PlaceOrder extends Component
{
    public $service_type = '';
    public $weight = '';
    public $pickup_address = '';
    public $pickup_time = '';
    public $branch_admin_id = '';
    public $promo_code = '';
    public $packages;

    public function mount()
    {
        $this->packages = ServicePackage::where('status', 'Active')->get();
    }

    private function generateOrderId($userId)
    {
        return 'ORD-' . $userId . '-' . now()->format('YmdHis') . '-' . substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 4);
    }

    public function submitPickup()
    {
        $this->validate([
            'service_type' => 'required|exists:service_packages,name',
            'weight' => 'required|numeric',
            'pickup_address' => 'required|string',
            'pickup_time' => 'required|date',
            'branch_admin_id' => 'required|exists:users,id',
            'promo_code' => [
                'nullable',
                'string',
                'exists:promos,code',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        $hasUsedPromo = Order::where('user_id', Auth::id())
                            ->where('promo_code', $value)
                            ->exists();

                        if ($hasUsedPromo) {
                            $fail('This promo code has already been used.');
                            return;
                        }

                        if ($this->branch_admin_id) {
                            $promo = \App\Models\Promo::where('code', $value)->first();
                            if ($promo && $promo->branch_admin_id != $this->branch_admin_id) {
                                $fail('This promo code is not valid for the selected branch.');
                            }
                        }
                    }
                },
            ],
        ]);

        $bookingFee = 10000;

        $order = Order::create([
            'user_id' => Auth::id(),
            'order_id' => $this->generateOrderId(Auth::id()),
            'order_type' => 'pickup',
            'service_type' => $this->service_type,
            'weight' => $this->weight,
            'approximate_price' => $this->weight * 10000,
            'price' => null,
            'booking_fee' => $bookingFee,
            'pickup_address' => $this->pickup_address,
            'pickup_time' => $this->pickup_time,
            'status' => 'pending',
            'branch_admin_id' => $this->branch_admin_id,
            'promo_code' => $this->promo_code,
        ]);


        return redirect()->to(route('user.track-order', ['orderId' => $order->id]));
    }

    // probably unused (tbh im not sure, im too lazy to find it out)
    public function orderPayment($orderId)
    {
        $bookingFee = 10000;

        $order = Order::create([
            'user_id' => Auth::id(),
            'order_id' => $this->generateOrderId(Auth::id()),
            'order_type' => 'pickup',
            'service_type' => $this->service_type,
            'weight' => $this->weight,
            'approximate_price' => $this->weight * 10000, // Approximate price calculation
            'price' => null, // Final price is null initially
            'booking_fee' => $bookingFee,
            'pickup_address' => $this->pickup_address,
            'pickup_time' => $this->pickup_time,
            'status' => 'pending',
            'branch_admin_id' => $this->branch_admin_id,
        ]);

        // Midtrans payment initiation
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $order->order_id,
                'gross_amount' => $bookingFee,
            ),
            'customer_details' => array(
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        $order->snap_token = $snapToken;
        $order->save();

        return redirect()->to('https://app.sandbox.midtrans.com/snap/v2/vtweb/' . $snapToken);
    }


    #[Layout('layouts.userdashboard', ['title' => 'Place Order'])]
    public function render()
    {
        $branchAdmins = User::where('role', 'branch_admin')->get();
        return view('livewire.user.place-order', ['branchAdmins' => $branchAdmins]);
    }
}
