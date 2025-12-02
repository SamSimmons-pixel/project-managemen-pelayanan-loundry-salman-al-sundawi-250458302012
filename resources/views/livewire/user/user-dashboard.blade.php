<!-- Dashboard Modal -->
        <div id="dashboardModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>👤 My Dashboard</h2>
                    <button class="close-btn" onclick="closeModal('dashboardModal')">✕</button>
                </div>
                <div class="tabs">
                    <button class="tab-btn active" onclick="switchTab('dashTab1', this)">Profile</button>
                    <button class="tab-btn" onclick="switchTab('dashTab2', this)">History</button>
                    <button class="tab-btn" onclick="switchTab('dashTab3', this)">Settings</button>
                </div>
                <div id="dashTab1" class="tab-content active">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" value="{{ $user->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" value="{{ $user->email }}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <textarea readonly>{{ $user->address }}</textarea>
                    </div>
                </div>
                <div id="dashTab2" class="tab-content">
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Service</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $order->service_type }}</td>
                                        <td>Rp {{ number_format($order->price, 0, ',', '.') }}</td>
                                        <td>{{ ucfirst($order->status) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="dashTab3" class="tab-content">
                    <div class="form-group">
                        <label>
                            <input type="checkbox" checked> Email Notifications
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" checked> SMS Notifications
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox"> Marketing Emails
                        </label>
                    </div>
                    <button class="feature-btn">Save Settings</button>
                </div>
            </div>
        </div>
