<div class="main-wrapper">
    <div class="container">
        <div class="welcome-section feature-main">
            <h2>📍 Track Your Orders</h2>
            <p>Here is the current status of your orders.</p>
        </div>

        <style>
            .badge {
                padding: 5px 10px;
                border-radius: 15px;
                font-size: 0.8em;
                color: white;
                text-align: center;
            }
            .badge-paid, .badge-completed, .badge-delivering {
                background-color: #28a745;
                color: white;
            }
            .badge-ready-for-pickup, .badge-washing {
                background-color: #17a2b8;
            }
            .badge-pending, .badge-waiting-for-pickup, .badge-waiting-for-booking-fee {
                background-color: #ffc107;
                color: #212529;
            }
            .badge-cancelled, .badge-failed, .badge-expired, .badge-unpaid {
                background-color: #dc3545;
            }
        </style>

        <div class="feature-card" style="background: var(--bg-primary); padding: 2rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);">
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Service Type</th>
                            <th>Weight (kg)</th>
                            <th>Total Price</th>
                            <th>Address</th>
                            <th>Branch</th>
                            <th>Promo Code</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td>#{{ $order->order_id }}</td>
                                <td>{{ $order->service_type }}</td>
                                <td>{{ $order->weight }}</td>
                                <td>
                                    @if(is_null($order->price))
                                        Rp{{ number_format($order->approximate_price, 2) }} (Approx.)
                                    @else
                                        Rp{{ number_format($order->price, 2) }}
                                    @endif
                                </td>
                                <td>{{ $order->pickup_address }}</td>
                                <td>{{ $order->branch_admin_id ? $order->branchAdmin->name : 'N/A' }}</td>
                                <td>{{ $order->promo_code ? $order->promo_code . ' (' . $order->discount_percentage . '%)' : '-' }}</td>
                                <td>
                                     @if($order->status == 'waiting_for_booking_fee')
                                         <span class="badge badge-waiting-for-pickup">Waiting for Pickup</span>
                                     @elseif($order->status == 'unpaid')
                                         <span class="badge badge-pending">Unpaid</span>
                                     @elseif($order->status == 'delivering' || $order->status == 'Delivering!')
                                         <span class="badge badge-delivering">🚚 Delivering!</span>
                                     @elseif($order->status == 'completed')
                                         <span class="badge badge-completed">Completed</span>
                                     @else
                                        <span class="badge badge-{{ str_replace('_', '-', strtolower($order->status)) }}">{{ ucwords(str_replace('_', ' ', $order->status)) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="display: flex; gap: 8px; align-items: center;">
                                        @if ($order->status == 'pending')
                                            <button wire:click="payBookingFee({{ $order->id }})" class="feature-btn">Pay</button>
                                            <button wire:click="checkOrderStatus({{ $order->id }})" class="feature-btn">Refresh</button>
                                            <span class="countdown" data-created-at="{{ $order->created_at }}"></span>
                                        @elseif ($order->status == 'waiting_for_booking_fee')

                                            <button wire:click="cancelOrder({{ $order->id }})" class="feature-btn btn-danger">Cancel</button>
                                        @elseif ($order->status == 'waiting_for_pickup')
                                            <button wire:click="cancelOrder({{ $order->id }})" class="feature-btn btn-danger">Cancel</button>
                                            <button wire:click="checkOrderStatus({{ $order->id }})" class="feature-btn">Refresh</button>
                                        @elseif ($order->status == 'washing')
                                            <button wire:click="checkOrderStatus({{ $order->id }})" class="feature-btn">Refresh</button>
                                        @elseif ($order->status == 'ready_for_pickup')
                                            <a href="{{ route('pickup', ['orderId' => $order->id]) }}" class="feature-btn">Choose Pickup method</a>
                                            <button wire:click="checkOrderStatus({{ $order->id }})" class="feature-btn">Refresh</button>
                                        @else
                                            <button wire:click="checkOrderStatus({{ $order->id }})" class="feature-btn">Refresh</button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center">No orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 1rem;">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:load', function () {
        const countdowns = document.querySelectorAll('.countdown');

        countdowns.forEach(countdown => {
            const createdAt = new Date(countdown.dataset.createdAt).getTime();
            const fiveMinutes = 5 * 60 * 1000;

            const interval = setInterval(() => {
                const now = new Date().getTime();
                const distance = createdAt + fiveMinutes - now;

                if (distance < 0) {
                    clearInterval(interval);
                    countdown.innerHTML = "Timeout";
                    const payButton = countdown.previousElementSibling;
                    if (payButton && payButton.tagName === 'BUTTON') {
                        payButton.disabled = true;
                    }
                    return;
                }

                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                countdown.innerHTML = `${minutes}m ${seconds}s`;
            }, 1000);
        });
    });
</script>
@endpush
