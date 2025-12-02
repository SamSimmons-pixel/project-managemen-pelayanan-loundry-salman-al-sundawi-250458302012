<div class="main-wrapper">
    <div class="container">
        <div class="welcome-section feature-main">
            <h2>💳 Payment</h2>
            <p>Complete your payment for Order #{{ $order->id }}</p>
        </div>

        <div class="feature-card" style="background: var(--bg-primary); padding: 2rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);">
            <div class="payment-details">
                <p><strong>Service Type:</strong> {{ $order->service_type }}</p>
                <p><strong>Weight:</strong> {{ $order->weight }} kg</p>
                <p><strong>Total Price:</strong> Rp{{ number_format($order->price, 2) }}</p>
            </div>

            <div class="payment-actions">
                <button id="pay-button" class="feature-btn">Pay Now</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function(){
        // SnapToken acquired from previous step
        snap.pay('{{ $snapToken }}', {
            // Optional
            onSuccess: function(result){
                /* You may add your own implementation here */
                // alert("payment success!");

            },
            // Optional
            onPending: function(result){
                /* You may add your own implementation here */
                // alert("wating your payment!");
            },
            // Optional
            onError: function(result){
                /* You may add your own implementation here */
                // alert("payment failed!");
            }
        });
    };
</script>
@endpush
