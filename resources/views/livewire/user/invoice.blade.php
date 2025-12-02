<div class="main-wrapper">
    <div class="container feature-main">
        <div class="welcome-section">
            <h1>🧾 Invoices & Receipts</h1>
            <p>Here is a list of your past invoices and receipts.</p>
        </div>

        <div class="table-container feature-card">
            <table>
                <thead>
                    <tr>
                        <th>Invoice ID</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td>#{{ $order->order_id }}</td>
                        <td>{{ $order->created_at->format('Y-m-d') }}</td>
                        <td>Rp {{ number_format($order->price, 0, ',', '.') }}</td>
                        <td><span class="badge badge-completed">{{ ucfirst($order->payment_status) }}</span></td>
                        <td>
                            <a href="{{ route('user.invoice.show', $order->id) }}" class="feature-btn"
                                style="padding: 0.5rem 1rem; font-size: 0.9rem; text-decoration: none; color: white;" target="_blank">
                                View Invoice
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center;">No invoices found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
