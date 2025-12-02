<?php

namespace App\Http\Controllers;

use Midtrans\Config;
use App\Models\Order;
use App\Models\Rental;
use App\Models\Machine;
use Midtrans\Transaction;
use Midtrans\Notification;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Snap;

class MidtransController extends Controller
{

    public function __construct()
    {
        $this->configureMidtrans();
    }

    private function configureMidtrans()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function getSnapToken($payload)
    {
        return Snap::getSnapToken($payload);
    }

    public function notificationHandler(Request $request)
    {
        try {
            $payload = $request->all();

            $orderIdSignature = $payload['order_id'] ?? $payload['machine_id'];
            $statusCode = $payload['status_code'];
            $grossAmount = $payload['gross_amount'];
            $serverKey = config('midtrans.server_key');

            $signature = hash('sha512', $orderIdSignature . $statusCode . $grossAmount . $serverKey);

            if ($signature !== $payload['signature_key']) {
                Log::warning('Midtrans notification signature mismatch.', ['order_id' => $orderIdSignature]);
                return response()->json(['error' => 'Invalid signature'], 403);
            }

            $transactionStatus = $payload['transaction_status'];
            $fraudStatus = $payload['fraud_status'];
            $midtransOrderId = $payload['order_id'] ?? $payload['machine_id'];

            if (str_starts_with($midtransOrderId, 'RENTAL-')) {
                $this->rentalNotificationHandler($request);
                return response()->json(['message' => 'Rental notification handled successfully']);
            }

            $orderIdToQuery = $midtransOrderId;
            if (str_contains($midtransOrderId, '-FINAL')) {
                $parts = explode('-FINAL', $midtransOrderId);
                $orderIdToQuery = $parts[0];
            }

            $order = Order::where('order_id', $orderIdToQuery)->first();

            if (($transactionStatus == 'capture' || $transactionStatus == 'settlement') && $fraudStatus == 'accept' && !$order) {
                $this->createOrderFromNotification($payload);
            } elseif ($order) {
                $this->updateOrderStatus($order, $transactionStatus, $fraudStatus, $midtransOrderId);
            }

            return response()->json(['message' => 'Notification handled successfully']);
        } catch (\Exception $e) {
            Log::error('Midtrans notification processing error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'An error occurred while handling the notification.'], 500);
        }
    }

    private function createOrderFromNotification($payload)
    {
        $customField = json_decode($payload['custom_field1'], true);

        Order::create([
            'order_id' => $payload['order_id'],
            'user_id' => $customField['user_id'],
            'order_type' => $customField['order_type'],
            'service_type' => $customField['service_type'],
            'weight' => $customField['weight'],
            'price' => $payload['gross_amount'],
            'pickup_address' => $customField['pickup_address'],
            'pickup_time' => $customField['pickup_time'],
            'branch_admin_id' => $customField['branch_admin_id'],
            'status' => 'pending', // Or any initial status you prefer
            'payment_status' => 'paid',
            'snap_token' => $payload['transaction_id'], // Store transaction_id for reference
        ]);
    }

    public function rentalNotificationHandler(Request $request)
    {
        try {
            $payload = $request->all();

            $orderIdSignature = $payload['order_id'];
            $statusCode = $payload['status_code'];
            $grossAmount = $payload['gross_amount'];
            $serverKey = config('midtrans.server_key');

            $signature = hash('sha512', $orderIdSignature . $statusCode . $grossAmount . $serverKey);

            if ($signature !== $payload['signature_key']) {
                Log::warning('Midtrans rental notification signature mismatch.', ['order_id' => $orderIdSignature]);
                return response()->json(['error' => 'Invalid signature'], 403);
            }

            $transactionStatus = $payload['transaction_status'];
            $fraudStatus = $payload['fraud_status'];
            $midtransOrderId = $payload['order_id'];

            $machineId = null;
            $rentalId = null;

            if (isset($payload['custom_field1'])) {
                $customField = json_decode($payload['custom_field1'], true);
                if (isset($customField['rental_id'])) {
                    $rentalId = $customField['rental_id'];
                }
            }

            if ($rentalId) {
                $rental = Rental::find($rentalId);
                if (!$rental) {
                    Log::warning('Rental record not found by ID.', [
                        'rental_id' => $rentalId,
                        'received_order_id' => $midtransOrderId,
                    ]);
                    return response()->json(['error' => 'Rental record not found.'], 404);
                }
                $machine = Machine::find($rental->machine_id);
            } else {
                // Fallback to old logic
                if (strpos($midtransOrderId, 'RENTAL-') === 0) {
                    $parts = explode('-', $midtransOrderId);
                    if (count($parts) >= 3) {
                        $machineId = $parts[1] . '-' . $parts[2];
                    }
                }

                if (!$machineId) {
                    Log::warning('Could not parse machine_id from Midtrans rental order_id.', [
                        'received_order_id' => $midtransOrderId,
                    ]);
                    return response()->json(['error' => 'Invalid order ID format for rental.'], 400);
                }

                $machine = Machine::where('machine_id', $machineId)->first();

                if (!$machine) {
                    Log::warning('Machine not found for Midtrans rental notification.', [
                        'received_order_id' => $midtransOrderId,
                    ]);
                    return response()->json(['error' => 'Machine not found.'], 404);
                }

                $rental = Rental::where('machine_id', $machine->id)->latest()->first();

                if (!$rental) {
                    Log::warning('Rental record not found for machine.', [
                        'machine_id' => $machine->id,
                        'received_order_id' => $midtransOrderId,
                    ]);
                    return response()->json(['error' => 'Rental record not found.'], 404);
                }
            }

            $this->updateMachineAndRentalStatus($machine, $rental, $transactionStatus, $fraudStatus);

            return response()->json(['message' => 'Rental notification handled successfully']);
        } catch (\Exception $e) {
            Log::error('Midtrans rental notification processing error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'An error occurred while handling the rental notification.'], 500);
        }
    }

    private function updateMachineAndRentalStatus(Machine $machine, Rental $rental, $transactionStatus, $fraudStatus)
    {
        if (($transactionStatus == 'capture' || $transactionStatus == 'settlement') && $fraudStatus == 'accept') {
            $machine->status = 'in_use';
            $machine->payment_status = 'paid';
            $machine->save();

            $rental->status = 'in_use';
            $rental->save();
        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            $machine->status = 'available';
            $machine->payment_status = 'unpaid';
            $machine->save();

            $rental->status = 'cancelled';
            $rental->save();
        }
    }

    private function updateOrderStatus(Order $order, $transactionStatus, $fraudStatus, $midtransOrderId = null)
    {
        // MIDTRANS ERROR FROM HERE
        if ($order->status == 'pending') {
            if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                $order->status = 'waiting_for_pickup';
                $order->payment_status = 'paid';
            } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                $order->payment_status = 'failed';
            }
        } else
        // END HERE
        {
            $isFinalPayment = $midtransOrderId && str_contains($midtransOrderId, '-FINAL');

            // Handle final payment or full upfront payment status
            if ($isFinalPayment) {
                if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                    if ($order->final_payment_method === 'deliver_to_customer') {
                        $order->status = 'Delivering!';
                    }
                    $order->payment_status = 'paid';
                } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                    $order->payment_status = 'failed';
                }
            }
        }

        $order->save();
    }

    public function checkAndUpdateStatus(Order $order)
    {
        try {
            $midtransOrderIdToCheck = $order->order_id;
            // If the initial payment is done, we check the status for the final payment.
            if ($order->payment_status === 'paid' && $order->status !== 'completed') {
                $midtransOrderIdToCheck .= '-FINAL';
            }

            $statusResponse = Transaction::status($midtransOrderIdToCheck);
            $this->updateOrderStatus($order, $statusResponse->transaction_status, $statusResponse->fraud_status ?? null, $statusResponse->order_id);
        } catch (\Exception $e) {
            Log::error('Failed to check and update Midtrans status', [
                'order_id' => $order->order_id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function checkTransactionStatus($orderId)
    {
        return \Midtrans\Transaction::status($orderId);
    }

    public function cancelTransaction($orderId)
    {
        $order = Order::findOrFail($orderId);

        if (!in_array($order->status, ['pending', 'challenge'])) {
            return response()->json([
                'status_message' => 'Order cannot be cancelled. Only pending or challenge orders can be cancelled.',
            ], 422);
        }

        try {
            $midtransResponse = Transaction::cancel($order->order_id);

            if ($midtransResponse && $midtransResponse) {
                $order->status = 'cancelled';
                $order->save();
                return response()->json([
                    'status_message' => 'Transaction cancelled successfully.'
                ]);
            }

            return response()->json([
                'status_message' => 'Failed to cancel transaction. Please try again later.'
            ], 500);

        } catch (\Exception $e) {
            Log::error('Midtrans cancel exception', [
                'order_id' => $order->order_id,
                'message' => $e->getMessage(),
            ]);

            // Check if the error indicates the transaction is already cancelled or cannot be found
            if (str_contains($e->getMessage(), '412')) {
                $order->status = 'cancelled';
                $order->save();
                return response()->json([
                    'status_message' => 'Transaction cancelled successfully.'
                ], 200);
            }

            return response()->json([
                'status_message' => 'An unexpected error occurred during cancellation.'
            ], 500);
        }
    }


}
