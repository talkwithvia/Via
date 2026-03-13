<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIA — Create Your Account</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
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
        }

        /* Subtle radial glow */
        body::before {
            content: '';
            position: fixed;
            top: -10%;
            left: 50%;
            transform: translateX(-50%);
            width: 60vw;
            height: 50vh;
            background: radial-gradient(ellipse, rgba(201,162,39,0.05) 0%, transparent 70%);
            pointer-events: none;
        }

        /* Faint watermark */
        .watermark {
            position: fixed;
            bottom: -5%;
            right: -5%;
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(8rem, 20vw, 18rem);
            font-weight: 300;
            color: rgba(201,162,39,0.03);
            user-select: none;
            pointer-events: none;
            letter-spacing: 0.3em;
        }

        /* ── Card ── */
        .register-card {
            background: rgba(255,255,255,0.025);
            border: 1px solid rgba(201,162,39,0.18);
            border-radius: 20px;
            padding: 3rem 2.8rem;
            width: min(90vw, 460px);
            position: relative;
            z-index: 1;
            /* entrance animation */
            opacity: 0;
            transform: translateY(16px);
            animation: cardIn 0.7s 0.2s ease-out forwards;
        }

        @keyframes cardIn {
            0%   { opacity: 0; transform: translateY(16px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        /* ── Progress steps ── */
        .steps {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            margin-bottom: 2.5rem;
        }

        .step-dot {
            width: 28px;
            height: 3px;
            border-radius: 2px;
            background: rgba(201,162,39,0.2);
        }

        .step-dot.done   { background: var(--gold); }
        .step-dot.active { background: linear-gradient(90deg, var(--gold), rgba(201,162,39,0.5)); }

        /* ── Header ── */
        .card-eyebrow {
            font-size: 0.65rem;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            color: var(--gold);
            text-align: center;
            margin-bottom: 0.6rem;
        }

        .card-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem;
            font-weight: 400;
            text-align: center;
            color: var(--white);
            margin-bottom: 0.4rem;
        }

        .card-sub {
            font-size: 0.78rem;
            font-weight: 300;
            color: var(--muted);
            text-align: center;
            margin-bottom: 2.2rem;
            line-height: 1.6;
        }

        /* ── Selected plan badge ── */
        .plan-badge {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(201,162,39,0.06);
            border: 1px solid rgba(201,162,39,0.18);
            border-radius: 10px;
            padding: 0.7rem 1rem;
            margin-bottom: 2rem;
        }

        .plan-badge-label {
            font-size: 0.7rem;
            color: var(--muted);
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .plan-badge-value {
            font-size: 0.8rem;
            color: var(--gold-light);
            font-weight: 500;
        }

        .plan-badge-change {
            font-size: 0.68rem;
            color: rgba(201,162,39,0.5);
            text-decoration: none;
            transition: color 0.2s;
        }

        .plan-badge-change:hover { color: var(--gold); }

        /* ── Form fields ── */
        .field-group {
            display: flex;
            flex-direction: column;
            gap: 1.4rem;
            margin-bottom: 2rem;
        }

        .field-wrap {
            position: relative;
        }

        .field-label {
            font-size: 0.65rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(245,240,232,0.4);
            display: block;
            margin-bottom: 0.5rem;
        }

        .field-input {
            width: 100%;
            background: transparent;
            border: none;
            border-bottom: 1px solid rgba(201,162,39,0.25);
            padding: 0.65rem 0.2rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.875rem;
            font-weight: 300;
            color: var(--white);
            outline: none;
            transition: border-color 0.3s;
        }

        .field-input::placeholder { color: rgba(245,240,232,0.2); }
        .field-input:focus { border-bottom-color: var(--gold); }

        /* Strength indicator for password */
        .strength-bar {
            height: 2px;
            border-radius: 2px;
            background: rgba(201,162,39,0.1);
            margin-top: 0.5rem;
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            width: 0%;
            border-radius: 2px;
            background: linear-gradient(90deg, var(--gold), var(--gold-light));
            transition: width 0.3s ease;
        }

        /* ── Divider ── */
        .form-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(201,162,39,0.15), transparent);
            margin-bottom: 1.6rem;
        }

        /* ── Profile row ── */
        .profile-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        /* ── Enter VIA button ── */
        .btn-enter {
            width: 100%;
            background: linear-gradient(135deg, var(--gold) 0%, #b08a1e 100%);
            color: #0d0b08;
            border: none;
            border-radius: 10px;
            padding: 1rem 1.5rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.2s;
        }

        .btn-enter:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .btn-enter:active { transform: translateY(0); }

        /* ── Terms note ── */
        .terms-note {
            text-align: center;
            font-size: 0.68rem;
            color: rgba(245,240,232,0.2);
            margin-top: 1.2rem;
            line-height: 1.6;
        }

        .terms-note a {
            color: rgba(201,162,39,0.5);
            text-decoration: none;
        }

        .terms-note a:hover { color: var(--gold); }
    </style>
</head>
<body>

    <div class="watermark" aria-hidden="true">VIA</div>

    <div class="register-card">

        <!-- Progress: Step 3 of 4 -->
        <div class="steps" aria-label="Step 3 of 4">
            <div class="step-dot done"></div>
            <div class="step-dot done"></div>
            <div class="step-dot active"></div>
            <div class="step-dot"></div>
        </div>

        <p class="card-eyebrow">Step 3 of 4</p>
        <h1 class="card-title">Create Your Account</h1>
        <p class="card-sub">Secure your VIA membership and begin.</p>

        <!-- Selected plan display -->
        @php
            $plan = request('plan', 'core');
            $planNames = ['basic' => 'Basic — $9/mo', 'core' => 'Core — $24/mo', 'circle' => 'Circle — $49/mo'];
            $planDisplay = $planNames[$plan] ?? 'Core — $24/mo';
        @endphp

        <div class="plan-badge">
            <div>
                <div class="plan-badge-label">Selected Plan</div>
                <div class="plan-badge-value">{{ ucfirst($plan) }}</div>
            </div>
            <div>{{ $planDisplay }}</div>
            <a href="/subscribe" class="plan-badge-change">Change</a>
        </div>

        <form method="POST" action="/create-account" id="registerForm">
            @csrf

            <div class="field-group">

                <!-- Profile name row -->
                <div class="profile-row">
                    <div class="field-wrap">
                        <label class="field-label" for="first-name">First Name</label>
                        <input
                            id="first-name"
                            class="field-input"
                            type="text"
                            name="first_name"
                            placeholder="Kofi"
                            required
                        >
                    </div>
                    <div class="field-wrap">
                        <label class="field-label" for="last-name">Last Name</label>
                        <input
                            id="last-name"
                            class="field-input"
                            type="text"
                            name="last_name"
                            placeholder="Mensah"
                            required
                        >
                    </div>
                </div>

                <!-- Email -->
                <div class="field-wrap">
                    <label class="field-label" for="reg-email">Email Address</label>
                    <input
                        id="reg-email"
                        class="field-input"
                        type="email"
                        name="email"
                        placeholder="you@example.com"
                        required
                    >
                </div>

                <!-- Password -->
                <div class="field-wrap">
                    <label class="field-label" for="password">Password</label>
                    <input
                        id="password"
                        class="field-input"
                        type="password"
                        name="password"
                        placeholder="Create a strong password"
                        required
                        minlength="8"
                    >
                    <!-- Strength bar -->
                    <div class="strength-bar">
                        <div class="strength-fill" id="strengthFill"></div>
                    </div>
                </div>

                <!-- Confirm password -->
                <div class="field-wrap">
                    <label class="field-label" for="password-confirm">Confirm Password</label>
                    <input
                        id="password-confirm"
                        class="field-input"
                        type="password"
                        name="password_confirmation"
                        placeholder="Repeat your password"
                        required
                    >
                </div>

            </div><!-- /field-group -->

            <div class="form-divider"></div>

            <!-- Hidden plan field -->
            <input type="hidden" name="plan" value="{{ $plan }}">

            <button class="btn-enter" type="submit" id="enterBtn">
                Enter VIA
            </button>

            <p class="terms-note">
                By joining you agree to VIA's
                <a href="#">Terms of Service</a> and
                <a href="#">Privacy Policy</a>.
            </p>
        </form>

    </div><!-- /register-card -->

    <script>
        // Live password strength indicator
        const pwInput = document.getElementById('password');
        const fill    = document.getElementById('strengthFill');

        pwInput.addEventListener('input', function () {
            const len = this.value.length;
            let pct = 0;
            if (len >= 8)  pct = 33;
            if (len >= 12) pct = 66;
            if (len >= 16) pct = 100;
            fill.style.width = pct + '%';
        });

        // Brief loading state on submit
        document.getElementById('registerForm').addEventListener('submit', function () {
            const btn = document.getElementById('enterBtn');
            btn.textContent = 'Setting up your profile…';
            btn.style.opacity = '0.7';
            btn.style.pointerEvents = 'none';
        });
    </script>

</body>
</html>
