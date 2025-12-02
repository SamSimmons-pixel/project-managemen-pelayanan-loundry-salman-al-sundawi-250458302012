<div class="main-wrapper">
    <div class="container">
        <div class="welcome-section feature-main">
            <h2>📦 Track Your Orders</h2>
            <p>Here is the current status of your orders.</p>
        </div>

        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <div class="feature-card" style="background: var(--bg-primary); padding: 2rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Order Type</th>
                            <th>Weight (kg)</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->custom_order_id }}</td>
                                <td>{{ $order->order_type }}</td>
                                <td>{{ $order->weight }}</td>
                                <td>{{ $order->status }}</td>
                                <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" wire:click="showDetails('{{ $order->custom_order_id }}')">View</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
