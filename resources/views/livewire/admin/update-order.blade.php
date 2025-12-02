<div class="main-wrapper">
    <div class="container">
        <div class="welcome-section feature-main">
            <h2>Update Order #{{ $order->custom_order_id }}</h2>
            <p>Enter the final amount for this order.</p>
        </div>

        <div class="feature-card" style="background: var(--bg-primary); padding: 2rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);">
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            <form wire:submit.prevent="updateOrder">
                <div class="form-group">
                    <label for="final_amount">Final Amount</label>
                    <input type="number" id="final_amount" wire:model="final_amount" class="form-control">
                    @error('final_amount') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="feature-btn">Update Order</button>
            </form>
        </div>
    </div>
</div>
