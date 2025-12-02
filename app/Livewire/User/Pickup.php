<?php

namespace App\Livewire\User;

use Midtrans\Snap;
use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.userdashboard', ['title' => 'Pickup'])]
class Pickup extends Component
{
    public $orderId;

    public function mount($orderId)
    {
        $this->orderId = $orderId;
    }

    public function setPaymentOption($option)
    {
        $order = Order::findOrFail($this->orderId);
        $order->payment_option = $option;
        $order->final_payment_method = ($option === 'online') ? 'deliver_to_customer' : 'awaiting_user';
        $order->save();

        if ($option === 'online') {
            return $this->payOnline();
        }

        return $this->payOffline();
    }

    public function payOffline()
    {
        $order = Order::findOrFail($this->orderId);
        $order->status = 'unpaid';
        $order->save();

        session()->flash('success', 'Order set to offline pickup. Please proceed to the laundry to pick up your items.');
        return redirect()->route('user.track-order');
    }

    public function payOnline()
    {
        $order = Order::findOrFail($this->orderId);

        // Midtrans payment initiation
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $order->order_id . '-FINAL',
                'gross_amount' => $order->price,
            ),
            'customer_details' => array(
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ),
        );

        $snapToken = Snap::getSnapToken($params);
        $order->snap_token = $snapToken;
        $order->save();

        return redirect()->to('https://app.sandbox.midtrans.com/snap/v2/vtweb/' . $snapToken);
    }

    #[Layout('layouts.userdashboard', ['title' => 'Pickup'])]
    public function render()
    {
        return view('livewire.user.pickup', [
            'orderId' => $this->orderId,
        ]);
    }
}
