<div class="main-content">
    <div class="header">
        <h1>Update Order Status</h1>
    </div>

    <div class="feature-card" style="background: var(--white); padding: 2rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);">
        <h2>Set Final Amount</h2>
        <p>For order #{{ $order->custom_order_id }}</p>

        <form wire:submit.prevent="updateOrder">
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="finalAmount" style="display: block; margin-bottom: 0.5rem; color: var(--gray-500);">Final Amount</label>
                <input type="number" id="finalAmount" wire:model="finalAmount" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid var(--gray-300); border-radius: 8px;">
                @error('finalAmount') <span class="text-danger" style="color: var(--danger); font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update Status & Set Amount</button>
        </form>
    </div>
</div>
