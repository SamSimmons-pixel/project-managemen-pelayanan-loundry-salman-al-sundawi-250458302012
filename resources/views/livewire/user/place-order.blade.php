<div class="main-wrapper">
    <div class="container">
        <div class="welcome-section feature-main">
            <h2>📋 Place New Order</h2>
            <p>Place your laundry pickup order here.</p>
        </div>

        <div class="feature-card" style="background: var(--bg-primary); padding: 2rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);">
            <div id="orderTab1" class="tab-content active">
                <form wire:submit.prevent="submitPickup">
                    <div class="form-group">
                        <label>Service Type</label>
                        <select wire:model="service_type" required>
                            <option value="">Select a service</option>
                            @foreach($packages as $package)
                                <option value="{{ $package->name }}">{{ $package->name }} - {{ $package->price_per_kg }}  /kg </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Weight (kg)</label>
                        <input type="number" wire:model="weight" placeholder="Enter weight" required>
                    </div>
                    <div class="form-group">
                        <label>Pickup Address</label>
                        <textarea wire:model="pickup_address" placeholder="Enter your address" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="branch_admin">Select Branch Admin</label>
                        <select id="branch_admin" class="form-control" wire:model="branch_admin_id">
                            <option value="">-- Select Branch Admin --</option>
                            @foreach($branchAdmins as $admin)
                                <option value="{{ $admin->id }}">{{ $admin->name }} - {{ $admin->address }}</option>
                            @endforeach
                        </select>
                        @error('branch_admin_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="pickup_time">Pickup Time</label>
                        <input type="datetime-local" id="pickup_time" class="form-control" wire:model="pickup_time">
                        @error('pickup_time') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="promo_code">Promo Code (Optional)</label>
                        <input type="text" id="promo_code" class="form-control" wire:model="promo_code" placeholder="Enter promo code">
                        @error('promo_code') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="feature-btn">Place Order</button>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- 
@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('snap-token-received', snapToken => {
            snap.pay(snapToken, {
                onSuccess: function(result) {
                    console.log('success');
                    console.log(result);
                    window.location.href = "{{ route('user.track-order') }}";
                },
                onPending: function(result) {
                    console.log('pending');
                    console.log(result);
                    window.location.href = "{{ route('user.track-order') }}";
                },
                onError: function(result) {
                    console.log('error');
                    console.log(result);
                },
                onClose: function() {
                    console.log('customer closed the popup without finishing the payment');
                }
            });
        });
    });
</script>
@endpush --}}
