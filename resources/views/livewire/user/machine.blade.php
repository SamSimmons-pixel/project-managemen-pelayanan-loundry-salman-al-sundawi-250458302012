<div class="main-wrapper">
    <div class="container">
        <div class="welcome-section feature-main">
            <h2>🔧 Available Washing Machines</h2>
            <p>For each machine is 10k for first payment</p>
            <br>
            <p>Important: Second payment is based on your loundry weight in the cashier</p>
        </div>

        @foreach ($groupedMachines as $branchAdminId => $machines)
            <div class="feature-card" style="background: var(--bg-primary); padding: 1.5rem; margin-bottom: 2rem">
                <h3 style="margin-bottom: 1.5rem; color: var(--text-primary); font-size: 1.25rem;">
                    📍 Branch: {{ $machines->first()->branchAdmin ? $machines->first()->branchAdmin->name . ' - Address: ' . $machines->first()->branchAdmin->address : 'Unassigned' }}
                </h3>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Machine ID</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($machines as $machine)
                                <tr>
                                    <td>{{ $machine->machine_id }}</td>
                                    <td>{{ $machine->location }}</td>
                                    <td>
                                        @if ($machine->status == 'available')
                                            <span class="badge badge-available">Available</span>
                                        @elseif ($machine->status == 'pending')
                                            <span class="badge badge-pending">Pending</span>
                                        @elseif ($machine->status == 'unpaid')
                                            <span class="badge badge-unavailable">Unpaid</span>
                                        @else
                                            <span class="badge badge-unavailable">In Use</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($machine->status == 'available')
                                            <button class="feature-btn" wire:click="rentMachine({{ $machine->id }})" style="padding: 0.5rem 1rem; font-size: 0.9rem;">Rent</button>
                                        @elseif ($machine->status == 'in_use')
                                            @if (in_array($machine->id, $userRentals))
                                                <div style="display: flex; gap: 0.5rem;">
                                                    <button class="feature-btn" style="padding: 0.5rem 1rem; font-size: 0.9rem; opacity: 0.5;" disabled>Rent</button>
                                                    <button class="feature-btn" onclick="confirmFinishRental({{ $machine->id }})" style="background-color: #007bff; padding: 0.5rem 1rem; font-size: 0.9rem;">Finish</button>
                                                </div>
                                            @else
                                                <button class="feature-btn" style="padding: 0.5rem 1rem; font-size: 0.9rem; opacity: 0.5;" disabled>Rent</button>
                                            @endif
                                        @else
                                            <div style="display: flex; gap: 0.5rem;">
                                                <button class="feature-btn" style="padding: 0.5rem 1rem; font-size: 0.9rem; opacity: 0.5;" disabled>Rent</button>
                                                <button class="feature-btn" wire:click="cancelRental({{ $machine->id }})" style="background-color: #dc3545; padding: 0.5rem 1rem; font-size: 0.9rem;">Cancel</button>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
</div>

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    window.confirmFinishRental = function(machineId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Have you finished your laundry?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#007bff',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, finish it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('finishRental', { machineId: machineId });
            }
        });
    }

    document.addEventListener('livewire:init', () => {
        Livewire.on('openMidtransSnap', (snapToken) => {
            console.log('Received Snap Token:', snapToken);
            snap.pay(snapToken[0], {
                onSuccess: function(result) {
                    console.log('success');
                    console.log(result);
                    Livewire.dispatch('payment-success');
                    location.reload();
                },
                onPending: function(result) {
                    console.log('pending');
                    console.log(result);
                    location.reload();
                },
                onError: function(result) {
                    console.log('error');
                    console.log(result);
                    location.reload();
                },
                onClose: function() {
                    console.log('customer closed the popup without finishing the payment');
                    location.reload();
                }
            });
        });

        Livewire.on('rental-finished', () => {
            Swal.fire({
                title: 'Success!',
                text: 'Thanks for renting! Please go to cashier for The Laundry payment',
                icon: 'success',
                confirmButtonText: 'OK',
                confirmButtonColor: '#007bff'
            }).then(() => {
                location.reload();
            });
        });
    });
</script>
@endpush
