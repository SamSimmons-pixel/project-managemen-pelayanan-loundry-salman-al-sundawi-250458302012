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

            .date-display {
                padding: 0.75rem 1.5rem;
                border-radius: 8px;
                font-size: 0.95rem;
                font-weight: 500;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                background-color: var(--gray-200);
                color: var(--gray-500);
                cursor: default;
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

            .stat-card .value {
                font-size: 2rem;
                font-weight: 700;
                color: var(--primary);
            }

            .stat-card .change {
                font-size: 0.85rem;
                color: var(--success);
                margin-top: 0.5rem;
            }

            /* Content Sections */
            .content-section {
                display: none;
            }

            .content-section.active {
                display: block;
            }

            .card {
                background: var(--white);
                border-radius: 12px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
                padding: 1.5rem;
                margin-bottom: 1.5rem;
            }

            .card h2 {
                color: var(--primary);
                margin-bottom: 1.5rem;
                font-size: 1.25rem;
            }

            /* Tables */
            .table-container {
                overflow-x: auto;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th {
                background-color: var(--gray-100);
                color: var(--gray-500);
                padding: 1rem;
                text-align: left;
                font-weight: 600;
                font-size: 0.85rem;
                text-transform: uppercase;
                border-bottom: 2px solid var(--gray-200);
            }

            td {
                padding: 1rem;
                border-bottom: 1px solid var(--gray-200);
            }

            tr:hover {
                background-color: var(--gray-50);
            }

            .status-badge {
                display: inline-block;
                padding: 0.4rem 0.8rem;
                border-radius: 20px;
                font-size: 0.8rem;
                font-weight: 600;
            }

            .status-pending {
                background-color: #FEF3C7;
                color: #92400E;
            }

            .status-processing {
                background-color: #DBEAFE;
                color: #1E40AF;
            }

            .status-completed {
                background-color: #DCFCE7;
                color: #166534;
            }

            .status-cancelled {
                background-color: #FEE2E2;
                color: #991B1B;
            }

            /* Forms */
            .form-group {
                margin-bottom: 1.5rem;
            }

            label {
                display: block;
                margin-bottom: 0.5rem;
                color: var(--gray-500);
                font-weight: 500;
                font-size: 0.9rem;
            }

            input,
            select,
            textarea {
                width: 100%;
                padding: 0.75rem;
                border: 1px solid var(--gray-300);
                border-radius: 8px;
                font-size: 0.95rem;
                font-family: inherit;
                transition: border-color 0.3s ease;
            }

            input:focus,
            select:focus,
            textarea:focus {
                outline: none;
                border-color: var(--primary);
                box-shadow: 0 0 0 3px rgba(184, 92, 117, 0.1);
            }

            .form-row {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 1rem;
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
                background: var(--white);
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
                color: var(--primary);
            }

            .close-btn {
                background: none;
                border: none;
                font-size: 1.5rem;
                cursor: pointer;
                color: var(--gray-400);
            }

            /* Tabs */
            .tabs {
                display: flex;
                gap: 1rem;
                border-bottom: 2px solid var(--gray-200);
                margin-bottom: 1.5rem;
            }

            .tab-btn {
                background: none;
                border: none;
                padding: 1rem 0;
                cursor: pointer;
                color: var(--gray-400);
                font-weight: 500;
                border-bottom: 3px solid transparent;
                transition: all 0.3s ease;
            }

            .tab-btn.active {
                color: var(--primary);
                border-bottom-color: var(--primary);
            }

            .tab-content {
                display: none;
            }

            .tab-content.active {
                display: block;
            }

            /* Charts */
            .chart-container {
                background: var(--white);
                padding: 1.5rem;
                border-radius: 12px;
                margin-bottom: 1.5rem;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            }

            .chart-placeholder {
                height: 300px;
                background: linear-gradient(135deg, var(--primary-light) 0%, rgba(184, 92, 117, 0.1) 100%);
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--gray-400);
                font-weight: 500;
            }

            /* Game Section */
            .game-container {
                background: linear-gradient(135deg, var(--primary-light) 0%, var(--white) 100%);
                padding: 2rem;
                border-radius: 12px;
                text-align: center;
            }

            .game-canvas {
                width: 100%;
                max-width: 400px;
                height: 300px;
                background: var(--white);
                border: 3px solid var(--primary);
                border-radius: 8px;
                margin: 1rem auto;
            }

            /* Responsive */
            @media (max-width: 768px) {
                .sidebar {
                    width: 100%;
                    height: auto;
                    position: relative;
                    padding: 1rem 0;
                }

                .main-content {
                    margin-left: 0;
                    padding: 1rem;
                }

                .header {
                    flex-direction: column;
                    gap: 1rem;
                    align-items: flex-start;
                }

                .dashboard-grid {
                    grid-template-columns: 1fr;
                }

                .form-row {
                    grid-template-columns: 1fr;
                }

                .sidebar-menu button {
                    padding: 0.5rem 1rem;
                }
            }
        </style>
    </head>

    <body>
        <div class="admin-container">

            <!-- Main Content -->
            <main class="main-content">
                <!-- Dashboard Section -->
                <section id="dashboard" class="content-section active">
                    <div class="header">
                        <h1>Dashboard</h1>
                        <div class="header-actions">
                            <div class="date-display" x-data="{ now: new Date() }" x-init="setInterval(() => now = new Date(), 1000)">
                                📅 <span x-text="now.toLocaleDateString('en-US', { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' }) + ' ' + now.toLocaleTimeString('en-US')"></span>
                            </div>
                        </div>
                    </div>

                    <div class="dashboard-grid">
                        <div class="stat-card">
                            <h3>Total Orders</h3>
                            <div class="value">{{ $totalOrders }}</div>
                            <div class="change">Lifetime</div>
                        </div>
                        <div class="stat-card">
                            <h3>Active Machines</h3>
                            <div class="value">{{ $activeMachines }}</div>
                            <div class="change">In Use / Total</div>
                        </div>
                        <div class="stat-card">
                            <h3>Revenue Today</h3>
                            <div class="value">Rp {{ number_format($revenueToday, 0, ',', '.') }}</div>
                            <div class="change">{{ \Carbon\Carbon::today()->format('d M Y') }}</div>
                        </div>
                        <div class="stat-card">
                            <h3>Pending Orders</h3>
                            <div class="value">{{ $pendingOrders }}</div>
                            <div class="change">Action needed</div>
                        </div>
                    </div>

                    <div class="chart-container">
                        <h2>Weekly Revenue</h2>
                        <div style="height: 300px;">
                            <canvas id="weeklyRevenueChart"></canvas>
                        </div>
                    </div>

                    <div class="chart-container">
                        <h2>Machine Usage</h2>
                        <div style="height: 300px;">
                            <canvas id="machineUsageChart"></canvas>
                        </div>
                    </div>
                </section>

                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    document.addEventListener('livewire:initialized', () => {
                        // Weekly Revenue Chart
                        const weeklyRevenueCtx = document.getElementById('weeklyRevenueChart').getContext('2d');
                        new Chart(weeklyRevenueCtx, {
                            type: 'bar',
                            data: {
                                labels: @json($revenueLabels),
                                datasets: [{
                                    label: 'Revenue (Rp)',
                                    data: @json($revenueValues),
                                    backgroundColor: '#B85C75',
                                    borderRadius: 4
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: { beginAtZero: true }
                                }
                            }
                        });

                        // Machine Usage Chart
                        const machineUsageCtx = document.getElementById('machineUsageChart').getContext('2d');
                        new Chart(machineUsageCtx, {
                            type: 'doughnut',
                            data: {
                                labels: @json($machineLabels),
                                datasets: [{
                                    data: @json($machineValues),
                                    backgroundColor: [
                                        '#DCFCE7', // Available (assuming green)
                                        '#FEE2E2', // In Use (assuming red)
                                        '#FEF3C7', // Maintenance (assuming yellow)
                                        '#DBEAFE'  // Other
                                    ]
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false
                            }
                        });
                    });
                </script>




            </main>
        </div>

        <!-- Modals -->
        <div id="orderModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Create New Order</h2>
                    <button class="close-btn" onclick="closeModal('orderModal')">&times;</button>
                </div>
                <form>
                    <div class="form-group">
                        <label>Customer Name</label>
                        <input type="text" placeholder="Enter customer name" required>
                    </div>
                    <div class="form-group">
                        <label>Service Package</label>
                        <select required>
                            <option>Express Wash</option>
                            <option>Standard Wash</option>
                            <option>Premium Wash</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Number of Items</label>
                        <input type="number" placeholder="Enter number of items" required>
                    </div>
                    <div class="form-group">
                        <label>Special Instructions</label>
                        <textarea placeholder="Any special instructions..." rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Create Order</button>
                </form>
            </div>
        </div>

        <div id="machineModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Add New Machine</h2>
                    <button class="close-btn" onclick="closeModal('machineModal')">&times;</button>
                </div>
                <form>
                    <div class="form-group">
                        <label>Machine ID</label>
                        <input type="text" placeholder="e.g., M-001" required>
                    </div>
                    <div class="form-group">
                        <label>Location</label>
                        <input type="text" placeholder="e.g., Zone A" required>
                    </div>
                    <div class="form-group">
                        <label>Machine Type</label>
                        <select required>
                            <option>Washing Machine</option>
                            <option>Dryer</option>
                            <option>Combo Unit</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Capacity (kg)</label>
                        <input type="number" placeholder="Enter capacity" required>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Add Machine</button>
                </form>
            </div>
        </div>

        <div id="packageModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Create Service Package</h2>
                    <button class="close-btn" onclick="closeModal('packageModal')">&times;</button>
                </div>
                <form>
                    <div class="form-group">
                        <label>Package Name</label>
                        <input type="text" placeholder="e.g., Express Wash" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea placeholder="Package description..." rows="3" required></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Price ($)</label>
                            <input type="number" placeholder="0.00" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label>Duration (hours)</label>
                            <input type="number" placeholder="Enter duration" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Create Package</button>
                </form>
            </div>
        </div>

        <div id="promoModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Create Promotion</h2>
                    <button class="close-btn" onclick="closeModal('promoModal')">&times;</button>
                </div>
                <form>
                    <div class="form-group">
                        <label>Promo Code</label>
                        <input type="text" placeholder="e.g., FRESH20" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea placeholder="Promotion description..." rows="2" required></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Discount Type</label>
                            <select required>
                                <option>Percentage (%)</option>
                                <option>Fixed Amount ($)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Discount Value</label>
                            <input type="number" placeholder="Enter value" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Valid Until</label>
                        <input type="date" required>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Create Promo</button>
                </form>
            </div>
        </div>

        <div id="customerModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Add Customer</h2>
                    <button class="close-btn" onclick="closeModal('customerModal')">&times;</button>
                </div>
                <form>
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" placeholder="Enter full name" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" placeholder="Enter email" required>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="tel" placeholder="Enter phone number" required>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <textarea placeholder="Enter address..." rows="2" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Add Customer</button>
                </form>
            </div>
        </div>

        <script>
            // Navigation
            document.querySelectorAll('.menu-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const section = this.dataset.section;

                    // Hide all sections
                    document.querySelectorAll('.content-section').forEach(s => {
                        s.classList.remove('active');
                    });

                    // Remove active class from all buttons
                    document.querySelectorAll('.menu-btn').forEach(b => {
                        b.classList.remove('active');
                    });

                    // Show selected section
                    document.getElementById(section).classList.add('active');
                    this.classList.add('active');
                });
            });

            // Tab functionality
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const tabName = this.dataset.tab;
                    const card = this.closest('.card');

                    // Hide all tabs in this card
                    card.querySelectorAll('.tab-content').forEach(tab => {
                        tab.classList.remove('active');
                    });

                    // Remove active class from all buttons in this card
                    card.querySelectorAll('.tab-btn').forEach(b => {
                        b.classList.remove('active');
                    });

                    // Show selected tab
                    card.querySelector(`#${tabName}`).classList.add('active');
                    this.classList.add('active');
                });
            });

            // Modal functions
            function openModal(modalId) {
                document.getElementById(modalId).classList.add('active');
            }

            function closeModal(modalId) {
                document.getElementById(modalId).classList.remove('active');
            }

            // Close modal when clicking outside
            document.querySelectorAll('.modal').forEach(modal => {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        this.classList.remove('active');
                    }
                });
            });

            // Simple bubble pop game
            function startGame() {
                const canvas = document.getElementById('gameCanvas');
                const ctx = canvas.getContext('2d');

                canvas.width = canvas.offsetWidth;
                canvas.height = canvas.offsetHeight;

                let bubbles = [];
                let score = 0;
                let gameActive = true;

                class Bubble {
                    constructor() {
                        this.x = Math.random() * (canvas.width - 40) + 20;
                        this.y = Math.random() * (canvas.height - 40) + 20;
                        this.radius = Math.random() * 15 + 10;
                        this.vx = (Math.random() - 0.5) * 4;
                        this.vy = (Math.random() - 0.5) * 4;
                    }

                    draw() {
                        ctx.beginPath();
                        ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
                        ctx.fillStyle = '#B85C75';
                        ctx.fill();
                        ctx.strokeStyle = '#8B4A5F';
                        ctx.lineWidth = 2;
                        ctx.stroke();
                    }

                    update() {
                        this.x += this.vx;
                        this.y += this.vy;

                        if (this.x - this.radius < 0 || this.x + this.radius > canvas.width) {
                            this.vx *= -1;
                        }
                        if (this.y - this.radius < 0 || this.y + this.radius > canvas.height) {
                            this.vy *= -1;
                        }
                    }
                }

                // Create initial bubbles
                for (let i = 0; i < 5; i++) {
                    bubbles.push(new Bubble());
                }

                // Click to pop bubbles
                canvas.addEventListener('click', function(e) {
                    const rect = canvas.getBoundingClientRect();
                    const clickX = e.clientX - rect.left;
                    const clickY = e.clientY - rect.top;

                    for (let i = bubbles.length - 1; i >= 0; i--) {
                        const bubble = bubbles[i];
                        const distance = Math.sqrt((clickX - bubble.x) ** 2 + (clickY - bubble.y) ** 2);

                        if (distance < bubble.radius) {
                            bubbles.splice(i, 1);
                            score += 10;
                            bubbles.push(new Bubble());
                        }
                    }
                });

                function animate() {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);

                    // Draw score
                    ctx.fillStyle = '#B85C75';
                    ctx.font = 'bold 20px sans-serif';
                    ctx.fillText(`Score: ${score}`, 10, 30);

                    bubbles.forEach(bubble => {
                        bubble.update();
                        bubble.draw();
                    });

                    if (gameActive) {
                        requestAnimationFrame(animate);
                    }
                }

                animate();

                // Stop game after 30 seconds
                setTimeout(() => {
                    gameActive = false;
                    alert(`Game Over! Final Score: ${score}`);
                }, 30000);
            }
        </script>
    </body>
</div>
