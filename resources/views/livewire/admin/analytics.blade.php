<div class="main-content">
    <div class="header">
        <h1>Analytics & Reports</h1>
    </div>

    <div class="dashboard-grid">
        <div class="stat-card">
            <h3>Total System Orders</h3>
            <div class="value">{{ $totalSystemOrders }}</div>
            <div class="change">Across all branches</div>
        </div>
        <div class="stat-card">
            <h3>Total System Revenue</h3>
            <div class="value">Rp {{ number_format($totalSystemRevenue, 0, ',', '.') }}</div>
            <div class="change">Across all branches</div>
        </div>
    </div>

    <div class="card">
        <h2>Branch Performance</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Branch Admin</th>
                        <th>Email</th>
                        <th>Total Orders</th>
                        <th>Active Orders</th>
                        <th>Total Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($branchAdmins as $admin)
                    <tr>
                        <td>{{ $admin['name'] }}</td>
                        <td>{{ $admin['email'] }}</td>
                        <td>{{ $admin['total_orders'] }}</td>
                        <td>{{ $admin['active_orders'] }}</td>
                        <td>Rp {{ number_format($admin['total_revenue'], 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
