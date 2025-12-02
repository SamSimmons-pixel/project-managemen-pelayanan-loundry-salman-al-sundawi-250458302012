<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loundrys'S - Laundry Made Fun!</title>
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
            --accent: #FFD700;
            /* A pop of gold for fun! */
            --accent-light: #FFFACD;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', sans-serif;
            background-color: var(--background);
            color: var(--foreground);
            line-height: 1.6;
        }

        /* Utility Classes */
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .text-center {
            text-align: center;
        }

        .py-12 {
            padding-top: 3rem;
            padding-bottom: 3rem;
        }

        .py-24 {
            padding-top: 6rem;
            padding-bottom: 6rem;
        }

        /* Header Styles */
        header {
            border-bottom: 1px solid var(--border);
            background-color: var(--card);
            padding: 1rem 0;
        }

        .header-container {
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
            text-decoration: none;
        }

        .logo-text {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--foreground);
            text-decoration: none;
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

        .nav-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn {
            padding: 0.75rem 1.25rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: #a34a62;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-secondary:hover {
            background-color: var(--primary-lighter);
            transform: translateY(-2px);
        }

        @media (min-width: 640px) {
            nav {
                display: flex;
            }
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-lighter) 0%, var(--background) 100%);
            text-align: center;
            padding: 6rem 1.5rem;
            overflow: hidden;
            position: relative;
        }

        .hero-section::before,
        .hero-section::after {
            content: '🧼';
            position: absolute;
            font-size: 4rem;
            opacity: 0.1;
            animation: float 6s infinite ease-in-out;
        }

        .hero-section::before {
            top: 10%;
            left: 5%;
            animation-delay: 0s;
        }

        .hero-section::after {
            bottom: 15%;
            right: 8%;
            content: '🫧';
            animation-delay: 3s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(10deg);
            }
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 1rem;
            line-height: 1.1;
            letter-spacing: -0.05em;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.05);
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: var(--foreground);
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-cta {
            display: inline-flex;
            gap: 1rem;
        }

        /* Features Section */
        .features-section {
            padding: 4rem 0;
            background-color: var(--card);
            border-top: 1px solid var(--border);
        }

        .features-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            text-align: center;
        }

        @media (min-width: 768px) {
            .features-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .features-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .feature-card {
            padding: 2rem;
            background-color: var(--primary-lighter);
            border-radius: 0.75rem;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .feature-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.12);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: inline-block;
            animation: pulse 1.5s infinite ease-in-out;
        }

        .feature-card:nth-child(1) .feature-icon {
            animation-delay: 0s;
        }

        .feature-card:nth-child(2) .feature-icon {
            animation-delay: 0.3s;
        }

        .feature-card:nth-child(3) .feature-icon {
            animation-delay: 0.6s;
        }

        .feature-card:nth-child(4) .feature-icon {
            animation-delay: 0.9s;
        }


        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .feature-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.75rem;
        }

        .feature-description {
            color: var(--muted-foreground);
            font-size: 0.95rem;
        }

        /* How It Works Section */
        .how-it-works-section {
            padding: 4rem 0;
            background-color: var(--background);
            border-top: 1px solid var(--border);
        }

        .how-it-works-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 3rem;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 3rem;
            position: relative;
        }

        @media (min-width: 768px) {
            .steps-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .steps-grid::before {
                content: '';
                position: absolute;
                top: 50px;
                left: 10%;
                right: 10%;
                height: 4px;
                background: linear-gradient(to right, var(--primary-light), var(--primary));
                z-index: 0;
            }
        }

        .step-card {
            text-align: center;
            position: relative;
            padding: 1.5rem;
            background-color: var(--card);
            border-radius: 0.75rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            z-index: 1;
            transition: transform 0.3s ease;
        }

        .step-card:hover {
            transform: translateY(-8px);
        }

        .step-number {
            font-size: 2rem;
            font-weight: 800;
            color: var(--accent);
            background-color: var(--primary);
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            border: 4px solid var(--primary-light);
            box-shadow: 0 0 0 5px var(--primary-lighter);
        }

        .step-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--foreground);
            margin-bottom: 0.5rem;
        }

        .step-description {
            color: var(--muted-foreground);
            font-size: 0.9rem;
        }

        /* Testimonials Section */
        .testimonials-section {
            padding: 4rem 0;
            background-color: var(--primary-lighter);
            border-top: 1px solid var(--border);
        }

        .testimonials-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 3rem;
        }

        .testimonial-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        @media (min-width: 768px) {
            .testimonial-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .testimonial-card {
            background-color: var(--card);
            padding: 2rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            gap: 1rem;
            position: relative;
        }

        .testimonial-quote {
            font-size: 1.1rem;
            font-style: italic;
            color: var(--foreground);
            margin-bottom: 1rem;
        }

        .testimonial-author {
            font-weight: 600;
            color: var(--primary);
        }

        .testimonial-source {
            font-size: 0.85rem;
            color: var(--muted-foreground);
        }

        .testimonial-card::before {
            content: '💬';
            position: absolute;
            top: -20px;
            left: 20px;
            font-size: 3rem;
            opacity: 0.1;
        }

        /* Call To Action Section */
        .cta-section {
            background: var(--primary);
            color: white;
            padding: 4rem 1.5rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before,
        .cta-section::after {
            content: '🌟';
            position: absolute;
            font-size: 4rem;
            opacity: 0.2;
            animation: rotateAndScale 8s infinite ease-in-out;
        }

        .cta-section::before {
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .cta-section::after {
            bottom: 25%;
            right: 15%;
            content: '🥳';
            animation-delay: 4s;
        }

        @keyframes rotateAndScale {

            0%,
            100% {
                transform: scale(1) rotate(0deg);
            }

            50% {
                transform: scale(1.1) rotate(15deg);
            }
        }

        .cta-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        }

        .cta-subtitle {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-button {
            display: inline-block;
            background-color: var(--accent);
            color: var(--primary);
            padding: 1rem 2rem;
            border-radius: 0.75rem;
            font-size: 1.2rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .cta-button:hover {
            background-color: #FFEB3B;
            transform: translateY(-3px) scale(1.03);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        }


        /* Footer Styles */
        footer {
            border-top: 1px solid var(--border);
            background-color: var(--card);
            padding: 2rem 0;
            margin-top: 0;
            /* Remove top margin as sections handle spacing */
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
        html,
        body {
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

        <header>
            <div class="container header-container">
                <div class="logo-section">
                    <a href="{{ Auth::check() ? route('user.menu') : '/' }}" class="logo-icon">🧺</a>
                    <a href="{{ Auth::check() ? route('user.menu') : '/' }}" class="logo-text">Loundrys'S</a>
                </div>
                <nav>
                    <a href="#features">Features</a>
                    <a href="#how-it-works">How It Works</a>
                    <a href="#testimonials">Testimonials</a>
                    <a href="#contact">Contact</a>
                </nav>
                <div class="{{ Auth::check() ? '' : 'nav-buttons' }}">
                    <a href="{{ route('login') }}"
                        class="{{ Auth::check() ? '' : 'btn btn-secondary' }}">{{ Auth::check() ? '' : 'Login' }}</a>
                    <a href="{{ route('signup') }}"
                        class="{{ Auth::check() ? '' : 'btn btn-secondary' }}">{{ Auth::check() ? '' : 'Register' }}</a>
                    <a href="{{ route('auth.logout') }}"
                        class="{{ Auth::check() ? 'btn btn-secondary' : '' }}">{{ Auth::check() ? 'Log out' : '' }}</a>
                </div>
            </div>
        </header>


        <main>

            <section class="hero-section">
                <div class="container">
                    <h2 class="hero-title">Say Goodbye to Laundry Day Blues! <span style="font-size: 0.8em;">🥳</span>
                    </h2>
                    <p class="hero-subtitle">Loundrys'S takes the chore out of laundry, delivering sparkling clean
                        clothes right to your door. More free time, more fun!</p>
                    <div class="hero-cta">
                        <a href="#signup" class="btn btn-primary">Get Started Now!</a>
                        <a href="#how-it-works" class="btn btn-secondary">Learn More ✨</a>
                    </div>
                </div>
            </section>


            <section id="features" class="features-section">
                <div class="container">
                    <h2 class="how-it-works-title text-center">Packed with Powerful (and Fun!) Features</h2>
                    <div class="features-grid">
                        <div class="feature-card">
                            <div class="feature-icon">🤔</div>
                            <h3 class="feature-title">Laundry, Your Way</h3>
                            <p class="feature-description">Need us to do it all? Order online! Prefer DIY? Rent a
                                machine on-site. The choice is yours!</p>
                        </div>
                        <div class="feature-card">
                            <div class="feature-icon">📍</div>
                            <h3 class="feature-title">Track Every Tumble</h3>
                            <p class="feature-description">Follow your online order from pickup to "Clean!" or check
                                live machine availability at our location.</p>
                        </div>
                        <div class="feature-card">
                            <div class="feature-icon">🎮</div>
                            <h3 class="feature-title">Play While You Wait!</h3>
                            <p class="feature-description">Don't just wait, play! Enjoy fun games on our website while
                                your on-site laundry gets done. Erase the boredom!</p>
                        </div>
                    </div>
                </div>
            </section>


            <section id="how-it-works" class="how-it-works-section">
                <div class="container">
                    <h2 class="how-it-works-title text-center">Laundry Magic in 3 Simple Steps!</h2>
                    <div class="steps-grid">
                        <div class="step-card">
                            <div class="step-number">1</div>
                            <h3 class="step-title">Schedule Pickup 🗓️</h3>
                            <p class="step-description">Choose a convenient time for us to swing by and grab your dirty
                                laundry.</p>
                        </div>
                        <div class="step-card">
                            <div class="step-number">2</div>
                            <h3 class="step-title">We Work Our Magic 🫧</h3>
                            <p class="step-description">Our laundry pros clean, dry, and perfectly fold or hang your
                                garments.</p>
                        </div>
                        <div class="step-card">
                            <div class="step-number">3</div>
                            <h3 class="step-title">Fresh Delivery! 🚚</h3>
                            <p class="step-description">Your sparkling clean clothes are returned to your doorstep,
                                ready to wear.</p>
                        </div>
                    </div>
                </div>
            </section>


            <section id="testimonials" class="testimonials-section">
                <div class="container">
                    <h2 class="testimonials-title text-center">Hear From Our Happy Customers!</h2>
                    <div class="testimonial-grid">
                        <div class="testimonial-card">
                            <p class="testimonial-quote">"Loundrys'S has changed my life! I used to dread laundry day,
                                now I just click a button and my clothes come back perfect. Highly recommend! 🌟"</p>
                            <p class="testimonial-author">Sarah L.</p>
                            <p class="testimonial-source">Busy Mom</p>
                        </div>
                        <div class="testimonial-card">
                            <p class="testimonial-quote">"The clothes are always immaculately clean and smell amazing.
                                Plus, the convenience is unbeatable. It's like having a personal laundry fairy! ✨"</p>
                            <p class="testimonial-author">Mark T.</p>
                            <p class="testimonial-source">Tech Professional</p>
                        </div>
                    </div>
                </div>
            </section>


            <section class="cta-section">
                <div class="container">
                    <h2 class="cta-title">Ready for a Laundry Service?</h2>
                    <p class="cta-subtitle">Stop wasting time on chores and start enjoying life! Loundrys'S is here to
                        make laundry day your favorite day.</p>
                    <a href="#signup" class="cta-button">Sign Up & Get Fresh Today!</a>
                </div>
            </section>
        </main>


        <footer>
                <div class="footer-grid" style="margin-left: 8%">
                <div class="footer-section">
                    <h3>About</h3>
                    <p>Loundrys'S makes laundry easy, fun, and eco-friendly. We're here to give you back your
                        precious time!</p>
                </div>
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="#features">Our Features</a></li>
                        <li><a href="#how-it-works">How It Works</a></li>
                        <li><a href="#testimonials">Happy Stories</a></li>
                        <li><a href="#contact">Contact Us</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Connect</h3>
                    <p>Email: <a href="mailto:hello@loundryss.com">hello@loundryss.com</a></p>
                    <p>Phone: (123) 456-7890</p>
                    <p>Follow us on social media for fresh updates!</p>
                </div>
            </div>
            <div class="footer-divider">
                &copy; 2025 Loundrys'S. All rights reserved.
            </div>
        </footer>
    </div>
</body>

</html>
