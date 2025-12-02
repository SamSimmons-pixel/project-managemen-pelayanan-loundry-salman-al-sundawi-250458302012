<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loundrys'S - User Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/badgestatus.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pickup.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        .promo-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
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
            top: -100px;
            left: 1rem;
            background: var(--primary);
            color: white;
            border: none;
            padding: 0.75rem 1rem;
            border-radius: 6px;
            cursor: pointer;
            z-index: 1001;
            font-size: 1.2rem;
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.3s ease, top 0.3s ease, left 0.3s ease;
        }

        .sidebar-toggle.moved {
            transform: scale(0);
            opacity: 0;
            pointer-events: none;
        }

        .sidebar-toggle.visible-scroll,
        .sidebar-toggle.force-visible {
            top: 1rem;
        }

        .sidebar-toggle.dragging {
            transition: none;
            cursor: grabbing;
            opacity: 0.8;
        }

        /* Updated main layout to accommodate sidebar */
        .main-wrapper {
            margin-left: 280px;
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
            max-width: 80%;
            width: 100%;
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

        a {
            color: var(--primary);
            text-decoration: none;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 12px;
            height: 12px;
        }

        ::-webkit-scrollbar-track {
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-light);
            border-radius: 10px;
            border: 3px solid var(--bg-secondary);
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
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

        .badge-belum_bayar {
            color: #fff;
            background-color: #6c757d;
        }

        .badge-sedang_diproses {
            color: #000;
            background-color: #ffc107;
        }

        .badge-selesai {
            color: #fff;
            background-color: #198754;
        }

        .badge-delivered {
            color: #fff;
            background-color: #0d6efd;
        }

        /* Game Container */
        .game-container {
            background: linear-gradient(135deg, var(--primary-light) 0%, #F0E0E8 100%);
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            margin: 1rem 0;
        }

        .game-container .btn-primary {
            background-color: var(--primary);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .game-container .btn-primary:hover {
            background-color: #a34a69;
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
                height: 100vh;
                position: fixed;
                top: 0;
                left: -100%;
                transition: left 0.3s;
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
                flex-direction: row;
                padding: 1rem;
                gap: 0.5rem;
            }

            .header .user-info span {
                display: none;
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

            .sidebar-menu-item {
                padding: 0.8rem 1rem;
            }

            .sidebar-icon {
                font-size: 1.2rem;
                min-width: 1.5rem;
                text-align: center;
            }

            .sidebar-text {
                font-size: 0.95rem;
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

        .feature-main {
            animation: slideIn 0.5s ease-out;
        }

        @keyframes pop-jiggle {
            0% { transform: scale(1); }
            25% { transform: scale(0.9) rotate(-3deg); }
            50% { transform: scale(0.9) rotate(3deg); }
            75% { transform: scale(1.15); }
            100% { transform: scale(1); }
        }

        @keyframes splash-drop {
            0% {
                transform: translate(0, 0) scale(1);
                opacity: 1;
            }
            100% {
                transform: translate(var(--tx), var(--ty)) scale(0);
                opacity: 0;
            }
        }

        .sidebar-toggle.popping {
            animation: pop-jiggle 0.4s ease-in-out forwards;
        }

        .splash-droplet {
            position: fixed;
            border-radius: 50%;
            background: var(--primary);
            pointer-events: none;
            z-index: 1002;
            animation: splash-drop 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
        }
    </style>
    <link rel="stylesheet" href="sweetalert2.min.css">
    @livewireStyles
</head>

<body>
    @persist('scrollbar')
        <div class="sidebar overflow-y-scroll" id="sidebar" data-livewire-persist wire:scroll>
            <div class="sidebar-header" wire:scroll>
                <a class="sidebar-logo" href="{{ route('home') }}">🧺</a>
                <a class="sidebar-title" href="{{ route('home') }}"
                    style="text-decoration: none; color: white;">Loundrys'S</a>
            </div>
            <ul class="sidebar-menu">
                <li>
                    <a class="sidebar-menu-item {{ request()->routeIs('user.place-order') ? 'active' : '' }}"
                        href="{{ route('user.place-order') }}">
                        <div class="sidebar-icon">📋</div>
                        <div class="sidebar-text">Place Order</div>
                    </a>
                </li>
                <li>
                    <a class="sidebar-menu-item {{ request()->routeIs('user.track-order') ? 'active' : '' }}"
                        href="{{ route('user.track-order') }}">
                        <div class="sidebar-icon">📍</div>
                        <div class="sidebar-text">Track Order</div>
                    </a>
                </li>
                <li>
                    <a class="sidebar-menu-item {{ request()->routeIs('user.machine') ? 'active' : '' }}"
                        href="{{ route('user.machine') }}">
                        <div class="sidebar-icon">🔧</div>
                        <div class="sidebar-text">Rent Machine</div>
                    </a>
                </li>
                <li>
                    <a class="sidebar-menu-item {{ request()->routeIs('user.invoice') ? 'active' : '' }}"
                        href="{{ route('user.invoice') }}">
                        <div class="sidebar-icon">🧾</div>
                        <div class="sidebar-text">Invoices</div>
                    </a>
                </li>
                <li>
                    <a class="sidebar-menu-item {{ request()->routeIs('user.promo') ? 'active' : '' }}"
                        href="{{ route('user.promo') }}">
                        <div class="sidebar-icon">🎉</div>
                        <div class="sidebar-text">Promos</div>
                    </a>
                </li>
                <li>
                    <a class="sidebar-menu-item {{ request()->routeIs('user.menu') ? 'active' : '' }}"
                        href="{{ route('user.menu') }}">
                        <div class="sidebar-icon">👤</div>
                        <div class="sidebar-text">My Dashboard</div>
                    </a>
                </li>
                <li>
                    <a class="sidebar-menu-item {{ request()->routeIs('user.game') ? 'active' : '' }}"
                        href="{{ route('user.game') }}">
                        <div class="sidebar-icon">🎮</div>
                        <div class="sidebar-text">Play Game</div>
                    </a>
                </li>
                <li>
                    <a class="sidebar-menu-item {{ request()->routeIs('user.review') ? 'active' : '' }}"
                        href="{{ route('user.review') }}">
                        <div class="sidebar-icon">⭐</div>
                        <div class="sidebar-text">Reviews</div>
                    </a>
                </li>
            </ul>
        @endpersist
    </div>
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
    </div>
    </div>
    <div class="">
        {{ $slot }}
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const canvas = document.getElementById('gameCanvas');
            const scoreEl = document.getElementById('gameScore');
            const startGameBtn = document.getElementById('startGameBtn');
            const gameOverEl = document.getElementById('gameOver');

            if (canvas && scoreEl && startGameBtn && gameOverEl) {
                const ctx = canvas.getContext('2d');
                let score = 0;
                let bubbles = [];
                let gameLoop;
                let bubbleCreationInterval;
                let isPlaying = false;
                let missedBubbles = 0;
                const maxMissedBubbles = 10;

                class Bubble {
                    constructor(x, y, radius, color, speed) {
                        this.x = x;
                        this.y = y;
                        this.radius = radius;
                        this.color = color;
                        this.speed = speed;
                    }

                    draw() {
                        ctx.beginPath();
                        ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
                        ctx.fillStyle = this.color;
                        ctx.fill();
                        ctx.closePath();
                    }

                    update() {
                        this.y -= this.speed;
                    }
                }

                function createBubble() {
                    const radius = Math.random() * 20 + 10;
                    const x = Math.random() * (canvas.width - radius * 2) + radius;
                    const y = canvas.height + radius;
                    const color =
                        `rgba(${Math.random() * 255}, ${Math.random() * 255}, ${Math.random() * 255}, 0.7)`;
                    const speed = Math.random() * 2 + 1;
                    bubbles.push(new Bubble(x, y, radius, color, speed));
                }

                function animate() {
                    if (!isPlaying) return;

                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    bubbles.forEach((bubble, index) => {
                        bubble.update();
                        bubble.draw();
                        if (bubble.y + bubble.radius < 0) {
                            bubbles.splice(index, 1);
                            missedBubbles++;
                            if (missedBubbles >= maxMissedBubbles) {
                                stopGame();
                            }
                        }
                    });
                }

                function startGame() {
                    score = 0;
                    bubbles = [];
                    missedBubbles = 0;
                    isPlaying = true;
                    gameOverEl.style.display = 'none';
                    startGameBtn.textContent = 'Stop';
                    if (scoreEl) {
                        scoreEl.textContent = score;
                    }

                    if (gameLoop) clearInterval(gameLoop);
                    if (bubbleCreationInterval) clearInterval(bubbleCreationInterval);

                    gameLoop = setInterval(animate, 1000 / 60);
                    bubbleCreationInterval = setInterval(createBubble, 1000);
                }

                function stopGame() {
                    isPlaying = false;
                    clearInterval(gameLoop);
                    clearInterval(bubbleCreationInterval);
                    gameOverEl.style.display = 'block';
                    startGameBtn.textContent = 'Start Game';
                }

                canvas.addEventListener('click', (e) => {
                    if (!isPlaying) return;

                    const rect = canvas.getBoundingClientRect();
                    const mouseX = e.clientX - rect.left;
                    const mouseY = e.clientY - rect.top;

                    for (let i = bubbles.length - 1; i >= 0; i--) {
                        const bubble = bubbles[i];
                        const distance = Math.sqrt((mouseX - bubble.x) ** 2 + (mouseY - bubble.y) ** 2);
                        if (distance < bubble.radius) {
                            bubbles.splice(i, 1);
                            score++;
                            if (scoreEl) {
                                scoreEl.textContent = score;
                            }
                            break;
                        }
                    }
                });

                startGameBtn.addEventListener('click', () => {
                    if (isPlaying) {
                        stopGame();
                    } else {
                        startGame();
                    }
                });
            }
        });

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.sidebar-toggle');
            
            // Add popping animation class
            toggle.classList.add('popping');

            // Create Splash Droplets
            const rect = toggle.getBoundingClientRect();
            const centerX = rect.left + rect.width / 2;
            const centerY = rect.top + rect.height / 2;

            for (let i = 0; i < 12; i++) {
                const droplet = document.createElement('div');
                droplet.classList.add('splash-droplet');
                
                // Random angle and distance
                const angle = Math.random() * Math.PI * 2;
                const velocity = Math.random() * 80 + 60; // Increased distance (was 60+40)
                
                const tx = Math.cos(angle) * velocity;
                const ty = Math.sin(angle) * velocity;
                
                droplet.style.setProperty('--tx', `${tx}px`);
                droplet.style.setProperty('--ty', `${ty}px`);
                
                droplet.style.left = `${centerX}px`;
                droplet.style.top = `${centerY}px`;
                
                // Random size
                const size = Math.random() * 14 + 10;
                droplet.style.width = `${size}px`;
                droplet.style.height = `${size}px`;
                
                // Random Rainbow Color
                const colors = ['#00FF00', '#ff00d4ff', '#ff00d4ff', '#d4ff00ff', '#c43f88ff'];
                droplet.style.background = colors[Math.floor(Math.random() * colors.length)];
                
                document.body.appendChild(droplet);

                setTimeout(() => {
                    droplet.remove();
                }, 600);
            }

            // Wait for animation to finish before opening sidebar
            setTimeout(() => {
                toggle.classList.remove('popping');
                void toggle.offsetWidth; // Force reflow to ensure transition plays
                sidebar.classList.toggle('active');
                toggle.classList.toggle('moved');
            }, 400); // Matches animation duration
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.sidebar-toggle');
            sidebar.classList.remove('active');
            toggle.classList.remove('moved');
        }

        // Close sidebar when clicking outside
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.sidebar-toggle');
            if (!sidebar.contains(event.target) && !toggle.contains(event.target)) {
                sidebar.classList.remove('active');
                toggle.classList.remove('moved');
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

        // Scroll Observer and Draggable Button Logic
        document.addEventListener('DOMContentLoaded', function() {
            const header = document.querySelector('.header');
            const toggleBtn = document.querySelector('.sidebar-toggle');
            let isDragging = false;
            let startX, startY, initialLeft, initialTop;

            // Check if page is scrollable
            function checkScrollable() {
                const isScrollable = document.documentElement.scrollHeight > window.innerHeight;
                if (!isScrollable) {
                    toggleBtn.classList.add('force-visible');
                } else {
                    toggleBtn.classList.remove('force-visible');
                }
            }

            // Initial check and on resize
            checkScrollable();
            window.addEventListener('resize', checkScrollable);

            // Scroll Observer
            if (header && toggleBtn) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        // Only apply scroll logic if not forced visible (not short page)
                        if (!toggleBtn.classList.contains('force-visible')) {
                            if (!entry.isIntersecting) {
                                toggleBtn.classList.add('visible-scroll');
                            } else {
                                toggleBtn.classList.remove('visible-scroll');
                            }
                        }
                    });
                }, { threshold: 0 });

                observer.observe(header);
            }

            // Draggable Logic
            function handleStart(e) {
                isDragging = true;
                toggleBtn.classList.add('dragging');
                
                const clientX = e.type === 'touchstart' ? e.touches[0].clientX : e.clientX;
                const clientY = e.type === 'touchstart' ? e.touches[0].clientY : e.clientY;
                
                const rect = toggleBtn.getBoundingClientRect();
                startX = clientX - rect.left;
                startY = clientY - rect.top;
            }

            function handleMove(e) {
                if (!isDragging) return;
                e.preventDefault(); // Prevent scrolling while dragging

                const clientX = e.type === 'touchmove' ? e.touches[0].clientX : e.clientX;
                const clientY = e.type === 'touchmove' ? e.touches[0].clientY : e.clientY;

                let newLeft = clientX - startX;
                let newTop = clientY - startY;

                // Boundary checks
                const maxX = window.innerWidth - toggleBtn.offsetWidth;
                const maxY = window.innerHeight - toggleBtn.offsetHeight;

                newLeft = Math.max(0, Math.min(newLeft, maxX));
                newTop = Math.max(0, Math.min(newTop, maxY));

                toggleBtn.style.left = `${newLeft}px`;
                toggleBtn.style.top = `${newTop}px`;
            }

            function handleEnd() {
                isDragging = false;
                toggleBtn.classList.remove('dragging');
            }

            // Touch events
            toggleBtn.addEventListener('touchstart', handleStart, { passive: false });
            document.addEventListener('touchmove', handleMove, { passive: false });
            document.addEventListener('touchend', handleEnd);

            // Mouse events (for testing on desktop)
            toggleBtn.addEventListener('mousedown', handleStart);
            document.addEventListener('mousemove', handleMove);
            document.addEventListener('mouseup', handleEnd);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @livewireScripts
    @stack('scripts')
</body>
</html>
