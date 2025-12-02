<div class="main-content">
    <head>
        <style>
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        transition: transform 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
    }

    .icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .stat-content h3 {
        color: #6b7280;
        font-size: 0.875rem;
        font-weight: 500;
        margin: 0 0 0.5rem 0;
    }

    .stat-content .value {
        color: #111827;
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 0.25rem;
    }

    .stat-content .change {
        color: #9ca3af;
        font-size: 0.875rem;
    }

    .card {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    </style>
    </head>
    
    <div class="header">
        <h1>Branch Analytics</h1>
        <p class="text-muted">Overview of current branch performance</p>
    </div>

    <div class="dashboard-grid">
        <div class="stat-card">
            <div class="icon-wrapper" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <div class="stat-content">
                <h3>Total Orders</h3>
                <div class="value">{{ $totalOrders }}</div>
                <div class="change">Lifetime orders</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="icon-wrapper" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                <i class="fas fa-wallet"></i>
            </div>
            <div class="stat-content">
                <h3>Total Revenue</h3>
                <div class="value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                <div class="change">Lifetime revenue</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="icon-wrapper" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <h3>Active Orders</h3>
                <div class="value">{{ $activeOrders }}</div>
                <div class="change">Currently in progress</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="icon-wrapper" style="background: rgba(99, 102, 241, 0.1); color: #6366f1;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <h3>Completed Orders</h3>
                <div class="value">{{ $completedOrders }}</div>
                <div class="change">Successfully delivered</div>
            </div>
        </div>
    </div>

    <div class="card" style="margin-top: 2rem;">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h2>Monthly Revenue ({{ now()->year }})</h2>
        </div>
        <div class="chart-container" style="position: relative; height: 300px; width: 100%;">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('livewire:navigated', function () {
        initChart();
    });

    // Also init on first load
    document.addEventListener('DOMContentLoaded', function () {
        initChart();
    });

    function initChart() {
        const ctx = document.getElementById('revenueChart');
        if (!ctx) return;

        // Destroy existing chart if it exists to prevent duplicates
        if (window.myRevenueChart) {
            window.myRevenueChart.destroy();
        }

        const monthlyRevenue = @json($monthlyRevenue);

        window.myRevenueChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Revenue (Rp)',
                    data: monthlyRevenue,
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            callback: function(value, index, values) {
                                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumSignificantDigits: 3 }).format(value);
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }
</script>


