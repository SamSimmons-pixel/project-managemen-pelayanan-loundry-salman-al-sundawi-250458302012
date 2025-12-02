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
                --primary-light: #E8D4DC;
                --primary-dark: #9B4A5F;
                --accent: #FF6B9D;
                --success: #4CAF50;
                --warning: #FFC107;
                --danger: #F44336;
                --bg-primary: #FFFFFF;
                --bg-secondary: #F9F5F7;
                --text-primary: #2C2C2C;
                --text-secondary: #666666;
                --border: #E8D4DC;
            }

            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background-color: var(--bg-secondary);
                color: var(--text-primary);
                line-height: 1.6;
            }

            /* Added sidebar styling */
            .sidebar {
                width: 280px;
                background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
                color: white;
                padding: 2rem 0;
                position: fixed;
                height: 100vh;
                overflow-y: auto;
                box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
                z-index: 999;
            }

            .sidebar-header {
                padding: 0 1.5rem;
                margin-bottom: 2rem;
                display: flex;
                align-items: center;
                gap: 0.75rem;
            }

            .sidebar-logo {
                font-size: 1.8rem;
            }

            .sidebar-title {
                font-color: white;
                font-size: 1.3rem;
                font-weight: bold;
            }

            .sidebar-menu {
                list-style: none;
            }

            .sidebar-menu li {
                margin: 0;
            }

            .sidebar-menu-item {
                display: flex;
                align-items: center;
                gap: 1rem;
                padding: 1rem 1.5rem;
                cursor: pointer;
                transition: all 0.3s;
                border-left: 4px solid transparent;
                color: rgba(255, 255, 255, 0.8);
            }

            .sidebar-menu-item:hover {
                background: rgba(255, 255, 255, 0.1);
                color: white;
                border-left-color: white;
            }

            .sidebar-menu-item.active {
                background: rgba(255, 255, 255, 0.2);
                color: white;
                border-left-color: white;
                font-weight: 600;
            }

            .sidebar-icon {
                font-size: 1.5rem;
                min-width: 1.5rem;
            }

            .sidebar-text {
                flex: 1;
            }

            .sidebar-toggle {
                display: none;
                position: fixed;
                top: 1rem;
                left: 1rem;
                background: var(--primary);
                color: white;
                border: none;
                padding: 0.75rem 1rem;
                border-radius: 6px;
                cursor: pointer;
                z-index: 1001;
                font-size: 1.2rem;
            }

            /* Updated main layout to accommodate sidebar */
            .main-wrapper {
                flex: 1;
                margin-left: 280px;
                display: flex;
                flex-direction: column;
                min-height: 100vh;
            }

            /* Header */
            .header {
                background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
                color: white;
                padding: 1.5rem 2rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            }

            .header-left {
                display: flex;
                align-items: center;
                gap: 1rem;
            }

            .logo {
                font-size: 1.8rem;
                font-weight: bold;
            }

            .user-info {
                display: flex;
                align-items: center;
                gap: 1rem;
            }

            .user-avatar {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.3);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.2rem;
            }

            .logout-btn {
                background: rgba(255, 255, 255, 0.2);
                border: 1px solid rgba(255, 255, 255, 0.3);
                color: white;
                padding: 0.5rem 1rem;
                border-radius: 6px;
                cursor: pointer;
                transition: all 0.3s;
            }

            .logout-btn:hover {
                background: rgba(255, 255, 255, 0.3);
            }

            /* Main Container */
            .container {
                max-width: 1400px;
                margin: 0 auto;
                padding: 2rem;
                flex: 1;
            }

            /* Welcome Section */
            .welcome-section {
                background: var(--bg-primary);
                padding: 2rem;
                border-radius: 12px;
                margin-bottom: 2rem;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
                border-left: 4px solid var(--primary);
            }

            .welcome-section h1 {
                color: var(--primary);
                margin-bottom: 0.5rem;
            }

            .welcome-section p {
                color: var(--text-secondary);
            }

            /* Quick Stats */
            .stats-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1.5rem;
                margin-bottom: 2rem;
            }

            .stat-card {
                background: var(--bg-primary);
                padding: 1.5rem;
                border-radius: 12px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
                text-align: center;
                border-top: 3px solid var(--primary);
            }

            .stat-number {
                font-size: 2rem;
                font-weight: bold;
                color: var(--primary);
                margin: 0.5rem 0;
            }

            .stat-label {
                color: var(--text-secondary);
                font-size: 0.9rem;
            }

            /* Features Section */
            .features-section h2 {
                color: var(--primary);
                margin-bottom: 1.5rem;
                font-size: 1.8rem;
            }

            .features-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 1.5rem;
                margin-bottom: 2rem;
            }

            .feature-card {
                background: var(--bg-primary);
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
                transition: all 0.3s;
                cursor: pointer;
                border: 2px solid transparent;
            }

            .feature-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 8px 16px rgba(184, 92, 117, 0.15);
                border-color: var(--primary);
            }

            .feature-header {
                background: linear-gradient(135deg, var(--primary-light) 0%, #F0E0E8 100%);
                padding: 1.5rem;
                text-align: center;
            }

            .feature-icon {
                font-size: 2.5rem;
                margin-bottom: 0.5rem;
            }

            .feature-title {
                color: var(--primary);
                font-weight: bold;
                font-size: 1.1rem;
            }

            .feature-body {
                padding: 1.5rem;
            }

            .feature-description {
                color: var(--text-secondary);
                font-size: 0.9rem;
                margin-bottom: 1rem;
            }

            .feature-btn {
                background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
                color: white;
                border: none;
                padding: 0.75rem 1.5rem;
                border-radius: 6px;
                cursor: pointer;
                font-weight: 600;
                transition: all 0.3s;
                width: 100%;
            }

            .feature-btn:hover {
                transform: scale(1.02);
                box-shadow: 0 4px 12px rgba(184, 92, 117, 0.3);
            }

            /* Modal */
            .modal {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1000;
                align-items: center;
                justify-content: center;
            }

            .modal.active {
                display: flex;
            }

            .modal-content {
                background: var(--bg-primary);
                border-radius: 12px;
                padding: 2rem;
                max-width: 600px;
                width: 90%;
                max-height: 80vh;
                overflow-y: auto;
                position: relative;
            }

            .modal-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 1.5rem;
                border-bottom: 2px solid var(--border);
                padding-bottom: 1rem;
            }

            .modal-header h2 {
                color: var(--primary);
            }

            .close-btn {
                background: none;
                border: none;
                font-size: 1.5rem;
                cursor: pointer;
                color: var(--text-secondary);
            }

            .close-btn:hover {
                color: var(--primary);
            }

            /* Tabs */
            .tabs {
                display: flex;
                gap: 1rem;
                margin-bottom: 1.5rem;
                border-bottom: 2px solid var(--border);
            }

            .tab-btn {
                background: none;
                border: none;
                padding: 0.75rem 1.5rem;
                cursor: pointer;
                color: var(--text-secondary);
                font-weight: 600;
                border-bottom: 3px solid transparent;
                transition: all 0.3s;
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

            /* Form Elements */
            .form-group {
                margin-bottom: 1.5rem;
            }

            .form-group label {
                display: block;
                margin-bottom: 0.5rem;
                color: var(--text-primary);
                font-weight: 600;
            }

            .form-group input,
            .form-group select,
            .form-group textarea {
                width: 100%;
                padding: 0.75rem;
                border: 1px solid var(--border);
                border-radius: 6px;
                font-family: inherit;
                font-size: 1rem;
            }

            .form-group input:focus,
            .form-group select:focus,
            .form-group textarea:focus {
                outline: none;
                border-color: var(--primary);
                box-shadow: 0 0 0 3px rgba(184, 92, 117, 0.1);
            }

            /* Tables */
            .table-container {
                overflow-x: auto;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 1rem;
            }

            th {
                background: var(--primary-light);
                color: var(--primary);
                padding: 1rem;
                text-align: left;
                font-weight: 600;
            }

            td {
                padding: 1rem;
                border-bottom: 1px solid var(--border);
            }

            tr:hover {
                background: var(--bg-secondary);
            }

            /* Status Badges */
            .badge {
                display: inline-block;
                padding: 0.4rem 0.8rem;
                border-radius: 20px;
                font-size: 0.85rem;
                font-weight: 600;
            }

            .badge-pending {
                background: #FFF3CD;
                color: #856404;
            }

            .badge-washing {
                background: #D1ECF1;
                color: #0C5460;
            }

            .badge-completed {
                background: #D4EDDA;
                color: #155724;
            }

            .badge-available {
                background: #D4EDDA;
                color: #155724;
            }

            .badge-unavailable {
                background: #F8D7DA;
                color: #721C24;
            }

            /* Game Container */
            .game-container {
                background: linear-gradient(135deg, var(--primary-light) 0%, #F0E0E8 100%);
                border-radius: 12px;
                padding: 2rem;
                text-align: center;
                margin: 1rem 0;
            }

            #gameCanvas {
                border: 3px solid var(--primary);
                border-radius: 8px;
                background: white;
                margin: 1rem auto;
                display: block;
            }

            .game-score {
                font-size: 1.5rem;
                color: var(--primary);
                font-weight: bold;
                margin: 1rem 0;
            }

            /* Footer */
            .footer {
                background: var(--bg-primary);
                border-top: 2px solid var(--border);
                padding: 2rem;
                text-align: center;
                color: var(--text-secondary);
                margin-top: 3rem;
            }

            /* Added responsive design for mobile */
            @media (max-width: 768px) {
                .sidebar {
                    width: 100%;
                    height: auto;
                    position: fixed;
                    top: 0;
                    left: -100%;
                    transition: left 0.3s;
                    max-height: 100vh;
                    overflow-y: auto;
                }

                .sidebar.active {
                    left: 0;
                }

                .main-wrapper {
                    margin-left: 0;
                }

                .sidebar-toggle {
                    display: block;
                }

                .header {
                    flex-direction: column;
                    gap: 1rem;
                }

                .features-grid {
                    grid-template-columns: 1fr;
                }

                .stats-grid {
                    grid-template-columns: repeat(2, 1fr);
                }

                .modal-content {
                    width: 95%;
                }
            }

            /* Animations */
            @keyframes slideIn {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .feature-card {
                animation: slideIn 0.3s ease-out;
            }
        </style>
    </head>

    <body>
        <!-- Added sidebar navigation -->


        <!-- Wrapped main content in main-wrapper -->
        <div class="main-wrapper">
            <!-- Sidebar Toggle Button -->
            <button class="sidebar-toggle" onclick="toggleSidebar()">☰ Menu</button>

            <!-- Header -->
            <div class="header">
                <div class="header-left">
                    <div class="logo">🧺 Loundrys'S</div>
                </div>
                <div class="user-info">
                    <div class="user-avatar">👤</div>
                    <span>Welcome, {{ ucfirst(strtolower(Auth::user()->name)) }}</span>
                    <button class="logout-btn" onclick="logout()">Logout</button>
                </div>
            </div>

            <!-- Main Container -->
            <div class="container">
                <!-- Welcome Section -->
                <div class="welcome-section">
                    <h1>Welcome back to Loundrys'S! ✨</h1>
                    <p>Your laundry management hub - Order, track, and manage all your laundry needs in one place.</p>
                </div>

                <!-- Quick Stats -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div style="font-size: 1.8rem;">📦</div>
                        <div class="stat-number" id="activeOrders">2</div>
                        <div class="stat-label">Active Orders</div>
                    </div>
                    <div class="stat-card">
                        <div style="font-size: 1.8rem;">🧺</div>
                        <div class="stat-number" id="machinesRented">1</div>
                        <div class="stat-label">Machines Rented</div>
                    </div>
                    <div class="stat-card">
                        <div style="font-size: 1.8rem;">💰</div>
                        <div class="stat-number" id="totalSpent">Rp 450K</div>
                        <div class="stat-label">Total Spent</div>
                    </div>
                    <div class="stat-card">
                        <div style="font-size: 1.8rem;">⭐</div>
                        <div class="stat-number">4.8</div>
                        <div class="stat-label">Your Rating</div>
                    </div>
                </div>

                <!-- Features Section -->
                <div class="features-section">
                    <h2>Your Services</h2>
                    <div class="features-grid">
                        <!-- 1. Order Placement -->
                        <div class="feature-card">
                            <div class="feature-header">
                                <div class="feature-icon">📋</div>
                                <div class="feature-title">Place Order</div>
                            </div>
                            <div class="feature-body">
                                <p class="feature-description">Pesan layanan antar-jemput atau sewa mesin langsung dari
                                    aplikasi.</p>
                                <button class="feature-btn" onclick="openModal('orderModal')">Place Order</button>
                            </div>
                        </div>

                        <!-- 2. Order Tracking -->
                        <div class="feature-card">
                            <div class="feature-header">
                                <div class="feature-icon">📍</div>
                                <div class="feature-title">Track Order</div>
                            </div>
                            <div class="feature-body">
                                <p class="feature-description">Lacak status cucian Anda secara real-time dari pickup
                                    hingga delivery.</p>
                                <button class="feature-btn" onclick="openModal('trackingModal')">Track Now</button>
                            </div>
                        </div>

                        <!-- 3. Machine Borrowing -->
                        <div class="feature-card">
                            <div class="feature-header">
                                <div class="feature-icon">🔧</div>
                                <div class="feature-title">Rent Machine</div>
                            </div>
                            <div class="feature-body">
                                <p class="feature-description">Cek ketersediaan & sewa mesin cuci langsung dari
                                    aplikasi.</p>
                                <button class="feature-btn" onclick="openModal('machineModal')">View Machines</button>
                            </div>
                        </div>

                        <!-- 4. Service Packages -->
                        <div class="feature-card">
                            <div class="feature-header">
                                <div class="feature-icon">📦</div>
                                <div class="feature-title">Service Packages</div>
                            </div>
                            <div class="feature-body">
                                <p class="feature-description">Pilih paket layanan sesuai kebutuhan Anda dari berbagai
                                    pilihan.</p>
                                <button class="feature-btn" onclick="openModal('packagesModal')">View Packages</button>
                            </div>
                        </div>

                        <!-- 5. Invoices & Receipts -->
                        <div class="feature-card">
                            <div class="feature-header">
                                <div class="feature-icon">🧾</div>
                                <div class="feature-title">Invoices</div>
                            </div>
                            <div class="feature-body">
                                <p class="feature-description">Dapatkan nota & riwayat transaksi digital yang tersimpan
                                    rapi.</p>
                                <button class="feature-btn" onclick="openModal('invoiceModal')">View Invoices</button>
                            </div>
                        </div>

                        <!-- 6. Promos & Discounts -->
                        <div class="feature-card">
                            <div class="feature-header">
                                <div class="feature-icon">🎉</div>
                                <div class="feature-title">Promos</div>
                            </div>
                            <div class="feature-body">
                                <p class="feature-description">Nikmati berbagai promo & diskon menarik untuk harga
                                    terbaik.</p>
                                <button class="feature-btn" onclick="openModal('promoModal')">View Promos</button>
                            </div>
                        </div>

                        <!-- 7. My Dashboard -->
                        <div class="feature-card">
                            <div class="feature-header">
                                <div class="feature-icon">👤</div>
                                <div class="feature-title">My Dashboard</div>
                            </div>
                            <div class="feature-body">
                                <p class="feature-description">Kelola semua pesanan, riwayat transaksi, dan informasi
                                    akun Anda.</p>
                                <button class="feature-btn" onclick="openModal('dashboardModal')">My Dashboard</button>
                            </div>
                        </div>

                        <!-- 8. Game -->
                        <div class="feature-card">
                            <div class="feature-header">
                                <div class="feature-icon">🎮</div>
                                <div class="feature-title">Play Game</div>
                            </div>
                            <div class="feature-body">
                                <p class="feature-description">Mainkan game seru sambil menunggu cucian Anda selesai.
                                </p>
                                <button class="feature-btn" onclick="openModal('gameModal')">Play Now</button>
                            </div>
                        </div>

                        <!-- 9. Ratings & Reviews -->
                        <div class="feature-card">
                            <div class="feature-header">
                                <div class="feature-icon">⭐</div>
                                <div class="feature-title">Reviews</div>
                            </div>
                            <div class="feature-body">
                                <p class="feature-description">Beri penilaian & ulasan untuk membantu kami menjadi
                                    lebih baik.</p>
                                <button class="feature-btn" onclick="openModal('reviewModal')">Leave Review</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer">
                <p>&copy; 2025 Loundrys'S. All rights reserved. | Privacy Policy | Terms of Service</p>
            </div>
        </div>

        <!-- MODALS -->

        <!-- ENDMODALS -->

        <script>
            function toggleSidebar() {
                const sidebar = document.getElementById('sidebar');
                sidebar.classList.toggle('active');
            }

            function closeSidebar() {
                const sidebar = document.getElementById('sidebar');
                sidebar.classList.remove('active');
            }

            // Close sidebar when clicking outside
            document.addEventListener('click', function(event) {
                const sidebar = document.getElementById('sidebar');
                const toggle = document.querySelector('.sidebar-toggle');
                if (!sidebar.contains(event.target) && !toggle.contains(event.target)) {
                    sidebar.classList.remove('active');
                }
            });

            // Modal Functions
            function openModal(modalId) {
                document.getElementById(modalId).classList.add('active');
            }

            function closeModal(modalId) {
                document.getElementById(modalId).classList.remove('active');
            }

            // Close modal when clicking outside
            window.onclick = function(event) {
                if (event.target.classList.contains('modal')) {
                    event.target.classList.remove('active');
                }
            }

            // Tab Switching
            function switchTab(tabId, button) {
                const parent = button.parentElement;
                const tabs = parent.querySelectorAll('.tab-btn');
                const contents = button.closest('.modal-content').querySelectorAll('.tab-content');

                tabs.forEach(tab => tab.classList.remove('active'));
                contents.forEach(content => content.classList.remove('active'));

                button.classList.add('active');
                document.getElementById(tabId).classList.add('active');
            }

            // Form Submissions
            function submitOrder(event) {
                event.preventDefault();
                alert('Order placed successfully! You will receive a confirmation shortly.');
                closeModal(event.target.closest('.modal').id);
            }

            function submitReview(event) {
                event.preventDefault();
                alert('Thank you for your review!');
                closeModal(event.target.closest('.modal').id);
            }

            // Rating System
            function setRating(rating) {
                const stars = document.querySelectorAll('.star');
                stars.forEach((star, index) => {
                    if (index < rating) {
                        star.textContent = '★';
                        star.style.color = 'var(--primary)';
                    } else {
                        star.textContent = '☆';
                        star.style.color = 'var(--text-secondary)';
                    }
                });
            }

            // Game Functions
            let gameScore = 0;
            let gameRunning = false;
            let bubbles = [];

            function startGame() {
                gameScore = 0;
                gameRunning = true;
                bubbles = [];
                document.getElementById('gameScore').textContent = '0';

                const canvas = document.getElementById('gameCanvas');
                const ctx = canvas.getContext('2d');

                // Create initial bubbles
                for (let i = 0; i < 5; i++) {
                    bubbles.push({
                        x: Math.random() * (canvas.width - 40) + 20,
                        y: Math.random() * (canvas.height - 40) + 20,
                        radius: 20,
                        vx: (Math.random() - 0.5) * 4,
                        vy: (Math.random() - 0.5) * 4
                    });
                }

                canvas.onclick = function(e) {
                    if (!gameRunning) return;
                    const rect = canvas.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;

                    for (let i = bubbles.length - 1; i >= 0; i--) {
                        const bubble = bubbles[i];
                        const distance = Math.sqrt((x - bubble.x) ** 2 + (y - bubble.y) ** 2);
                        if (distance < bubble.radius) {
                            bubbles.splice(i, 1);
                            gameScore += 10;
                            document.getElementById('gameScore').textContent = gameScore;
                        }
                    }
                };

                function animate() {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);

                    bubbles.forEach(bubble => {
                        bubble.x += bubble.vx;
                        bubble.y += bubble.vy;

                        if (bubble.x - bubble.radius < 0 || bubble.x + bubble.radius > canvas.width) {
                            bubble.vx *= -1;
                        }
                        if (bubble.y - bubble.radius < 0 || bubble.y + bubble.radius > canvas.height) {
                            bubble.vy *= -1;
                        }

                        ctx.fillStyle = 'var(--primary)';
                        ctx.beginPath();
                        ctx.arc(bubble.x, bubble.y, bubble.radius, 0, Math.PI * 2);
                        ctx.fill();
                    });

                    if (gameRunning && bubbles.length > 0) {
                        requestAnimationFrame(animate);
                    } else if (bubbles.length === 0) {
                        gameRunning = false;
                        ctx.fillStyle = 'var(--primary)';
                        ctx.font = 'bold 24px Arial';
                        ctx.textAlign = 'center';
                        ctx.fillText('Game Over! Score: ' + gameScore, canvas.width / 2, canvas.height / 2);
                    }
                }

                animate();
            }

            // Logout
            function logout() {
                if (confirm('Are you sure you want to logout?')) {
                    window.location.href = '{{ route('auth.logout') }}';
                }
            }
        </script>
    </body>
</div>
