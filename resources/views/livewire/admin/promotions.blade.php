<div class="main-content">
    <head>
        <style>
            .header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 2rem;
                background: #FFFFFF;
                padding: 1.5rem;
                border-radius: 12px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            }

            .header h1 {
                font-size: 1.75rem;
                color: #B85C75;
            }

            .header-actions {
                display: flex;
                gap: 1rem;
                align-items: center;
            }

            .btn {
                padding: 0.75rem 1.5rem;
                border: none;
                border-radius: 8px;
                cursor: pointer;
                font-size: 0.95rem;
                font-weight: 500;
                transition: all 0.3s ease;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
            }

            .btn-primary {
                background-color: #B85C75;
                color: #FFFFFF;
            }

            .btn-primary:hover {
                background-color: #8B4A5F;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(184, 92, 117, 0.3);
            }

            .card {
                background: #FFFFFF;
                border-radius: 12px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
                padding: 1.5rem;
                margin-bottom: 1.5rem;
            }

            .card h2 {
                color: #B85C75;
                margin-bottom: 1.5rem;
                font-size: 1.25rem;
            }

            .table-container {
                overflow-x: auto;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th {
                background-color: #F3F1F2;
                color: #7C7A7B;
                padding: 1rem;
                text-align: left;
                font-weight: 600;
                font-size: 0.85rem;
                text-transform: uppercase;
                border-bottom: 2px solid #E8E6E7;
            }

            td {
                padding: 1rem;
                border-bottom: 1px solid #E8E6E7;
                color: #7C7A7B;
            }

            tr:hover {
                background-color: #F9F7F8;
            }

            .status-badge {
                display: inline-block;
                padding: 0.4rem 0.8rem;
                border-radius: 20px;
                font-size: 0.8rem;
                font-weight: 600;
                cursor: pointer;
            }

            .status-active {
                background-color: #DCFCE7;
                color: #166534;
            }

            .status-inactive {
                background-color: #FEE2E2;
                color: #991B1B;
            }

            /* Modal */
            .modal {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 1000;
                align-items: center;
                justify-content: center;
            }

            .modal.active {
                display: flex;
            }

            .modal-content {
                background: #FFFFFF;
                border-radius: 12px;
                padding: 2rem;
                max-width: 500px;
                width: 90%;
                max-height: 90vh;
                overflow-y: auto;
                box-shadow: 0 20px 25px rgba(0, 0, 0, 0.15);
            }

            .modal-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 1.5rem;
            }

            .modal-header h2 {
                color: #B85C75;
            }

            .close-btn {
                background: none;
                border: none;
                font-size: 1.5rem;
                cursor: pointer;
                color: #A8A6A7;
            }

            .form-group {
                margin-bottom: 1.5rem;
            }

            label {
                display: block;
                margin-bottom: 0.5rem;
                color: #7C7A7B;
                font-weight: 500;
                font-size: 0.9rem;
            }

            input {
                width: 100%;
                padding: 0.75rem;
                border: 1px solid #D4D2D3;
                border-radius: 8px;
                font-size: 0.95rem;
                font-family: inherit;
                transition: border-color 0.3s ease;
            }

            input:focus {
                outline: none;
                border-color: #B85C75;
                box-shadow: 0 0 0 3px rgba(184, 92, 117, 0.1);
            }

            .error-message {
                color: #EF4444;
                font-size: 0.85rem;
                margin-top: 0.25rem;
            }
        </style>
    </head>

    <div class="header">
        <h1>Promos & Discounts</h1>
        <div class="header-actions">
            <button class="btn btn-primary" onclick="openModal('promoModal')">+ New Promo</button>
        </div>
    </div>

    <div class="card">
        <h2>Active Promotions</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Promo Code</th>
                        <th>Discount</th>
                        <th>Valid Until</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($promos as $promo)
                    <tr>
                        <td>{{ $promo->code }}</td>
                        <td>{{ $promo->discount_percentage }}%</td>
                        <td>{{ $promo->valid_until }}</td>
                        <td>
                            <span wire:click="toggleStatus({{ $promo->id }})" 
                                  class="status-badge {{ $promo->is_active ? 'status-active' : 'status-inactive' }}">
                                {{ $promo->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <button wire:click="delete({{ $promo->id }})" class="btn btn-small btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div id="promoModal" class="modal" wire:ignore.self>
        <div class="modal-content">
            <div class="modal-header">
                <h2>Create New Promo</h2>
                <button class="close-btn" onclick="closeModal('promoModal')">&times;</button>
            </div>
            <form wire:submit.prevent="store">
                <div class="form-group">
                    <label>Promo Code</label>
                    <input type="text" wire:model="code" placeholder="e.g., FRESH20" required>
                    @error('code') <span class="error-message">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Discount Percentage</label>
                    <input type="number" wire:model="discount_percentage" placeholder="e.g., 20" required>
                    @error('discount_percentage') <span class="error-message">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Valid Until</label>
                    <input type="date" wire:model="valid_until" required>
                    @error('valid_until') <span class="error-message">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">Create Promo</button>
            </form>
        </div>
    </div>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.add('active');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
        }

        window.addEventListener('close-modal', event => {
            closeModal('promoModal');
        });
    </script>
</div>
