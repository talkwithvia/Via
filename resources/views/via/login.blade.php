<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIA — Get Started</title>
    <meta name="description" content="Enter the VIA ecosystem. Start your wealth journey today.">

    <!-- Google Fonts: Cormorant Garamond for brand wordmarks, Inter for body -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        /* ── Reset & Base ── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --gold:       #c9a227;
            --gold-light: #d4b04a;
            --dark:       #0d0b08;
            --white:      #f5f0e8;
            --muted:      rgba(245,240,232,0.45);
        }

        body {
            background: var(--dark);
            font-family: 'Inter', sans-serif;
            color: var(--white);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            overflow: hidden;
        }

        /* ── Radial gold glow behind card ── */
        body::before {
            content: '';
            position: fixed;
            top: -15%;
            left: 50%;
            transform: translateX(-50%);
            width: 70vw;
            height: 55vh;
            background: radial-gradient(ellipse, rgba(201,162,39,0.07) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        /* ── Huge faint VIA watermark — brand presence behind card ── */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(14rem, 42vw, 30rem);
            font-weight: 300;
            letter-spacing: 0.3em;
            /* Very subtle: opacity 5–8% as specified */
            color: rgba(201,162,39,0.06);
            user-select: none;
            pointer-events: none;
            z-index: 0;
            filter: blur(2px);
        }

        /* ── Page enters from opacity 0 ── */
        .page-wrap {
            position: relative;
            z-index: 1;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2.2rem;
            opacity: 0;
            animation: pageIn 0.8s 0.1s ease-out forwards;
        }

        @keyframes pageIn {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Small VIA wordmark above the card ── */
        .mini-logo {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.4rem;
            font-weight: 400;
            letter-spacing: 0.45em;
            color: rgba(201,162,39,0.7);
            text-transform: uppercase;
            text-decoration: none;
        }

        /* ── Step indicators ── */
        .steps {
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .step-dot {
            width: 28px;
            height: 3px;
            border-radius: 2px;
            background: rgba(201,162,39,0.15);
        }

        /* Active step — filled gold */
        .step-dot.active {
            background: linear-gradient(90deg, var(--gold), rgba(201,162,39,0.5));
        }

        /* ── Login card ── */
        .login-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(201,162,39,0.18);
            border-radius: 20px;
            padding: 3rem 2.8rem 2.6rem;
            width: min(90vw, 420px);
            text-align: center;
            backdrop-filter: blur(14px);
        }

        /* Step label */
        .card-eyebrow {
            font-size: 0.62rem;
            letter-spacing: 0.32em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 0.7rem;
        }

        /* Main heading */
        .card-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.1rem;
            font-weight: 400;
            color: var(--white);
            line-height: 1.15;
            margin-bottom: 0.5rem;
        }

        /* Sub-copy */
        .card-sub {
            font-size: 0.8rem;
            font-weight: 300;
            color: var(--muted);
            margin-bottom: 2.4rem;
            line-height: 1.6;
        }

        /* ── Email field ── */
        .field-wrap {
            text-align: left;
            margin-bottom: 1.8rem;
        }

        .field-label {
            display: block;
            font-size: 0.62rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: rgba(245,240,232,0.35);
            margin-bottom: 0.55rem;
        }

        .field-input {
            width: 100%;
            background: transparent;
            border: none;
            border-bottom: 1px solid rgba(201,162,39,0.28);
            padding: 0.7rem 0.2rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            font-weight: 300;
            color: var(--white);
            outline: none;
            transition: border-color 0.3s;
        }

        .field-input::placeholder { color: rgba(245,240,232,0.25); }
        .field-input:focus         { border-bottom-color: var(--gold); }

        /* ── Get Started button ── */
        .btn-primary {
            width: 100%;
            background: linear-gradient(135deg, var(--gold) 0%, #b08a1e 100%);
            color: #0d0b08;
            border: none;
            border-radius: 10px;
            padding: 1rem 1.5rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            cursor: pointer;
            transition: opacity 0.25s, transform 0.2s;
            position: relative;
            overflow: hidden;
        }

        /* Subtle shimmer sweep on hover */
        .btn-primary::after {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 60%;
            height: 100%;
            background: linear-gradient(105deg, transparent 20%, rgba(255,255,255,0.2) 50%, transparent 80%);
            transition: left 0.4s ease;
        }

        .btn-primary:hover { opacity: 0.92; transform: translateY(-2px); }
        .btn-primary:hover::after { left: 160%; }
        .btn-primary:active { transform: translateY(0); }

        /* Loading state */
        .btn-primary.loading {
            opacity: 0.65;
            pointer-events: none;
        }

        /* ── Divider ── */
        .card-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(201,162,39,0.12), transparent);
            margin: 1.8rem 0 1.4rem;
        }

        /* ── Sign-in link for returning users ── */
        .returning-link {
            font-size: 0.75rem;
            color: var(--muted);
            font-weight: 300;
        }

        .returning-link a {
            color: rgba(201,162,39,0.65);
            text-decoration: none;
            transition: color 0.2s;
        }

        .returning-link a:hover { color: var(--gold); }

        /* ── Validation error display ── */
        .error-msg {
            background: rgba(201,39,39,0.08);
            border: 1px solid rgba(201,39,39,0.2);
            border-radius: 8px;
            padding: 0.6rem 0.9rem;
            font-size: 0.75rem;
            color: #e87a7a;
            text-align: left;
            margin-bottom: 1.2rem;
        }
    </style>
</head>
<body>

    <!-- Huge faint watermark — brand presence, almost invisible -->
    <div class="watermark" aria-hidden="true">VIA</div>

    <div class="page-wrap">

        <!-- Mini logo above card -->
        <a href="/" class="mini-logo" aria-label="VIA — back to opener">VIA</a>

        <!-- Progress: Step 1 of 4 active -->
        <div class="steps" aria-label="Step 1 of 4">
            <div class="step-dot active"></div>
            <div class="step-dot"></div>
            <div class="step-dot"></div>
            <div class="step-dot"></div>
        </div>

        <div class="login-card">
            <p class="card-eyebrow">Step 1 of 4</p>
            <h1 class="card-title">Welcome to VIA</h1>
            <p class="card-sub">Enter your email to begin your journey.</p>

            {{-- Show validation errors from session --}}
            @if ($errors->any())
                <div class="error-msg" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <form id="getStartedForm" action="/get-started" method="POST" novalidate>
                @csrf

                <div class="field-wrap">
                    <label class="field-label" for="email-input">Email Address</label>
                    <input
                        id="email-input"
                        class="field-input"
                        type="email"
                        name="email"
                        placeholder="you@example.com"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        autofocus
                    >
                </div>

                <button class="btn-primary" id="getStartedBtn" type="submit">
                    Get Started
                </button>
            </form>

            <div class="card-divider"></div>

            <!-- Returning users can sign in directly -->
            <p class="returning-link">
                Already a member? <a href="/login">Sign in to VIA</a>
            </p>
        </div>

    </div>

    <script>
        // Brief loading state on submit before redirect
        document.getElementById('getStartedForm').addEventListener('submit', function () {
            const btn = document.getElementById('getStartedBtn');
            btn.textContent = 'Loading…';
            btn.classList.add('loading');
        });

        // Restore button if browser navigates back
        window.addEventListener('pageshow', function (e) {
            if (e.persisted) {
                const btn = document.getElementById('getStartedBtn');
                btn.textContent = 'Get Started';
                btn.classList.remove('loading');
            }
        });
    </script>

</body>
</html>
