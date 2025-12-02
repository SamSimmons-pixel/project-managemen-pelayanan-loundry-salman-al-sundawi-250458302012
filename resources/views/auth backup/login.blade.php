<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loundrys'S - Laundry Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            /* Pink/White Laundry Theme */
            --primary: #b85c75;
            --primary-light: #d4899f;
            --primary-lighter: #f0e6eb;
            --background: #ffffff;
            --foreground: #1a1a1a;
            --border: #e8e8e8;
            --muted: #f5f5f5;
            --muted-foreground: #666666;
            --card: #ffffff;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', sans-serif;
            background-color: var(--background);
            color: var(--foreground);
            line-height: 1.6;
        }

        /* Header Styles */
        header {
            border-bottom: 1px solid var(--border);
            background-color: var(--card);
        }

        .header-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logo-icon {
            font-size: 1.5rem;
            color: var(--primary);
        }

        .logo-text {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--foreground);
        }

        nav {
            display: none;
            gap: 1.5rem;
            font-size: 0.875rem;
            color: var(--muted-foreground);
        }

        nav a {
            color: var(--muted-foreground);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: var(--foreground);
        }

        @media (min-width: 640px) {
            nav {
                display: flex;
            }
        }

        /* Main Content */
        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 1rem;
            min-height: calc(100vh - 200px);
        }

        /* Login Form Container */
        .login-container {
            width: 100%;
            max-width: 28rem;
        }

        /* Decorative Elements */
        .decorative-emojis {
            margin-bottom: 2rem;
            display: flex;
            justify-content: center;
            gap: 1rem;
            font-size: 2rem;
            opacity: 0.6;
        }

        .emoji {
            animation: bounce 1s infinite;
        }

        .emoji:nth-child(1) {
            animation-delay: 0s;
        }

        .emoji:nth-child(2) {
            animation-delay: 0.2s;
        }

        .emoji:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        /* Card Styles */
        .card {
            padding: 2rem;
            background-color: var(--card);
            border: 2px solid rgba(184, 92, 117, 0.2);
            border-radius: 0.625rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .card-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--foreground);
            margin-bottom: 0.5rem;
        }

        .card-subtitle {
            color: var(--muted-foreground);
            font-size: 0.875rem;
        }

        /* Form Styles */
        form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        label {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--foreground);
        }

        input {
            padding: 0.75rem;
            border: 2px solid rgba(184, 92, 117, 0.2);
            border-radius: 0.375rem;
            background-color: var(--primary-lighter);
            font-size: 1rem;
            transition: border-color 0.3s ease;
            font-family: inherit;
        }

        input:focus {
            outline: none;
            border-color: var(--primary);
        }

        input::placeholder {
            color: var(--muted-foreground);
        }

        /* Button Styles */
        button {
            padding: 0.75rem 1rem;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }

        button:hover:not(:disabled) {
            background-color: #a34a62;
            transform: scale(1.02);
        }

        button:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .button-content {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .spinner {
            display: inline-block;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        /* Card Divider */
        .card-divider {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(184, 92, 117, 0.1);
            text-align: center;
            font-size: 0.75rem;
            color: var(--muted-foreground);
        }

        /* Sign Up Link */
        .signup-section {
            margin-top: 1.5rem;
            text-align: center;
        }

        .signup-section p {
            font-size: 0.875rem;
            color: var(--muted-foreground);
        }

        .signup-section a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            transition: text-decoration 0.3s ease;
        }

        .signup-section a:hover {
            text-decoration: underline;
        }

        /* Bottom Text */
        .bottom-text {
            margin-top: 2rem;
            text-align: center;
            font-size: 0.875rem;
            color: var(--muted-foreground);
        }

        /* Footer Styles */
        footer {
            border-top: 1px solid var(--border);
            background-color: var(--card);
            margin-top: 3rem;
        }

        .footer-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        @media (min-width: 640px) {
            .footer-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .footer-section h3 {
            font-weight: 600;
            color: var(--foreground);
            margin-bottom: 1rem;
        }

        .footer-section p,
        .footer-section a {
            font-size: 0.875rem;
            color: var(--muted-foreground);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-section a:hover {
            color: var(--foreground);
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section li {
            margin-bottom: 0.5rem;
        }

        .footer-divider {
            border-top: 1px solid var(--border);
            padding-top: 2rem;
            text-align: center;
            font-size: 0.875rem;
            color: var(--muted-foreground);
        }

        /* Layout */
        html, body {
            height: 100%;
        }

        #app {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
    </style>
</head>
<body>
    <div id="app">
        <!-- Header -->
        <header>
            <div class="header-container">
                <div class="logo-section">
                    <div class="logo-icon">🧺</div>
                    <h1 class="logo-text">Loundrys'S</h1>
                </div>
                <nav>
                    <a href="#about">About</a>
                    <a href="#services">Services</a>
                    <a href="#contact">Contact</a>
                </nav>
            </div>
        </header>

        <!-- Main Content -->
        <main>
            <div class="login-container">
                <!-- Decorative Emojis -->
                <div class="decorative-emojis">
                    <span class="emoji">🧺</span>
                    <span class="emoji">✨</span>
                    <span class="emoji">🧺</span>
                </div>

                <!-- Login Card -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Welcome Back!</h2>
                        <p class="card-subtitle">Keep your laundry fresh and clean</p>
                    </div>

                    <form id="loginForm" method="POST" action="{{ route('auth.login') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                placeholder="example@gmail.com"
                                required
                                value="{{ old('email') }}"
                            />
                            @error('email')
                                <p style="color: red; font-size: 0.875rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                placeholder="••••••••"
                                required
                            />
                        </div>

                        <button type="submit" id="submitBtn">
                            <span class="button-content">
                                <span id="buttonText">Sign In</span>
                            </span>
                        </button>
                    </form>

                    <div class="signup-section">
                        <p>Don't have an account? <a href="#signup">Sign up</a></p>
                    </div>

                    <div class="card-divider">
                        ✨ Fresh, clean, and secure ✨
                    </div>
                </div>

                <!-- Bottom Text -->
                <div class="bottom-text">
                    Trusted by thousands of laundry lovers 🧼
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer>
            <div class="footer-container">
                <div class="footer-grid">
                    <div class="footer-section">
                        <h3>About</h3>
                        <p>Your trusted laundry service partner.</p>
                    </div>
                    <div class="footer-section">
                        <h3>Quick Links</h3>
                        <ul>
                            <li><a href="#services">Services</a></li>
                            <li><a href="#pricing">Pricing</a></li>
                            <li><a href="#faq">FAQ</a></li>
                        </ul>
                    </div>
                    <div class="footer-section">
                        <h3>Contact</h3>
                        <p>support@Loundryss.com</p>
                    </div>
                </div>
                <div class="footer-divider">
                    &copy; 2025 Loundryss. All rights reserved.
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Form submission handler
        const loginForm = document.getElementById('loginForm');
        const submitBtn = document.getElementById('submitBtn');
        const buttonText = document.getElementById('buttonText');

        loginForm.addEventListener('submit', function(e) {
            // Disable button and show loading state
            submitBtn.disabled = true;
            buttonText.innerHTML = '<span class="spinner">⏳</span> Logging in...';
        });
    </script>
</body>
</html>
