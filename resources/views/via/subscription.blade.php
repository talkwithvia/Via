<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIA — Choose Your Membership</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        /* ── Reset & Base ── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --gold:       #D2A850;
            --gold-light: #b08a1e;
            --gold-dim:   rgba(210,168,80,0.18);
            --dark:       #FDFDFD;
            --dark-mid:   #F5F5F5;
            --white:      #1A1A1A;
            --muted:      #666666;
        }

        body {
            background: var(--dark);
            font-family: 'Inter', sans-serif;
            color: var(--white);
            min-height: 100vh;
        }

        /* ── Subtle radial glow at top ── */
        body::before {
            content: '';
            position: fixed;
            top: -20%;
            left: 50%;
            transform: translateX(-50%);
            width: 80vw;
            height: 60vh;
            background: radial-gradient(ellipse, rgba(210,168,80,0.15) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        /* ── Faint VIA watermark ── */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(12rem, 40vw, 28rem);
            font-weight: 300;
            letter-spacing: 0.3em;
            color: #F0F0F0;
            user-select: none;
            pointer-events: none;
            z-index: 0;
            filter: blur(1px);
        }

        /* ── Page wrapper ── */
        .page {
            position: relative;
            z-index: 1;
            max-width: 1100px;
            margin: 0 auto;
            padding: 4rem 1.5rem 5rem;
        }

        /* ── Tiny back nav ── */
        .back-nav {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--muted);
            font-size: 0.75rem;
            letter-spacing: 0.06em;
            text-decoration: none;
            text-transform: uppercase;
            margin-bottom: 3.5rem;
            transition: color 0.2s;
        }
        .back-nav:hover { color: var(--gold); }
        .back-nav svg { width: 14px; height: 14px; }

        /* ── Page header ── */
        .page-header {
            text-align: center;
            margin-bottom: 3.5rem;
        }

        .page-eyebrow {
            font-size: 0.68rem;
            letter-spacing: 0.35em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 0.9rem;
        }

        .page-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2rem, 5vw, 3rem);
            font-weight: 400;
            color: var(--white);
            line-height: 1.15;
            margin-bottom: 1rem;
        }

        .page-sub {
            font-size: 0.85rem;
            font-weight: 300;
            color: var(--muted);
            max-width: 480px;
            margin: 0 auto;
            line-height: 1.7;
        }

        /* ── Cards grid ── */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.4rem;
            align-items: start;
        }

        /* ── Individual card ── */
        .plan-card {
            background: #FFFFFF;
            border: 1px solid rgba(210,168,80,0.3);
            border-radius: 18px;
            padding: 2.2rem 2rem;
            position: relative;
            cursor: pointer;
            /* Fade-in + rise animation — staggered per card */
            opacity: 0;
            transform: translateY(24px);
            animation: cardRise 0.7s ease-out forwards;
            transition: transform 0.25s cubic-bezier(.2,.8,.3,1),
                        box-shadow 0.25s ease,
                        border-color 0.25s ease;
        }

        .plan-card:nth-child(1) { animation-delay: 0.15s; }
        .plan-card:nth-child(2) { animation-delay: 0.30s; }
        .plan-card:nth-child(3) { animation-delay: 0.45s; }

        @keyframes cardRise {
            0%   { opacity: 0; transform: translateY(24px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        /* Hover: card lifts */
        .plan-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.08), 0 0 20px rgba(210,168,80,0.15);
            border-color: rgba(210,168,80,0.5);
        }

        /* ── CORE card — highlighted ── */
        .plan-card.core {
            background: rgba(210,168,80,0.04);
            border-color: rgba(210,168,80,0.6);
            /* slightly "taller" via padding */
            padding-top: 2.6rem;
            padding-bottom: 2.6rem;
            box-shadow: 0 0 40px rgba(210,168,80,0.1), 0 0 80px rgba(210,168,80,0.05);
        }

        .plan-card.core:hover {
            box-shadow: 0 16px 40px rgba(0,0,0,0.1), 0 0 40px rgba(210,168,80,0.2);
        }

        /* Popular badge on Core card */
        .popular-badge {
            position: absolute;
            top: -14px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, var(--gold), #b08a1e);
            color: #0d0b08;
            font-size: 0.63rem;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            border-radius: 20px;
            padding: 0.3rem 1.1rem;
            white-space: nowrap;
        }

        /* ── Card tier label ── */
        .card-tier {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem;
            font-weight: 400;
            color: var(--white);
            margin-bottom: 0.25rem;
        }

        .card-tier-sub {
            font-size: 0.7rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 1.4rem;
        }

        /* ── Features list ── */
        .features-list {
            list-style: none;
            margin-bottom: 1.6rem;
        }

        .features-list li {
            display: flex;
            align-items: flex-start;
            gap: 0.65rem;
            font-size: 0.8rem;
            font-weight: 300;
            color: rgba(26,26,26,0.7);
            padding: 0.32rem 0;
            line-height: 1.5;
        }

        /* Gold checkmark */
        .features-list li::before {
            content: '✦';
            color: var(--gold);
            font-size: 0.55rem;
            margin-top: 0.35rem;
            flex-shrink: 0;
        }

        /* ── Divider ── */
        .card-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(201,162,39,0.2), transparent);
            margin: 1.4rem 0;
        }

        /* ── Status preview section ── */
        .status-preview {
            margin-bottom: 1.6rem;
        }

        .status-label {
            font-size: 0.65rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: rgba(201,162,39,0.5);
            margin-bottom: 0.85rem;
        }

        .status-item {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            padding: 0.45rem 0.7rem;
            border-radius: 8px;
            background: rgba(201,162,39,0.04);
            border: 1px solid rgba(201,162,39,0.08);
            margin-bottom: 0.4rem;
        }

        .status-icon {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: rgba(201,162,39,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            flex-shrink: 0;
        }

        .status-text {
            font-size: 0.73rem;
            color: rgba(26,26,26,0.55);
            font-weight: 300;
        }

        .status-value {
            font-size: 0.72rem;
            color: var(--gold-light);
            margin-left: auto;
            font-weight: 400;
        }

        /* ── Price ── */
        .card-price {
            display: flex;
            align-items: baseline;
            gap: 0.3rem;
            margin-bottom: 1.4rem;
        }

        .price-currency {
            font-size: 0.9rem;
            color: var(--gold);
            font-weight: 400;
        }

        .price-amount {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.4rem;
            font-weight: 400;
            color: var(--white);
            line-height: 1;
        }

        .price-period {
            font-size: 0.75rem;
            color: var(--muted);
            font-weight: 300;
        }

        /* ── Join button ── */
        .btn-join {
            width: 100%;
            background: transparent;
            border: 1px solid rgba(201,162,39,0.35);
            border-radius: 8px;
            padding: 0.85rem 1.5rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--gold-light);
            cursor: pointer;
            transition: background 0.2s, border-color 0.2s, color 0.2s, transform 0.15s;
            text-decoration: none;
            display: block;
            text-align: center;
        }

        .btn-join:hover {
            background: rgba(201,162,39,0.12);
            border-color: var(--gold);
            color: var(--white);
            transform: translateY(-1px);
        }

        /* Core card button — filled gold */
        .plan-card.core .btn-join {
            background: linear-gradient(135deg, var(--gold) 0%, #b08a1e 100%);
            border-color: transparent;
            color: #0d0b08;
            font-weight: 600;
        }

        .plan-card.core .btn-join:hover {
            background: linear-gradient(135deg, var(--gold-light) 0%, var(--gold) 100%);
            transform: translateY(-2px);
        }

        /* ── Best-for tagline ── */
        .best-for {
            font-size: 0.72rem;
            font-weight: 300;
            color: rgba(26,26,26,0.35);
            text-align: center;
            margin-top: 1rem;
            font-style: italic;
        }

        /* ── Footer note ── */
        .page-footer {
            text-align: center;
            margin-top: 2.5rem;
            font-size: 0.72rem;
            color: rgba(26,26,26,0.2);
            font-weight: 300;
        }
    </style>
</head>
<body>

    <!-- Faint watermark for brand presence -->
    <div class="watermark" aria-hidden="true">VIA</div>

    <div class="page">

        <!-- Back link -->
        <a href="/get-started" class="back-nav">
            <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M10 12L6 8l4-4" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Back
        </a>

        <!-- Page header -->
        <header class="page-header">
            <p class="page-eyebrow">Membership</p>
            <h1 class="page-title">Choose Your VIA Membership</h1>
            <p class="page-sub">
                Access the VIA ecosystem and start building wealth
                through disciplined financial habits.
            </p>
        </header>

        <!-- 3 Subscription Cards -->
        <div class="cards-grid">

            <!-- ── BASIC ── -->
            <div class="plan-card basic">
                <div class="card-tier">Basic</div>
                <div class="card-tier-sub">Foundation</div>

                <ul class="features-list">
                    <li>Access to VIA ecosystem</li>
                    <li>Eco Wallet</li>
                    <li>Savings tracking</li>
                    <li>Marketplace access</li>
                </ul>

                <div class="card-divider"></div>

                <!-- Status preview -->
                <div class="status-preview">
                    <div class="status-label">Your future status</div>
                    <div class="status-item">
                        <div class="status-icon">🌱</div>
                        <span class="status-text">VIA Rank</span>
                        <span class="status-value">Starter</span>
                    </div>
                    <div class="status-item">
                        <div class="status-icon">💰</div>
                        <span class="status-text">Eco Wallet</span>
                        <span class="status-value">Active</span>
                    </div>
                </div>

                <div class="card-price">
                    <span class="price-currency">$</span>
                    <span class="price-amount">9</span>
                    <span class="price-period">/ month</span>
                </div>

                <a href="/create-account?plan=basic" class="btn-join" id="join-basic">
                    Join Basic
                </a>

                <p class="best-for">Best for beginners starting their wealth journey</p>
            </div>

            <!-- ── CORE (highlighted) ── -->
            <div class="plan-card core">
                <div class="popular-badge">Most Popular</div>

                <div class="card-tier">Core</div>
                <div class="card-tier-sub">Momentum</div>

                <ul class="features-list">
                    <li>Everything in Basic</li>
                    <li>Leaderboard ranking</li>
                    <li>Public VIA profile</li>
                    <li>Advanced wallet tools</li>
                    <li>Investment features</li>
                </ul>

                <div class="card-divider"></div>

                <!-- Status preview -->
                <div class="status-preview">
                    <div class="status-label">Your future status</div>
                    <div class="status-item">
                        <div class="status-icon">⚡</div>
                        <span class="status-text">VIA Rank</span>
                        <span class="status-value">Core Member</span>
                    </div>
                    <div class="status-item">
                        <div class="status-icon">🏆</div>
                        <span class="status-text">Leaderboard</span>
                        <span class="status-value">Visible</span>
                    </div>
                    <div class="status-item">
                        <div class="status-icon">🌐</div>
                        <span class="status-text">Public Profile</span>
                        <span class="status-value">Active</span>
                    </div>
                </div>

                <div class="card-price">
                    <span class="price-currency">$</span>
                    <span class="price-amount">24</span>
                    <span class="price-period">/ month</span>
                </div>

                <a href="/create-account?plan=core" class="btn-join" id="join-core">
                    Join Core
                </a>

                <p class="best-for">Most popular choice</p>
            </div>

            <!-- ── CIRCLE ── -->
            <div class="plan-card circle">
                <div class="card-tier">Circle</div>
                <div class="card-tier-sub">Elite</div>

                <ul class="features-list">
                    <li>Everything in Core</li>
                    <li>Private community access</li>
                    <li>Exclusive opportunities</li>
                    <li>Higher status in VIA ecosystem</li>
                </ul>

                <div class="card-divider"></div>

                <!-- Status preview -->
                <div class="status-preview">
                    <div class="status-label">Your future status</div>
                    <div class="status-item">
                        <div class="status-icon">👑</div>
                        <span class="status-text">VIA Rank</span>
                        <span class="status-value">Circle Elite</span>
                    </div>
                    <div class="status-item">
                        <div class="status-icon">🔒</div>
                        <span class="status-text">Private Circle</span>
                        <span class="status-value">Unlocked</span>
                    </div>
                    <div class="status-item">
                        <div class="status-icon">💎</div>
                        <span class="status-text">Opportunities</span>
                        <span class="status-value">Exclusive</span>
                    </div>
                </div>

                <div class="card-price">
                    <span class="price-currency">$</span>
                    <span class="price-amount">49</span>
                    <span class="price-period">/ month</span>
                </div>

                <a href="/create-account?plan=circle" class="btn-join" id="join-circle">
                    Join Circle
                </a>

                <p class="best-for">For committed wealth builders</p>
            </div>

        </div><!-- /cards-grid -->

        <p class="page-footer">Cancel anytime. No lock-in contracts.</p>

    </div><!-- /page -->

</body>
</html>
