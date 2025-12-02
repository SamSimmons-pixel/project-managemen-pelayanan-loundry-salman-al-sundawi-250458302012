<div class="main-wrapper feature-main">
    <div class="container">
        <div class="welcome-section">
            <h1>⭐ Leave a Review</h1>
            <p>We value your feedback! Please select an order and share your experience with us.</p>
        </div>

        <div class="feature-card" style="max-width: 800px; margin: 0 auto;">
            <div class="feature-body">
                <form wire:submit.prevent="submitReview" id="review-form">
                    <div class="form-group">
                        <label for="order">Select Order</label>
                        <select id="order" wire:model.live="selectedOrder" required>
                            <option value="">-- Choose an order --</option>
                            @foreach ($orders as $order)
                                <option value="{{ $order->id }}">
                                    {{ $order->order_id }} - {{ $order->service_type }} ({{ $order->branchAdmin->name ?? 'Unknown Branch' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Rating</label>
                        <div style="display: flex; gap: 0.5rem; font-size: 2.5rem; color: var(--warning);">
                            @for ($i = 1; $i <= 5; $i++)
                                <span wire:click="setRating({{ $i }})" style="cursor: pointer;">
                                    @if ($rating >= $i)
                                        ★
                                    @else
                                        ☆
                                    @endif
                                </span>
                            @endfor
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="review">Review</label>
                        <textarea id="review" wire:model="comment" rows="5"
                            placeholder="Share your experience with our service..." required></textarea>
                    </div>

                    <button type="button" class="feature-btn" onclick="confirmSubmit()">Submit Review</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function confirmSubmit() {
        Swal.fire({
            title: 'Submit your review?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, submit it!'
        }).then((result) => {
            if (result.isConfirmed) {
                @this.dispatch('submitReview');
            }
        })
    }

    document.addEventListener('livewire:initialized', () => {
        @this.on('showSuccess', (event) => {
            Swal.fire(
                'Submitted!',
                event.message,
                'success'
            )
        });

        @this.on('showError', (event) => {
            Swal.fire(
                'Error!',
                event.message,
                'error'
            )
        });
    });
</script>
@endpush
