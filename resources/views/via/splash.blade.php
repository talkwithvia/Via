<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIA — Navigate Your Odyssey</title>
    <meta name="description" content="VIA is a system designed around movement. Explore opportunities, grow your path forward.">

    <!-- Google Fonts: Cormorant Garamond for headings, Inter for body -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        /* ── Reset & Base ── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --cream:      #f9f8f6;
            --cream-dark: #f0ede8;
            --slate:      #21242c;
            --slate-mid:  #4a5568;
            --muted:      #6b7280;
            --terra:      #b2734d;
            --terra-dark: #8f5a3a;
            --border:     #dee0e4;
            --white:      #ffffff;
        }

        html { scroll-behavior: smooth; }

        body {
            background-color: var(--cream);
            font-family: 'Inter', system-ui, sans-serif;
            color: var(--slate);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* ── Navigation ── */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2.5rem;
            height: 56px;
            background: rgba(249, 248, 246, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(222, 224, 228, 0.6);
        }

        .nav-logo {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 1.3rem;
            font-weight: 500;
            letter-spacing: 0.25em;
            color: var(--slate);
            text-decoration: none;
        }

        .nav-center {
            display: flex;
            align-items: center;
            gap: 2.5rem;
        }

        .nav-center a {
            font-size: 0.85rem;
            font-weight: 400;
            color: var(--slate-mid);
            text-decoration: none;
            letter-spacing: 0.02em;
            transition: color 0.2s;
        }

        .nav-center a:hover { color: var(--slate); }

        .nav-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .coming-soon-tag {
            font-size: 0.65rem;
            background: var(--cream-dark);
            color: var(--muted);
            border: 1px solid var(--border);
            border-radius: 999px;
            padding: 0.15rem 0.6rem;
            letter-spacing: 0.03em;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .nav-right a {
            font-size: 0.85rem;
            color: var(--slate-mid);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            transition: color 0.2s;
        }

        .nav-right a:hover { color: var(--slate); }

        /* ── Hero Section ── */
        .hero {
            position: relative;
            width: 100%;
            height: 100vh;
            min-height: 600px;
            overflow: hidden;
        }

        /* Background Image with overlay */
        .hero-bg {
            position: absolute;
            inset: 0;
            background-image: url('https://images.unsplash.com/photo-1555636222-cae831e670b3?w=1800&q=85&auto=format');
            background-size: cover;
            background-position: center 20%;
            filter: brightness(0.72) sepia(0.15);
        }

        /* Gradient overlay for text readability */
        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                to bottom,
                rgba(33, 36, 44, 0.2) 0%,
                rgba(33, 36, 44, 0.35) 50%,
                rgba(33, 36, 44, 0.5) 100%
            );
        }

        .hero-content {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            text-align: center;
            padding: 0 1.5rem;
        }

        .hero-title {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: clamp(4rem, 10vw, 9rem);
            font-weight: 500;
            font-style: italic;
            color: var(--white);
            line-height: 0.95;
            letter-spacing: -0.01em;
            margin-bottom: 1.2rem;
            text-shadow: 0 2px 40px rgba(0,0,0,0.3);
        }

        .hero-subtitle {
            font-size: clamp(0.75rem, 1.5vw, 0.92rem);
            font-weight: 400;
            color: rgba(255, 255, 255, 0.85);
            letter-spacing: 0.3em;
            text-transform: uppercase;
            margin-bottom: 2.5rem;
        }

        .btn-hero {
            display: inline-block;
            background-color: var(--terra);
            color: var(--white);
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            text-decoration: none;
            padding: 0.9rem 2.2rem;
            border-radius: 999px;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.2s;
        }

        .btn-hero:hover {
            background-color: var(--terra-dark);
            transform: translateY(-1px);
        }

        /* ── Section Base ── */
        section {
            padding: 6rem 2rem;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
        }

        /* ── "VIA Is Not A Product" Section ── */
        .section-statement {
            background: var(--cream);
            text-align: center;
        }

        .statement-title {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: clamp(2.2rem, 5vw, 3.5rem);
            font-weight: 500;
            color: var(--slate);
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 2.5rem;
        }

        .statement-body {
            max-width: 640px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
        }

        .statement-body p {
            font-size: 1rem;
            color: var(--slate-mid);
            line-height: 1.75;
        }

        .statement-body .bold-line {
            font-weight: 600;
            color: var(--slate);
        }

        /* Three pillars: LEARN / DO / GROW */
        .pillars {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-top: 5rem;
            text-align: center;
        }

        .pillar-title {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 1.8rem;
            font-weight: 400;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--slate);
            margin-bottom: 0.8rem;
        }

        .pillar-desc {
            font-size: 0.88rem;
            color: var(--muted);
            line-height: 1.6;
        }

        /* ── Journey Section ── */
        .section-journey {
            background: var(--cream-dark);
            text-align: center;
        }

        .section-heading {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 400;
            color: var(--slate);
            margin-bottom: 0.75rem;
        }

        .section-subheading {
            font-size: 0.9rem;
            color: var(--muted);
            margin-bottom: 4rem;
        }

        /* 4-step journey grid */
        .journey-steps {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            position: relative;
        }

        /* Connector lines between steps */
        .journey-steps::before {
            content: '';
            position: absolute;
            top: 1.8rem;
            left: calc(12.5% + 1rem);
            right: calc(12.5% + 1rem);
            height: 1px;
            background: linear-gradient(to right, var(--terra) 0%, rgba(178, 115, 77, 0.3) 100%);
        }

        .journey-step {
            text-align: center;
            padding-top: 0.5rem;
        }

        .step-number {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 2.5rem;
            font-weight: 300;
            color: var(--terra);
            opacity: 0.6;
            line-height: 1;
            margin-bottom: 1rem;
        }

        .step-title {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 1.3rem;
            font-weight: 500;
            color: var(--slate);
            margin-bottom: 0.6rem;
        }

        .step-desc {
            font-size: 0.82rem;
            color: var(--muted);
            line-height: 1.6;
        }

        /* ── Access/Pricing Section ── */
        .section-access {
            background: var(--cream);
            text-align: center;
        }

        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-top: 3.5rem;
            align-items: start;
        }

        .price-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 2rem;
            text-align: left;
            transition: box-shadow 0.25s, transform 0.25s;
        }

        .price-card:hover {
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
            transform: translateY(-3px);
        }

        /* Highlighted center card */
        .price-card.featured {
            border-color: var(--terra);
            background: var(--white);
            box-shadow: 0 4px 20px rgba(178, 115, 77, 0.12);
        }

        .price-card-name {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 1.4rem;
            font-weight: 500;
            color: var(--slate);
            margin-bottom: 0.25rem;
        }

        .price-card-tagline {
            font-size: 0.8rem;
            color: var(--muted);
            margin-bottom: 1.5rem;
        }

        .price-amount {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 2.5rem;
            font-weight: 400;
            color: var(--terra);
            line-height: 1;
            margin-bottom: 0.3rem;
        }

        .price-amount span {
            font-size: 1rem;
            font-weight: 300;
        }

        .price-period {
            font-size: 0.8rem;
            color: var(--muted);
            margin-bottom: 1.8rem;
        }

        .price-features {
            list-style: none;
            margin-bottom: 2rem;
            display: flex;
            flex-direction: column;
            gap: 0.55rem;
        }

        .price-features li {
            font-size: 0.85rem;
            color: var(--slate-mid);
            display: flex;
            align-items: flex-start;
            gap: 0.6rem;
        }

        .price-features li::before {
            content: '·';
            color: var(--terra);
            font-weight: bold;
            flex-shrink: 0;
        }

        .btn-pricing {
            display: block;
            width: 100%;
            text-align: center;
            padding: 0.85rem 1.5rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            border: 1px solid var(--slate);
            background: transparent;
            color: var(--slate);
            transition: background 0.2s, color 0.2s, transform 0.2s;
        }

        .btn-pricing:hover {
            background: var(--slate);
            color: var(--white);
            transform: translateY(-1px);
        }

        .btn-pricing.featured {
            background: var(--terra);
            color: var(--white);
            border-color: var(--terra);
        }

        .btn-pricing.featured:hover {
            background: var(--terra-dark);
            border-color: var(--terra-dark);
        }

        /* ── Footer ── */
        .site-footer {
            background: var(--cream-dark);
            border-top: 1px solid var(--border);
            padding: 3rem 2rem;
            text-align: center;
        }

        .footer-logo {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 1.4rem;
            font-weight: 400;
            letter-spacing: 0.3em;
            color: var(--slate);
            margin-bottom: 1rem;
            display: block;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
            margin-bottom: 2rem;
        }

        .footer-links a {
            font-size: 0.8rem;
            color: var(--muted);
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-links a:hover { color: var(--slate); }

        .footer-copy {
            font-size: 0.75rem;
            color: rgba(107, 114, 128, 0.6);
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .nav-center { display: none; }
            .navbar { padding: 0 1.2rem; }

            .hero-title { font-size: clamp(3rem, 12vw, 5rem); }

            .pillars { grid-template-columns: 1fr; gap: 2.5rem; }
            .journey-steps { grid-template-columns: 1fr 1fr; gap: 2rem; }
            .journey-steps::before { display: none; }
            .pricing-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <!-- ── Navigation ── -->
    <nav class="navbar">
        <a href="/" class="nav-logo">V I A</a>

        <div class="nav-center">
            <a href="/subscribe">Explore Opportunities</a>
            <a href="/store">Store</a>
            <a href="#">Community</a>
            <a href="#">Blog</a>
            <span class="nav-badge">
                <a href="#">Events</a>
                <span class="coming-soon-tag">Coming Soon</span>
            </span>
        </div>

        <div class="nav-right">
            <!-- Cart icon -->
            <a href="#">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <path d="M16 10a4 4 0 0 1-8 0"/>
                </svg>
                Cart
            </a>
            <!-- Login icon -->
            <a href="/login">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                    <polyline points="10 17 15 12 10 7"/>
                    <line x1="15" y1="12" x2="3" y2="12"/>
                </svg>
                Login
            </a>
        </div>
    </nav>

    <!-- ── Hero ── -->
    <section class="hero">
        <div class="hero-bg"></div>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1 class="hero-title">VIVA LA VIA</h1>
            <p class="hero-subtitle">Navigate Your Odyssey</p>
            <a href="/subscribe" class="btn-hero">Explore Opportunities</a>
        </div>
    </section>

    <!-- ── VIA Is Not A Product ── -->
    <section class="section-statement">
        <div class="container">
            <h2 class="statement-title">VIA Is Not A Product</h2>
            <div class="statement-body">
                <p>It's a system designed around movement.</p>
                <p>A quiet place where exploration meets opportunity, where curiosity becomes skill, and where personal growth unfolds at your own pace.</p>
                <p>We believe the path forward isn't always clear—and that's okay.</p>
                <p class="bold-line">VIA exists to help you find it.</p>
            </div>

            <!-- LEARN / DO / GROW pillars -->
            <div class="pillars">
                <div class="pillar">
                    <div class="pillar-title">Learn</div>
                    <p class="pillar-desc">Gain knowledge, skills, and insights</p>
                </div>
                <div class="pillar">
                    <div class="pillar-title">Do</div>
                    <p class="pillar-desc">Apply learning, build experience, create</p>
                </div>
                <div class="pillar">
                    <div class="pillar-title">Grow</div>
                    <p class="pillar-desc">Advance career, expand horizons</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ── Your Journey ── -->
    <section class="section-journey">
        <div class="container">
            <h2 class="section-heading">Your Journey</h2>
            <p class="section-subheading">A natural progression. No rush. Just forward motion.</p>

            <div class="journey-steps">
                <div class="journey-step">
                    <div class="step-number">01</div>
                    <div class="step-title">Discover</div>
                    <p class="step-desc">Explore possibilities. Understand what resonates with you.</p>
                </div>
                <div class="journey-step">
                    <div class="step-number">02</div>
                    <div class="step-title">Engage</div>
                    <p class="step-desc">Learn, connect, and begin building your foundation.</p>
                </div>
                <div class="journey-step">
                    <div class="step-number">03</div>
                    <div class="step-title">Build</div>
                    <p class="step-desc">Apply knowledge. Create something meaningful.</p>
                </div>
                <div class="journey-step">
                    <div class="step-number">04</div>
                    <div class="step-title">Grow</div>
                    <p class="step-desc">Expand your reach. Let momentum carry you forward.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ── Access / Pricing ── -->
    <section class="section-access">
        <div class="container">
            <h2 class="section-heading">Access VIA</h2>
            <p class="section-subheading">Choose the membership that fits your journey.</p>

            <div class="pricing-grid">
                <!-- Basic -->
                <div class="price-card">
                    <div class="price-card-name">Via Basic</div>
                    <div class="price-card-tagline">Entry to the ecosystem</div>
                    <div class="price-amount">500<span>/=</span></div>
                    <div class="price-period">/month</div>
                    <ul class="price-features">
                        <li>Educational content access</li>
                        <li>Community forums</li>
                        <li>Weekly insights</li>
                    </ul>
                    <a href="/create-account?plan=basic" class="btn-pricing">Get Started</a>
                </div>

                <!-- Core — Featured -->
                <div class="price-card featured">
                    <div class="price-card-name">Via Core</div>
                    <div class="price-card-tagline">Tools and guidance</div>
                    <div class="price-amount">1,200<span>/=</span></div>
                    <div class="price-period">/month</div>
                    <ul class="price-features">
                        <li>Everything in Basic</li>
                        <li>Curated opportunities</li>
                        <li>Group community sessions</li>
                        <li>Product guidance</li>
                    </ul>
                    <a href="/create-account?plan=core" class="btn-pricing featured">Get Started</a>
                </div>

                <!-- Circle -->
                <div class="price-card">
                    <div class="price-card-name">Via Circle</div>
                    <div class="price-card-tagline">Personal community</div>
                    <div class="price-amount">15,000<span>/=</span></div>
                    <div class="price-period">/month</div>
                    <ul class="price-features">
                        <li>Everything in Core</li>
                        <li>One-on-one community</li>
                        <li>Career guidance</li>
                        <li>Equity participation</li>
                    </ul>
                    <a href="/create-account?plan=circle" class="btn-pricing">Get Started</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ── Footer ── -->
    <footer class="site-footer">
        <span class="footer-logo">V I A</span>
        <div class="footer-links">
            <a href="/subscribe">Explore Opportunities</a>
            <a href="#">Store</a>
            <a href="#">Community</a>
            <a href="#">Blog</a>
            <a href="#">Events</a>
            <a href="#">Privacy</a>
            <a href="#">Terms</a>
        </div>
        <p class="footer-copy">&copy; {{ date('Y') }} VIA. All rights reserved.</p>
    </footer>

</body>
</html>
