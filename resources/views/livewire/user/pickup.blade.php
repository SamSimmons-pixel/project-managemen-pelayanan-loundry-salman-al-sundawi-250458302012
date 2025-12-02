<div class="main-wrapper">
    <div class="container">
        <div class="feature-card" style="background: var(--bg-primary); padding: 2rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);">
            <h1 style="text-align: center; font-size: 1.8rem; font-weight: 600; margin-bottom: 1rem;">Choose Your Pickup Method</h1>
            <p style="text-align: center; color: #666; margin-bottom: 2rem;">Please select how you would like to receive your laundry.</p>
            <div class="pickup-options">
                <div class="pickup-option">
                    <h2>Pay at Laundry & Self-Pickup</h2>
                    <p>Collect your laundry from our store and pay at the counter.</p>
                    <a href="#" wire:click.prevent="setPaymentOption('offline')" class="btn btn-offline">
                        Select
                    </a>
                </div>
                <div class="pickup-option">
                    <h2>Pay Online & Home Delivery</h2>
                    <p>Have your laundry delivered to your doorstep after paying online.</p>
                    <a href="#" wire:click.prevent="setPaymentOption('online')" class="btn btn-online">
                        Select
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
