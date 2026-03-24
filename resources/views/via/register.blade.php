<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIA — Join VIA</title>
    <meta name="description" content="Start your journey with VIA today.">

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
            display: flex;
            flex-direction: column;
        }

        /* ── Navigation ── */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2.5rem;
            height: 56px;
            background: rgba(249, 248, 246, 0.9);
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

        /* ── Main content ── */
        .main-content {
            flex: 1;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 2.5rem 1.5rem;
        }

        /* ── Auth Card ── */
        .auth-card {
            background: var(--cream-dark);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 2.5rem 2.8rem 2.8rem;
            width: min(90vw, 480px);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            animation: cardIn 0.5s ease-out;
        }

        @keyframes cardIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Person+ icon circle */
        .auth-icon {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: var(--cream);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.4rem;
        }

        .auth-icon svg {
            width: 24px;
            height: 24px;
            stroke: var(--terra);
        }

        .auth-title {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 1.9rem;
            font-weight: 400;
            color: var(--slate);
            margin-bottom: 0.4rem;
        }

        .auth-subtitle {
            font-size: 0.88rem;
            color: var(--muted);
            margin-bottom: 2rem;
        }

        /* Social buttons */
        .btn-auth {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            width: 100%;
            padding: 0.9rem 1.5rem;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: var(--white);
            font-family: 'Inter', sans-serif;
            font-size: 0.88rem;
            font-weight: 500;
            color: var(--slate);
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s, border-color 0.2s, box-shadow 0.2s;
            margin-bottom: 0.75rem;
        }

        .btn-auth:hover {
            background: var(--cream);
            border-color: #c5c8ce;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .btn-auth svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        /* Divider */
        .auth-divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            width: 100%;
            margin: 0.5rem 0 1.25rem;
        }

        .auth-divider::before,
        .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .auth-divider span {
            font-size: 0.78rem;
            color: var(--muted);
        }

        /* Email registration form */
        .email-form { width: 100%; display: none; text-align: left; }
        .email-form.active { display: block; }

        .field-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }

        .field-wrap { margin-bottom: 1rem; }

        .field-label {
            display: block;
            font-size: 0.72rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 0.5rem;
        }

        .field-input {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--white);
            font-family: 'Inter', sans-serif;
            font-size: 0.88rem;
            color: var(--slate);
            outline: none;
            transition: border-color 0.2s;
        }

        .field-input:focus { border-color: var(--terra); }
        .field-input::placeholder { color: var(--muted); opacity: 0.6; }

        /* Selected plan badge */
        .plan-badge {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 0.75rem 1rem;
            background: var(--cream);
            border: 1px solid var(--border);
            border-radius: 8px;
            margin-bottom: 1.25rem;
        }

        .plan-badge-name {
            font-size: 0.78rem;
            font-weight: 500;
            color: var(--slate);
        }

        .plan-badge-price {
            font-size: 0.78rem;
            color: var(--terra);
            font-weight: 500;
        }

        .plan-badge-change {
            font-size: 0.72rem;
            color: var(--muted);
            text-decoration: none;
            transition: color 0.2s;
        }

        .plan-badge-change:hover { color: var(--terra); }

        /* Password strength */
        .strength-bar {
            height: 2px;
            background: var(--border);
            border-radius: 2px;
            margin-top: 0.4rem;
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            width: 0%;
            background: var(--terra);
            border-radius: 2px;
            transition: width 0.3s;
        }

        .btn-submit {
            width: 100%;
            background: var(--terra);
            color: var(--white);
            border: none;
            border-radius: 8px;
            padding: 0.9rem 1.5rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.88rem;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s;
            margin-top: 0.5rem;
        }

        .btn-submit:hover {
            background: var(--terra-dark);
            transform: translateY(-1px);
        }

        /* Terms */
        .terms-note {
            font-size: 0.72rem;
            color: var(--muted);
            text-align: center;
            margin-top: 0.9rem;
            line-height: 1.6;
        }

        .terms-note a {
            color: var(--terra);
            text-decoration: none;
        }

        .terms-note a:hover { text-decoration: underline; }

        /* Switch link */
        .auth-switch {
            font-size: 0.82rem;
            color: var(--muted);
            margin-top: 1.5rem;
        }

        .auth-switch a {
            color: var(--terra);
            text-decoration: none;
            font-weight: 500;
        }

        .auth-switch a:hover { color: var(--terra-dark); }

        /* Security note */
        .auth-note {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.75rem;
            color: var(--muted);
            margin-top: 1.2rem;
            opacity: 0.75;
        }

        .auth-note svg { width: 13px; height: 13px; }

        /* Error messages */
        .error-msg {
            width: 100%;
            background: rgba(185, 28, 28, 0.07);
            border: 1px solid rgba(185, 28, 28, 0.2);
            border-radius: 8px;
            padding: 0.7rem 1rem;
            font-size: 0.8rem;
            color: #b91c1c;
            text-align: left;
            margin-bottom: 1rem;
        }

        @media (max-width: 600px) {
            .nav-center { display: none; }
            .navbar { padding: 0 1.2rem; }
            .field-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar">
        <a href="/" class="nav-logo">V I A</a>
        <div class="nav-center">
            <a href="/subscribe">Explore Opportunities</a>
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

    <!-- Main Content -->
    <main class="main-content">
        <div class="auth-card">

            <!-- Person+ icon -->
            <div class="auth-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <line x1="19" y1="8" x2="19" y2="14"/>
                    <line x1="22" y1="11" x2="16" y2="11"/>
                </svg>
            </div>

            <h1 class="auth-title">Join VIA</h1>
            <p class="auth-subtitle">Start your journey with VIA today</p>

            {{-- Validation errors --}}
            @if ($errors->any())
                <div class="error-msg" role="alert">{{ $errors->first() }}</div>
            @endif

            <!-- Google -->
            <a href="#" class="btn-auth">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                Continue with Google
            </a>

            <!-- Apple -->
            <a href="#" class="btn-auth">
                <svg viewBox="0 0 24 24" fill="currentColor" style="color:#000">
                    <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98l-.09.06c-.22.14-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.77M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
                </svg>
                Continue with Apple
            </a>

            <!-- Divider -->
            <div class="auth-divider"><span>or</span></div>

            <!-- Email toggle -->
            <a href="#" class="btn-auth" onclick="toggleEmailForm(event)">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color:var(--muted)">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                    <polyline points="22,6 12,13 2,6"/>
                </svg>
                Continue with Email
            </a>

            <!-- Email registration form -->
            <div class="email-form" id="emailForm">
                @php
                    $plan = request('plan', 'core');
                    $planNames = ['basic' => 'Via Basic', 'core' => 'Via Core', 'circle' => 'Via Circle'];
                    $planPrices = ['basic' => '500/= /mo', 'core' => '1,200/= /mo', 'circle' => '15,000/= /mo'];
                    $planDisplay = $planNames[$plan] ?? 'Via Core';
                    $planPrice = $planPrices[$plan] ?? '1,200/= /mo';
                @endphp

                <!-- Selected plan -->
                <div class="plan-badge">
                    <span class="plan-badge-name">{{ $planDisplay }}</span>
                    <span class="plan-badge-price">{{ $planPrice }}</span>
                    <a href="/subscribe" class="plan-badge-change">Change</a>
                </div>

                <form method="POST" action="/create-account" id="registerForm">
                    @csrf
                    <input type="hidden" name="plan" value="{{ $plan }}">

                    <div class="field-row">
                        <div class="field-wrap">
                            <label class="field-label" for="first-name">First Name</label>
                            <input class="field-input" type="text" id="first-name" name="first_name"
                                   placeholder="First name" required>
                        </div>
                        <div class="field-wrap">
                            <label class="field-label" for="last-name">Last Name</label>
                            <input class="field-input" type="text" id="last-name" name="last_name"
                                   placeholder="Last name" required>
                        </div>
                    </div>

                    <div class="field-wrap">
                        <label class="field-label" for="reg-email">Email Address</label>
                        <input class="field-input" type="email" id="reg-email" name="email"
                               placeholder="you@example.com" required>
                    </div>

                    <div class="field-wrap">
                        <label class="field-label" for="password">Password</label>
                        <input class="field-input" type="password" id="password" name="password"
                               placeholder="Create a strong password" required minlength="8">
                        <div class="strength-bar">
                            <div class="strength-fill" id="strengthFill"></div>
                        </div>
                    </div>

                    <div class="field-wrap">
                        <label class="field-label" for="password-confirm">Confirm Password</label>
                        <input class="field-input" type="password" id="password-confirm" name="password_confirmation"
                               placeholder="Repeat password" required>
                    </div>

                    <button class="btn-submit" type="submit" id="enterBtn">Create Account</button>

                    <p class="terms-note">
                        By joining you agree to VIA's
                        <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.
                    </p>
                </form>
            </div>

            <!-- Switch to login -->
            <p class="auth-switch">
                Already have an account? <a href="/login">Sign in</a>
            </p>

            <!-- Security note -->
            <p class="auth-note">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                Your data is secure and encrypted
            </p>
        </div>
    </main>

    <script>
        function toggleEmailForm(e) {
            e.preventDefault();
            document.getElementById('emailForm').classList.toggle('active');
        }

        // Password strength indicator
        document.getElementById('password').addEventListener('input', function () {
            const len = this.value.length;
            const fill = document.getElementById('strengthFill');
            fill.style.width = len >= 16 ? '100%' : len >= 12 ? '66%' : len >= 8 ? '33%' : '0%';
        });
    </script>

</body>
</html>
