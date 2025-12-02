<div>

    <head>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            :root {
                --primary: #B85C75;
                --primary-light: #E8D5DC;
                --primary-dark: #8B4A5F;
                --white: #FFFFFF;
                --gray-50: #F9F7F8;
                --gray-100: #F3F1F2;
                --gray-200: #E8E6E7;
                --gray-300: #D4D2D3;
                --gray-400: #A8A6A7;
                --gray-500: #7C7A7B;
                --success: #10B981;
                --warning: #F59E0B;
                --danger: #EF4444;
                --info: #3B82F6;
            }

            body {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
                background-color: var(--gray-50);
                color: var(--gray-500);
            }

            .admin-container {
                display: flex;
                min-height: 100vh;
            }

            /* Sidebar Navigation */
            .sidebar {
                width: 280px;
                background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
                color: var(--white);
                padding: 2rem 0;
                position: fixed;
                height: 100vh;
                overflow-y: auto;
                box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            }

            .sidebar-header {
                padding: 0 1.5rem 2rem;
                border-bottom: 2px solid rgba(255, 255, 255, 0.2);
                margin-bottom: 1.5rem;
            }

            .sidebar-logo {
                font-size: 1.5rem;
                font-weight: 700;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .sidebar-menu {
                list-style: none;
            }

            .sidebar-menu li {
                margin: 0.5rem 0;
            }

            .sidebar-menu button {
                width: 100%;
                background: none;
                border: none;
                color: rgba(255, 255, 255, 0.8);
                padding: 0.75rem 1.5rem;
                text-align: left;
                cursor: pointer;
                font-size: 0.95rem;
                transition: all 0.3s ease;
                display: flex;
                align-items: center;
                gap: 0.75rem;
            }

            .sidebar-menu button:hover {
                background-color: rgba(255, 255, 255, 0.1);
                color: var(--white);
                padding-left: 2rem;
            }

            .sidebar-menu button.active {
                background-color: rgba(255, 255, 255, 0.2);
                color: var(--white);
                border-left: 4px solid var(--white);
                padding-left: 1.25rem;
            }

            /* Main Content */
            .main-content {
                margin-left: 280px;
                flex: 1;
                padding: 2rem;
            }

            .header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 2rem;
                background: var(--white);
                padding: 1.5rem;
                border-radius: 12px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            }

            .header h1 {
                font-size: 1.75rem;
                color: var(--primary);
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
                background-color: var(--primary);
                color: var(--white);
            }

            .btn-primary:hover {
                background-color: var(--primary-dark);
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(184, 92, 117, 0.3);
            }

            .btn-secondary {
                background-color: var(--gray-200);
                color: var(--gray-500);
            }

            .btn-secondary:hover {
                background-color: var(--gray-300);
            }

            .btn-success {
                background-color: var(--success);
                color: var(--white);
            }

            .btn-danger {
                background-color: var(--danger);
                color: var(--white);
            }

            .btn-small {
                padding: 0.5rem 1rem;
                font-size: 0.85rem;
            }

            /* Dashboard Grid */
            .dashboard-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 1.5rem;
                margin-bottom: 2rem;
            }

            .stat-card {
                background: var(--white);
                padding: 1.5rem;
                border-radius: 12px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
                border-left: 4px solid var(--primary);
            }

            .stat-card h3 {
                color: var(--gray-400);
                font-size: 0.85rem;
                text-transform: uppercase;
                margin-bottom: 0.5rem;
            }

            .badge {
                padding: 0.5em 0.75em;
                border-radius: 0.25rem;
                font-weight: 600;
                font-size: 0.75rem;
                text-transform: uppercase;
            }

            .badge-paid,
            .badge-completed {
                background-color: #28a745;
                color: white;
            }

            .badge-delivering {
                background-color: #007bff;
                color: white;
            }

            .badge-ready-for-pickup,
            .badge-washing {
                background-color: #DBEAFE;
                color: #1E40AF;
            }

            .badge-pending,
            .badge-waiting-for-pickup,
            .badge-waiting-for-booking-fee {
                background-color: #FEF3C7;
                color: #92400E;
            }

            .badge-cancelled,
            .badge-failed,
            .badge-expired {
                background-color: #FEE2E2;
                color: #991B1B;
            }

            /* Modal Styles */
            .custom-modal-backdrop {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 9999;
            }

            .custom-modal {
                background-color: var(--white);
                border-radius: 12px;
                width: 90%;
                max-width: 500px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
                animation: slideIn 0.3s ease;
                position: relative;
                z-index: 10000;
            }

            .custom-modal-header {
                padding: 1.5rem;
                border-bottom: 1px solid var(--gray-200);
            }

            .custom-modal-header h3 {
                color: var(--primary);
                margin: 0;
            }

            .custom-modal-body {
                padding: 1.5rem;
            }

            .custom-modal-footer {
                padding: 1.5rem;
                border-top: 1px solid var(--gray-200);
                display: flex;
                justify-content: flex-end;
                gap: 1rem;
            }

            .form-control {
                width: 100%;
                padding: 0.75rem;
                border: 1px solid var(--gray-300);
                border-radius: 8px;
                margin-top: 0.5rem;
                font-size: 1rem;
            }

            @keyframes slideIn {
                from {
                    transform: translateY(-20px);
                    opacity: 0;
                }
                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }
        </style>
    </head>

        <div class="main-content">
        <div class="header">
            <h1>Order Management</h1>
        </div>

        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>User</th>
                        <th>Address</th>
                        <th>Service</th>
                        <th>Weight</th>
                        <th>Promo Code</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->order_id }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->pickup_address }}</td>
                            <td>{{ $order->service_type }}</td>
                            <td>{{ $order->weight }}</td>
                            <td>
                                @if($order->promo_code)
                                    {{ $order->promo_code }}
                                    @if($order->promo)
                                        ({{ $order->promo->discount_percentage }}%)
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if(is_null($order->price))
                                    Rp{{ number_format($order->approximate_price, 2) }} (Approx.)
                                @else
                                    Rp{{ number_format($order->price, 2) }}
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-{{ str_replace('_', '-', $order->status) }}">
                                        @if ($order->status == 'waiting_for_pickup' || $order->status == 'waiting_for_booking_fee')
                                            Pick the Loundry!
                                        @elseif ($order->status == 'completed')
                                            Completed
                                        @elseif ($order->status == 'delivering' || $order->status == 'Delivering!')
                                            <span class="badge badge-delivering">🚚 Delivering!</span>
                                        @elseif ($order->status == 'unpaid')
                                            <span class="badge badge-pending">Pending</span>
                                        @else
                                            {{ str_replace('_', ' ', $order->status) }}
                                        @endif
                                </span>
                            </td>
                            <td>
                                @if ($order->status == 'waiting_for_pickup' || $order->status == 'waiting_for_booking_fee')
                                    <button wire:click="updateStatusToWashing({{ $order->id }})" class="btn btn-primary btn-small">Set to Washing</button>
                                @elseif ($order->status == 'washing')
                                    <button wire:click="showUpdateForm({{ $order->id }})" class="btn btn-success btn-small">Cleaned</button>
                                @elseif ($order->status == 'Delivering!')
                                    <button wire:click="finishOrder({{ $order->id }})" class="btn btn-success btn-small">Finish Order</button>
                                @elseif ($order->status == 'unpaid')
                                    <button wire:click="finishOrder({{ $order->id }})" class="btn btn-success btn-small">Finish Order</button>
                                @elseif ($order->status == 'completed')
                                    <button wire:click="openEditModal({{ $order->id }})" class="btn btn-secondary btn-small">Edit finished loundry</button>
                                @endif
                            </td>
                        </tr>
                        @if ($selectedOrderId === $order->id)
                            <tr>
                                <td colspan="7">
                                    @livewire('admin.update-order-status', ['order' => $order], key($order->id))
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($showConfirmationModal)
            <div class="custom-modal-backdrop">
                <div class="custom-modal">
                    <div class="custom-modal-header">
                        <h3>Confirm Delivery</h3>
                    </div>
                    <div class="custom-modal-body">
                        <p>Are you sure the loundry was already been Delivered?</p>
                    </div>
                    <div class="custom-modal-footer">
                        <button wire:click="updateStatusToCompleted" class="btn btn-success">Yes, it has been delivered</button>
                        <button wire:click="$set('showConfirmationModal', false)" class="btn btn-secondary">Cancel</button>
                    </div>
                </div>
            </div>
        @endif

        @if ($showEditModal)
            <div class="custom-modal-backdrop">
                <div class="custom-modal">
                    <div class="custom-modal-header">
                        <h3>Edit Finished Loundry</h3>
                    </div>
                    <div class="custom-modal-body">
                        <label for="status">Status</label>
                        <select wire:model="status" id="status" class="form-control">
                            <option value="completed">Completed</option>
                            <option value="ready_for_pickup">Ready for Pickup</option>
                            <option value="delivering">Delivering</option>
                            <option value="washing">Washing</option>
                        </select>
                    </div>
                    <div class="custom-modal-footer">
                        <button wire:click="updateOrderStatus" class="btn btn-primary">Update Status</button>
                        <button wire:click="$set('showEditModal', false)" class="btn btn-secondary">Cancel</button>
                    </div>
                </div>
            </div>
        @endif

        <div class="pagination-container">
            {{ $orders->links() }}
        </div>
    </div>
</div>
