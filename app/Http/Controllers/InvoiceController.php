<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function show(Order $order)
    {
        // Ensure the user owns the order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('user.invoice.show', compact('order'));
    }
}
