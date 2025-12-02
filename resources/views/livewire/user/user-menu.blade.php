<div>

    <head>
    </head>

    <body>
        <!-- Added sidebar navigation -->


        <!-- Wrapped main content in main-wrapper -->
        <div class="main-wrapper">
            <!-- Sidebar Toggle Button -->
            <button class="sidebar-toggle" onclick="toggleSidebar()">☰ Menu</button>

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
                        @php
                            $OrdersCount = \App\Models\Order::where('user_id', auth()->id())
                                ->count();
                        @endphp
                        <div class="stat-number" id="activeOrders">{{ $OrdersCount }}</div>
                        <div class="stat-label">Total Orders</div>
                    </div>
                    <div class="stat-card">
                        <div style="font-size: 1.8rem;">💰</div>
                        <div class="stat-number" id="totalSpent">Rp {{ number_format($totalSpent, 0, ',', '.') }}</div>
                        <div class="stat-label">Total Spent</div>
                    </div>
                    <div class="stat-card">
                        <div style="font-size: 1.8rem;">⭐</div>
                        <div class="stat-number">{{ number_format($averageRating, 1) }}</div>
                        <div class="stat-label">Your Rating</div>
                    </div>
                </div>

                <!-- Features Section -->
                <div class="features-section">
                    <h2>Our Services</h2>
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
                                <button class="feature-btn" onclick="window.location.href='{{ route('user.place-order') }}'">Place Order</button>
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
                                <button class="feature-btn" onclick="window.location.href='{{ route('user.track-order') }}'">Track Now</button>
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
                                <button class="feature-btn" onclick="window.location.href='{{ route('user.machine') }}'">View Machines</button>
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
                                <button class="feature-btn" onclick="window.location.href='{{ route('user.invoice') }}'">View Invoices</button>
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
                                <button class="feature-btn" onclick="window.location.href='{{ route('user.promo') }}'">View Promos</button>
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
                                <button class="feature-btn" onclick="window.location.href='{{ route('user.game') }}'">Play Now</button>
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
                                <button class="feature-btn" onclick="window.location.href='{{ route('user.review') }}'">Leave Review</button>
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
        @include('livewire.user.user-dashboard')
        <!-- ENDMODALS -->

        <script>

        </script>
    </body>
</div>
