<?php

namespace App\Livewire\User;

use App\Http\Controllers\MidtransController;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\Promo;

class OrderTracking extends Component
{
    use WithPagination;

    public $promo;

    public function mount()
    {
        $this->promo = Promo::all();
    }

    public function checkOrderStatus($orderId)
    {
        $order = Order::where('id', $orderId)->where('user_id', Auth::id())->firstOrFail();

        if ($order->snap_token) {
            try {
                $midtransController = new MidtransController();
                $midtransController->checkAndUpdateStatus($order);
                session()->flash('success', 'Order status has been refreshed.');
            } catch (\Exception $e) {
                Log::error('Failed to refresh order status from Midtrans', [
                    'order_id' => $order->id,
                    'error' => $e->getMessage(),
                ]);
                session()->flash('error', 'Failed to refresh order status. Please try again later.');
            }
        }
    }

    private function refreshOrderStatus(Order $order)
    {
        if ($order->snap_token && in_array($order->status, ['waiting_for_payment', 'pending', 'waiting_for_booking_fee'])) {
            try {
                $midtransController = new MidtransController();
                $midtransController->checkAndUpdateStatus($order);
            } catch (\Exception $e) {
                Log::error('Failed to auto-refresh order status from Midtrans', [
                    'order_id' => $order->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    public function cancelOrder($orderId)
    {
        $order = Order::findOrFail($orderId);

        if ($order->status === 'waiting_for_pickup') {
            $order->status = 'cancelled';
            $order->save();
            session()->flash('success', 'Your order has been cancelled. The booking fee is non-refundable.');
            return;
        }

        if ($order->snap_token) {
            try {
                $midtransController = new MidtransController();
                $status = $midtransController->checkTransactionStatus($order->id);

                if (in_array($status, ['capture', 'settlement'])) {
                    session()->flash('error', 'Cannot cancel order that has already been paid.');
                    return;
                } elseif ($status === 'expire') {
                    session()->flash('error', 'Cannot cancel an expired order.');
                    return;
                }

                $response = $midtransController->cancelTransaction($order->id);
                $responseData = $response->getData(true);

                if ($response->isSuccessful()) {
                    session()->flash('success', $responseData['status_message'] ?? 'Order has been cancelled successfully.');
                } else {
                    session()->flash('error', $responseData['status_message'] ?? 'Failed to cancel the order.');
                }
            } catch (\Exception $e) {
                Log::error('Failed to cancel order with Midtrans', [
                    'order_id' => $order->id,
                    'error' => $e->getMessage(),
                ]);
                session()->flash('error', 'Failed to cancel the order. Please try again later.');
            }
        } else {
            $order->status = 'cancelled';
            $order->save();
            session()->flash('success', 'Order has been cancelled successfully.');
        }
    }

    public function payFinalAmount($orderId)
    {
        $order = Order::findOrFail($orderId);

        if ($order->final_payment_snap_token) {
            return redirect()->to('https://app.sandbox.midtrans.com/snap/v2/vtweb/' . $order->final_payment_snap_token);
        }

        // Midtrans payment initiation
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $order->order_id . '-FINAL' . time(),
                'gross_amount' => $order->price,
            ),
            'customer_details' => array(
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        $order->final_payment_snap_token = $snapToken;
        $order->save();

        return redirect()->to('https://app.sandbox.midtrans.com/snap/v2/vtweb/' . $snapToken);
    }

    public function payBookingFee($orderId)
    {
        $order = Order::where('id', $orderId)->where('user_id', Auth::id())->firstOrFail();

        if ($order->snap_token) {
            return redirect()->to('https://app.sandbox.midtrans.com/snap/v2/vtweb/' . $order->snap_token);
        }

        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $order->order_id,
                'gross_amount' => $order->booking_fee,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        $order->snap_token = $snapToken;
        $order->save();

        return redirect()->to('https://app.sandbox.midtrans.com/snap/v2/vtweb/' . $snapToken);
    }

    #[Layout('layouts.userdashboard', ['title' => 'Track Order'])]
    public function render()
    {
        $user = Auth::user();
        $query = Order::with('branchAdmin')->latest();

        if ($user->role == 'branch_admin') {
            $query->where('branch_admin_id', $user->branch_id);
        } else {
            $query->where('user_id', $user->id);
        }

        $orders = $query->paginate(3);

        foreach ($orders as $order) {
            $this->refreshOrderStatus($order);
        }

        return view('livewire.user.order-tracking', [
            'orders' => $orders,
        ]);
    }
}
