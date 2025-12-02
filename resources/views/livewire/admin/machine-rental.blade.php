<div>
    <style>
        .sortable-header {
            cursor: pointer;
        }

        .sortable-header:hover {
            background-color: #f0f0f0;
        }
    </style>

    <section id="machines" class="main-content content-section active">
        <div class="header">
            <h1>Washing Machine Management</h1>
            <div class="header-actions">
                <button class="btn btn-primary" onclick="openModal('machineModal')">+ Add Machine</button>
            </div>
        </div>

        <div class="card">
            <h2>Machine List</h2>
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th wire:click="sortBy('machine_id')" class="sortable-header">Machine ID @if ($sortField === 'machine_id')
                                    <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </th>
                            <th wire:click="sortBy('location')" class="sortable-header">Location @if ($sortField === 'location')
                                    <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </th>
                            <th wire:click="sortBy('status')" class="sortable-header">Status @if ($sortField === 'status')
                                    <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </th>
                            <th wire:click="sortBy('availability')" class="sortable-header">Availability @if ($sortField === 'availability')
                                    <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </th>
                            <th wire:click="sortBy('payment_status')" class="sortable-header">Payment Status
                                @if ($sortField === 'payment_status')
                                    <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($machines as $machine)
                            <tr>
                                <td>{{ $machine->machine_id }}</td>
                                <td>{{ $machine->location }}</td>
                                <td><span
                                        class="status-badge status-{{ strtolower(str_replace(' ', '-', $machine->status)) }}">{{ $machine->status == 'available' ? 'Unused' : 'In Use' }}</span>
                                </td>
                                <td>{{ $machine->availability }}</td>
                                <td><span
                                        class="status-badge status-{{ strtolower(str_replace(' ', '-', $machine->payment_status)) }}">{{ $machine->payment_status }}</span>
                                </td>
                                <td>
                                    <button class="btn btn-small btn-secondary"
                                        wire:click="editMachine({{ $machine->id }})">Edit</button>
                                    @if ($machine->payment_status === 'paid')
                                        <button type="button" class="btn btn-small btn-success"
                                            onclick="confirmFinish({{ $machine->id }})">Finish</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Add Machine Modal -->
    <div id="machineModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add New Machine</h2>
                <button class="close-btn" onclick="closeModal('machineModal')">&times;</button>
            </div>
            <form wire:submit.prevent="createMachine">
                <div class="form-group">
                    <label for="location">Location (Zone/Floor)</label>
                    <input type="text" id="location" wire:model="location"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        placeholder="e.g. Zone-A, Floor 2">
                </div>
                <div class="form-group">
                    <label for="availability">Availability</label>
                    <select id="availability" wire:model="availability">
                        <option value="">Select Availability</option>
                        <option value="available">Available</option>
                        <option value="unavailable">Unavailable</option>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Add Machine</button>
                    <button type="button" class="btn btn-secondary"
                        onclick="closeModal('machineModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    @if ($selectedMachine)
        <div id="editMachineModal" class="modal"
            style="display: block; position: fixed; width: 100%; height: 100%; top: 0; left: 0; background-color: rgba(0, 0, 0, 0.5); z-index: 1000; display: flex; justify-content: center; align-items: center;">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Edit Machine {{ $selectedMachine->machine_id }}</h2>
                    <button class="close-btn" wire:click="closeEditModal">&times;</button>
                </div>
                <form wire:submit.prevent="updateMachine">
                    <div class="form-group">
                        <label for="edit_availability">Availability</label>
                        <select id="edit_availability" wire:model="availability">
                            <option value="available">Available</option>
                            <option value="unavailable">Unavailable</option>
                        </select>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <button type="button" class="btn btn-secondary" wire:click="resetMachine">Reset</button>
                        <button type="button" class="btn btn-danger" style="margin-left: 20%;"
                            wire:click="deleteMachine">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('machineAdded', (event) => {
            closeModal('machineModal');
        });

        window.addEventListener('openEditModal', event => {
            openModal('editMachineModal');
        });

        window.addEventListener('closeEditModal', event => {
            closeModal('editMachineModal');
        });
    });

    function openModal(modalId) {
        document.getElementById(modalId).style.display = 'block';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    function confirmFinish(machineId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, finish it!'
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('finishMachine', machineId);
            }
        })
    }
</script>
