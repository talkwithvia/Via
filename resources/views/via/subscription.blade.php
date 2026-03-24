<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIA — Choose Your Membership</title>
    <meta name="description" content="Select a VIA membership and begin your journey.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
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

        body {
            background-color: var(--cream);
            font-family: 'Inter', system-ui, sans-serif;
            color: var(--slate);
            min-height: 100vh;
        }

        /* ── Navigation ── */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2.5rem;
            height: 56px;
            background: rgba(249, 248, 246, 0.92);
            backdrop-filter: blur(12px);
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
            color: var(--slate-mid);
            text-decoration: none;
            transition: color 0.2s;
        }

        .nav-center a:hover { color: var(--slate); }

        .nav-badge-tag {
            font-size: 0.65rem;
            background: var(--cream-dark);
            color: var(--muted);
            border: 1px solid var(--border);
            border-radius: 999px;
            padding: 0.15rem 0.6rem;
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

        /* ── Page Content ── */
        .page {
            max-width: 1100px;
            margin: 0 auto;
            padding: 4rem 2rem 6rem;
        }

        /* ── Back link ── */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.8rem;
            color: var(--muted);
            text-decoration: none;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 3rem;
            transition: color 0.2s;
        }

        .back-link:hover { color: var(--terra); }

        /* ── Page Header ── */
        .page-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .page-eyebrow {
            font-size: 0.72rem;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            color: var(--terra);
            margin-bottom: 0.8rem;
        }

        .page-title {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 400;
            color: var(--slate);
            margin-bottom: 0.8rem;
        }

        .page-sub {
            font-size: 0.9rem;
            color: var(--muted);
            max-width: 480px;
            margin: 0 auto;
            line-height: 1.7;
        }

        /* ── Pricing Grid ── */
        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            align-items: stretch;
        }

        /* ── Price Card ── */
        .price-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 2.2rem 2rem;
            position: relative;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            /* Entrance animation */
            opacity: 0;
            transform: translateY(20px);
            animation: cardIn 0.6s ease-out forwards;
            transition: box-shadow 0.25s, transform 0.25s, border-color 0.25s;
        }

        .price-card:nth-child(1) { animation-delay: 0.1s; }
        .price-card:nth-child(2) { animation-delay: 0.2s; }
        .price-card:nth-child(3) { animation-delay: 0.3s; }

        @keyframes cardIn {
            to { opacity: 1; transform: translateY(0); }
        }

        .price-card:hover {
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
            transform: translateY(-4px);
            border-color: #c5c8ce;
        }

        /* Featured card */
        .price-card.featured {
            border-color: var(--terra);
            box-shadow: 0 4px 20px rgba(178, 115, 77, 0.15);
        }

        .price-card.featured:hover {
            box-shadow: 0 12px 35px rgba(178, 115, 77, 0.2);
            border-color: var(--terra);
        }

        /* ── Card Header ── */
        .card-name {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 1.5rem;
            font-weight: 500;
            color: var(--slate);
            margin-bottom: 0.25rem;
        }

        .card-tagline {
            font-size: 0.8rem;
            color: var(--muted);
            margin-bottom: 1.5rem;
        }

        /* ── Price display ── */
        .card-price {
            margin-bottom: 1.8rem;
        }

        .price-amount {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 2.8rem;
            font-weight: 400;
            color: var(--terra);
            line-height: 1;
        }

        .price-amount sup {
            font-size: 1.1rem;
            vertical-align: super;
        }

        .price-period {
            font-size: 0.8rem;
            color: var(--muted);
            margin-top: 0.2rem;
        }

        /* ── Features list ── */
        .features-list {
            list-style: none;
            margin-bottom: 2rem;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
        }

        .features-list li {
            font-size: 0.85rem;
            color: var(--slate-mid);
            display: flex;
            align-items: flex-start;
            gap: 0.6rem;
            line-height: 1.5;
        }

        .features-list li::before {
            content: '·';
            color: var(--terra);
            font-size: 1.2rem;
            line-height: 1.1;
            flex-shrink: 0;
        }

        /* ── CTA Button ── */
        .btn-join {
            display: block;
            width: 100%;
            text-align: center;
            text-decoration: none;
            padding: 0.9rem 1.5rem;
            border-radius: 8px;
            font-family: 'Inter', sans-serif;
            font-size: 0.88rem;
            font-weight: 500;
            border: 1px solid var(--slate);
            background: transparent;
            color: var(--slate);
            cursor: pointer;
            transition: background 0.2s, color 0.2s, transform 0.15s;
            margin-top: auto;
        }

        .btn-join:hover {
            background: var(--slate);
            color: var(--white);
            transform: translateY(-1px);
        }

        .price-card.featured .btn-join {
            background: var(--terra);
            color: var(--white);
            border-color: var(--terra);
        }

        .price-card.featured .btn-join:hover {
            background: var(--terra-dark);
            border-color: var(--terra-dark);
        }

        /* ── Footer note ── */
        .page-footer {
            text-align: center;
            margin-top: 2.5rem;
            font-size: 0.78rem;
            color: var(--muted);
        }

        @media (max-width: 900px) {
            .pricing-grid { grid-template-columns: 1fr; max-width: 480px; margin: 0 auto; }
            .nav-center { display: none; }
            .navbar { padding: 0 1.2rem; }
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar">
        <a href="/" class="nav-logo">V I A</a>
        <div class="nav-center">
            <a href="/subscribe" style="color:var(--slate);font-weight:500;">Explore Opportunities</a>
            <a href="#">Store</a>
            <a href="#">Mentorship</a>
            <a href="#">Blog</a>
            <span style="display:flex;align-items:center;gap:0.5rem;">
                <a href="#">Events</a>
                <span class="nav-badge-tag">Coming Soon</span>
            </span>
        </div>
        <div class="nav-right">
            <a href="#">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <path d="M16 10a4 4 0 0 1-8 0"/>
                </svg>
                Cart
            </a>
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

    <div class="page">

        <!-- Back link -->
        <a href="/" class="back-link">
            <svg width="14" height="14" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M10 12L6 8l4-4" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Back
        </a>

        <!-- Page header -->
        <header class="page-header">
            <p class="page-eyebrow">Membership</p>
            <h1 class="page-title">Access VIA</h1>
            <p class="page-sub">Choose the membership that fits your journey. Cancel anytime.</p>
        </header>

        <!-- Pricing Cards -->
        <div class="pricing-grid">

            <!-- Basic -->
            <div class="price-card">
                <div class="card-name">Via Basic</div>
                <div class="card-tagline">Entry to the ecosystem</div>

                <div class="card-price">
                    <div class="price-amount">500/=</div>
                    <div class="price-period">/month</div>
                </div>

                <ul class="features-list">
                    <li>Educational content access</li>
                    <li>Community forums</li>
                    <li>Weekly insights</li>
                </ul>

                <a href="/create-account?plan=basic" class="btn-join" id="join-basic">Get Started</a>
            </div>

            <!-- Core — Featured -->
            <div class="price-card featured">
                <div class="card-name">Via Core</div>
                <div class="card-tagline">Tools and guidance</div>

                <div class="card-price">
                    <div class="price-amount">1,200/=</div>
                    <div class="price-period">/month</div>
                </div>

                <ul class="features-list">
                    <li>Everything in Basic</li>
                    <li>Curated opportunities</li>
                    <li>Group mentorship sessions</li>
                    <li>Product guidance</li>
                </ul>

                <a href="/create-account?plan=core" class="btn-join" id="join-core">Get Started</a>
            </div>

            <!-- Circle -->
            <div class="price-card">
                <div class="card-name">Via Circle</div>
                <div class="card-tagline">Personal mentorship</div>

                <div class="card-price">
                    <div class="price-amount">15,000/=</div>
                    <div class="price-period">/month</div>
                </div>

                <ul class="features-list">
                    <li>Everything in Core</li>
                    <li>One-on-one mentorship</li>
                    <li>Career guidance</li>
                    <li>Equity participation</li>
                </ul>

                <a href="/create-account?plan=circle" class="btn-join" id="join-circle">Get Started</a>
            </div>

        </div><!-- /pricing-grid -->

        <p class="page-footer">Cancel anytime. No lock-in contracts.</p>

    </div><!-- /page -->

</body>
</html>
