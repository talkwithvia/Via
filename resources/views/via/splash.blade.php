<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIA — Enter the Ecosystem</title>

    <!-- Google Fonts: Cormorant Garamond for the VIA wordmark, Inter for body -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        /* ── Reset & Base ── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --gold:      #c9a227;
            --gold-light:#d4b04a;
            --dark:      #0d0b08;
            --dark-mid:  #1a1208;
            --white:     #f5f0e8;
        }

        body {
            background: var(--dark);
            font-family: 'Inter', sans-serif;
            overflow: hidden;
            height: 100vh;
            width: 100vw;
        }

        /* ── Full-screen overlay that fades from black ── */
        .fade-overlay {
            position: fixed;
            inset: 0;
            background: #000;
            animation: overlayFade 1.2s ease-out forwards;
            z-index: 50;
            pointer-events: none;
        }

        @keyframes overlayFade {
            0%   { opacity: 1; }
            100% { opacity: 0; }
        }

        /* ── Background gradient ── */
        .splash-bg {
            position: fixed;
            inset: 0;
            background: radial-gradient(ellipse at 50% 50%, #1a1208 0%, #0d0b08 60%, #000 100%);
        }

        /* ── Ambient gold particles (purely decorative) ── */
        .particle {
            position: absolute;
            border-radius: 50%;
            background: var(--gold);
            opacity: 0;
            animation: particleDrift var(--dur, 6s) var(--delay, 0s) ease-in-out infinite;
        }

        @keyframes particleDrift {
            0%   { opacity: 0; transform: translateY(0) scale(0.5); }
            30%  { opacity: 0.15; }
            70%  { opacity: 0.08; }
            100% { opacity: 0; transform: translateY(-120px) scale(1); }
        }

        /* ── Centre stage ── */
        .splash-center {
            position: fixed;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        /* ── VIA Logo wrapper — clip for shimmer ── */
        .logo-wrapper {
            position: relative;
            opacity: 0;
            /* Step 1: logo fades in */
            animation:
                logoFadeIn   1.4s 0.8s ease-out forwards,
                logoZoom     2.0s 0.8s ease-out forwards,
                logoSlideUp  0.7s 3.4s cubic-bezier(.4,0,.2,1) forwards;
        }

        @keyframes logoFadeIn {
            0%   { opacity: 0; }
            100% { opacity: 1; }
        }

        /* Step 2: Camera zooms into VIA */
        @keyframes logoZoom {
            0%   { transform: scale(0.85); }
            55%  { transform: scale(1.08); }
            100% { transform: scale(1.0); }
        }

        /* Step 3: Logo slides upward to make room for card */
        @keyframes logoSlideUp {
            0%   { transform: translateY(0);   opacity: 1; }
            100% { transform: translateY(-30px); opacity: 1; }
        }

        /* ── VIA wordmark text ── */
        .via-wordmark {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(5rem, 18vw, 10rem);
            font-weight: 300;
            letter-spacing: 0.35em;
            color: var(--white);
            position: relative;
            overflow: hidden;
            /* padding to show shimmer extending past left/right */
            padding: 0 0.2em;
            user-select: none;
        }

        /* Shimmer light that sweeps across the letters */
        .via-wordmark::after {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 60%;
            height: 100%;
            background: linear-gradient(
                105deg,
                transparent 20%,
                rgba(201,162,39,0.35) 50%,
                transparent 80%
            );
            /* shimmer starts when logo is visible and zooming */
            animation: shimmerPass 1.8s 1.6s ease-in-out forwards;
        }

        @keyframes shimmerPass {
            0%   { left: -100%; }
            100% { left: 160%; }
        }

        /* ── Thin gold line under the wordmark ── */
        .via-line {
            width: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            margin: 0.6rem auto 0;
            animation: lineExpand 1.0s 1.8s ease-out forwards;
        }

        @keyframes lineExpand {
            0%   { width: 0;    opacity: 0; }
            100% { width: 160px; opacity: 1; }
        }

        /* ── Tagline beneath the line ── */
        .via-tagline {
            font-family: 'Inter', sans-serif;
            font-size: 0.7rem;
            font-weight: 300;
            letter-spacing: 0.45em;
            text-transform: uppercase;
            color: rgba(201,162,39,0.6);
            margin-top: 1rem;
            opacity: 0;
            animation: taglineFade 1.0s 2.0s ease-out forwards;
        }

        @keyframes taglineFade {
            0%   { opacity: 0; transform: translateY(6px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        /* ── Login card — fades in after logo animates up ── */
        .login-card {
            position: absolute;
            bottom: 0;
            width: 100%;
            display: flex;
            justify-content: center;
            padding-bottom: 12vh;

            opacity: 0;
            transform: translateY(20px);
            /* appears after logo slides up (~3.4s + 0.5s) */
            animation: cardAppear 0.9s 3.9s cubic-bezier(.2,.8,.3,1) forwards;
        }

        @keyframes cardAppear {
            0%   { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .login-card-inner {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(201,162,39,0.18);
            border-radius: 16px;
            padding: 2.4rem 2.8rem 2.2rem;
            width: min(90vw, 400px);
            text-align: center;
            backdrop-filter: blur(12px);
        }

        .card-welcome {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.7rem;
            font-weight: 400;
            color: var(--white);
            margin-bottom: 0.35rem;
        }

        .card-sub {
            font-size: 0.8rem;
            font-weight: 300;
            color: rgba(245,240,232,0.45);
            letter-spacing: 0.02em;
            margin-bottom: 1.8rem;
        }

        .email-field {
            width: 100%;
            background: transparent;
            border: none;
            border-bottom: 1px solid rgba(201,162,39,0.3);
            padding: 0.7rem 0.2rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.875rem;
            color: var(--white);
            outline: none;
            transition: border-color 0.3s;
            margin-bottom: 1.6rem;
        }

        .email-field::placeholder { color: rgba(245,240,232,0.3); }
        .email-field:focus { border-bottom-color: var(--gold); }

        .btn-get-started {
            width: 100%;
            background: linear-gradient(135deg, var(--gold) 0%, #b08a1e 100%);
            color: #0d0b08;
            border: none;
            border-radius: 8px;
            padding: 0.85rem 1.5rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.8rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            cursor: pointer;
            transition: opacity 0.25s, transform 0.2s;
        }

        .btn-get-started:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .btn-get-started:active { transform: translateY(0); }

        /* Loading spinner overlay on button */
        .btn-get-started.loading {
            opacity: 0.7;
            pointer-events: none;
        }
    </style>
</head>
<body>

    <!-- Initial black fade overlay -->
    <div class="fade-overlay"></div>

    <!-- Background -->
    <div class="splash-bg">
        <!-- Ambient floating particles -->
        <div class="particle" style="width:3px;height:3px;left:15%;top:70%;--dur:7s;--delay:2s;"></div>
        <div class="particle" style="width:2px;height:2px;left:30%;top:55%;--dur:9s;--delay:3.5s;"></div>
        <div class="particle" style="width:4px;height:4px;left:65%;top:75%;--dur:8s;--delay:1s;"></div>
        <div class="particle" style="width:2px;height:2px;left:80%;top:60%;--dur:6s;--delay:4s;"></div>
        <div class="particle" style="width:3px;height:3px;left:50%;top:80%;--dur:10s;--delay:0.5s;"></div>
        <div class="particle" style="width:2px;height:2px;left:20%;top:40%;--dur:8s;--delay:2.5s;"></div>
    </div>

    <!-- Centre stage: VIA logo + login card together -->
    <div class="splash-center">

        <!-- VIA Logo -->
        <div class="logo-wrapper" id="logoWrapper">
            <div class="via-wordmark" id="viaWordmark">VIA</div>
            <div class="via-line"></div>
            <p class="via-tagline">The Wealth Ecosystem</p>
        </div>

        <!-- Login card slides in below after logo animates up -->
        <div class="login-card" id="loginCard">
            <div class="login-card-inner">
                <h1 class="card-welcome">Welcome to VIA</h1>
                <p class="card-sub">Enter your email to begin</p>

                <form action="/get-started" method="POST">
                    @csrf
                    <input
                        id="email-input"
                        class="email-field"
                        type="email"
                        name="email"
                        placeholder="Email Address"
                        required
                        autocomplete="email"
                    >
                    <button class="btn-get-started" id="getStartedBtn" type="submit">
                        Get Started
                    </button>
                </form>
            </div>
        </div>

    </div>

    <script>
        // Add a brief loading state on button click before form submit
        document.getElementById('getStartedBtn').addEventListener('click', function(e) {
            this.textContent = 'Loading…';
            this.classList.add('loading');
        });
    </script>

</body>
</html>
