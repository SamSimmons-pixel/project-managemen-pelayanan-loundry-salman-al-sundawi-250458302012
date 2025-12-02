<?php

namespace App\Livewire\User;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.userdashboard')]
class Payment extends Component
{
    public Order $order;
    public $snapToken;

    public function mount($orderId)
    {
        $this->order = Order::with('user')->where('id', $orderId)->where('user_id', Auth::id())->firstOrFail();

        if (in_array($this->order->status, ['settlement', 'completed', 'cancelled', 'denied', 'expired'])) {
            return redirect()->route('user.track-order')->with('error', 'This order cannot be paid for.');
        }

        // Set your Merchant Server Key
        Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        Config::$isProduction = config('midtrans.is_production');
        // Set 3DS transaction for credit card to true
        Config::$is3ds = config('midtrans.is_3ds');

        $params = array(
            'transaction_details' => array(
                'order_id' => $this->order->custom_order_id,
                'gross_amount' => (int) $this->order->price,
            ),
            'customer_details' => array(
                'first_name' => $this->order->user->name,
                'email' => $this->order->user->email,
            ),
            'callbacks' => array(
                'finish' => route('user.track-order'),
            ),
        );

        $this->snapToken = Snap::getSnapToken($params);
        $this->order->snap_token = $this->snapToken;
        $this->order->save();
    }

    public function render()
    {
        return view('livewire.user.payment');
    }


}
