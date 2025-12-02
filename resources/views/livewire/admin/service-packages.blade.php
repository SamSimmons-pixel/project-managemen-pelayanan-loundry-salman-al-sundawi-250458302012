<div class="main-content">
    <section id="packages" class="content-section active">
        <div class="header">
            <h1>Service Packages</h1>
            <div class="header-actions">
                <button class="btn btn-primary" onclick="openModal('createPackageModal')" wire:click="resetInputFields">+ New Package</button>
            </div>
        </div>

        <div class="card">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Package Name</th>
                            <th>Description</th>
                            <th>Price / Kg</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($packages as $package)
                        <tr>
                            <td>{{ $package->name }}</td>
                            <td>{{ $package->description }}</td>
                            <td>Rp {{ number_format($package->price_per_kg, 0, ',', '.') }}</td>
                            <td>
                                <span class="status-badge {{ $package->status === 'Active' ? 'status-completed' : 'status-pending' }}">
                                    {{ $package->status }}
                                </span>
                            </td>
                            <td><button class="btn btn-small btn-secondary" wire:click="edit({{ $package->id }})">Edit</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Create Package Modal -->
    <div id="createPackageModal" class="modal" wire:ignore.self>
        <div class="modal-content">
            <div class="modal-header">
                <h2>Create Service Package</h2>
                <button class="close-btn" onclick="closeModal('createPackageModal')">&times;</button>
            </div>
            <form wire:submit.prevent="store">
                <div class="form-group">
                    <label>Package Name</label>
                    <input type="text" wire:model="name" placeholder="e.g., Express Wash" required>
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea wire:model="description" placeholder="Package description..." rows="3" required></textarea>
                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Price / Kg (Rp)</label>
                        <input type="number" wire:model="price_per_kg" placeholder="0" required>
                        @error('price_per_kg') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select wire:model="status" required>
                            <option value="Active">Active</option>
                            <option value="Unactive">Unactive</option>
                        </select>
                        @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">Create Package</button>
            </form>
        </div>
    </div>

    <!-- Modal (kept for future implementation as requested) -->
    <!-- Edit Package Modal -->
    <div id="editPackageModal" class="modal" wire:ignore.self>
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Service Package</h2>
                <button class="close-btn" onclick="closeModal('editPackageModal')">&times;</button>
            </div>
            <form wire:submit.prevent="update">
                <div class="form-group">
                    <label>Package Name</label>
                    <input type="text" wire:model="name" required>
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea wire:model="description" rows="3" required></textarea>
                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Price / Kg (Rp)</label>
                        <input type="number" wire:model="price_per_kg" required>
                        @error('price_per_kg') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select wire:model="status" required>
                            <option value="Active">Active</option>
                            <option value="Unactive">Unactive</option>
                        </select>
                        @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="form-row" style="margin-top: 1rem;">
                    <button type="button" class="btn btn-danger" onclick="confirmDeletePackage({{ $selectedPackageId }})">Delete</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts for Modal and SweetAlert -->
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('open-create-modal', () => {
                document.getElementById('createPackageModal').style.display = 'flex';
            });

            Livewire.on('close-create-modal', () => {
                document.getElementById('createPackageModal').style.display = 'none';
            });

            Livewire.on('open-edit-modal', () => {
                document.getElementById('editPackageModal').style.display = 'flex';
            });

            Livewire.on('close-edit-modal', () => {
                document.getElementById('editPackageModal').style.display = 'none';
            });

            Livewire.on('swal:success', (data) => {
                Swal.fire({
                    title: data[0].title,
                    text: data[0].text,
                    icon: 'success',
                    confirmButtonColor: '#B85C75'
                });
            });

            window.confirmDeletePackage = (id) => {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#EF4444',
                    cancelButtonColor: '#A8A6A7',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('delete', id);
                    }
                });
            };
        });
    </script>
</div>
