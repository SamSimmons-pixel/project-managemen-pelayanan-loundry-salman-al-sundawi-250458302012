<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loundrys'S Admin Dashboard - Laundry Management System</title>
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

            .sidebar-menu .menu-btn {
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
                text-decoration: none; /* Added for anchor tags */
            }

            .sidebar-menu .menu-btn:hover {
                background-color: rgba(255, 255, 255, 0.1);
                color: var(--white);
                padding-left: 2rem;
            }

            .sidebar-menu .menu-btn.active {
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
    @livewireStyles
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <!-- Sidebar Navigation -->
            <aside class="sidebar">
                <div class="sidebar-header">
                    <div class="sidebar-logo">🧺 Loundrys'S Admin</div>
                </div>
                <ul class="sidebar-menu">
                    <li><a class="menu-btn {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}" wire:navigate>📊 Dashboard</a></li>
                    <li><a class="menu-btn {{ request()->routeIs('admin.branch-admins') ? 'active' : '' }}" href="{{ route('admin.branch-admins') }}" wire:navigate>🏢 Branch Management</a></li>
                    <li><a class="menu-btn {{ request()->routeIs('admin.service-packages') ? 'active' : '' }}" href="{{ route('admin.service-packages') }}" wire:navigate>📋 Service Packages</a></li>
                    <li><a class="menu-btn {{ request()->routeIs('admin.customers') ? 'active' : '' }}" href="{{ route('admin.customers') }}" wire:navigate>👥 Customers</a></li>
                    <li><a class="menu-btn {{ request()->routeIs('admin.analytics') ? 'active' : '' }}" href="{{ route('admin.analytics') }}" wire:navigate>📈 Analytics & Reports</a></li>
                    <li><a class="menu-btn {{ request()->routeIs('admin.reviews') ? 'active' : '' }}" href="{{ route('admin.reviews') }}" wire:navigate>⭐ Reviews & Ratings</a></li>
                </ul>
            </aside>
    {{ $slot }}
    @livewireScripts
</body>
</html>
