@extends('layouts.via')

@section('content')
<style>
    /* ── Split Layout for Auth Pages ── */
    .auth-layout {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        min-height: calc(100vh - 120px);
    }

    .auth-panel-left {
        position: relative;
        background: var(--slate);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 4rem;
    }

    .auth-panel-bg {
        position: absolute;
        inset: 0;
        background-image: url('https://images.unsplash.com/photo-1502082553048-f009c37129b9?w=1200&q=80&auto=format');
        background-size: cover;
        background-position: center;
        filter: brightness(0.5) sepia(0.1);
        transition: transform 10s ease-out;
    }
    .auth-panel-left:hover .auth-panel-bg { transform: scale(1.1); }

    .auth-panel-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(160deg, rgba(33,36,44,0.8) 0%, rgba(33,36,44,0.3) 50%, rgba(178,115,77,0.2) 100%);
    }

    .auth-panel-top { position: relative; z-index: 2; }
    .auth-panel-logo { font-family: 'Cormorant Garamond', serif; font-size: 2.5rem; color: var(--white); letter-spacing: 0.3em; margin-bottom: 2rem; display: block; }

    .plan-overview { display: flex; flex-direction: column; gap: 1rem; }
    .plan-chip {
        display: flex; align-items: center; justify-content: space-between;
        background: rgba(255,255,255,0.08); backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.12); border-radius: 12px;
        padding: 1rem; transition: var(--transition);
    }
    .plan-chip.highlight { background: rgba(178,115,77,0.2); border-color: rgba(178,115,77,0.4); }
    .plan-chip-name { font-size: 0.9rem; font-weight: 600; color: var(--white); }
    .plan-chip-price { font-family: 'Cormorant Garamond', serif; font-size: 1.1rem; color: var(--terra-light); }

    .auth-panel-bottom { position: relative; z-index: 2; }
    .auth-panel-tagline { font-family: 'Cormorant Garamond', serif; font-size: 1.5rem; color: rgba(255,255,255,0.8); line-height: 1.4; font-weight: 300; font-style: italic; max-width: 400px; }

    .auth-panel-right {
        display: flex; flex-direction: column; align-items: center; justify-content: flex-start;
        padding: 4rem; background: var(--cream); overflow-y: auto;
    }

    .auth-form-wrap { width: 100%; max-width: 480px; }

    .steps-indicator { display: flex; align-items: center; gap: 0.5rem; margin-bottom: 2.5rem; justify-content: center; }
    .step-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--border); transition: var(--transition); }
    .step-dot.active { background: var(--terra); width: 24px; border-radius: 4px; }

    .auth-header { margin-bottom: 2.5rem; text-align: center; }
    .auth-icon-wrap {
        width: 64px; height: 64px; border-radius: 16px; background: rgba(178,115,77,0.1);
        display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;
        border: 1px solid rgba(178,115,77,0.2);
    }
    .auth-icon-wrap svg { width: 32px; height: 32px; stroke: var(--terra); }

    .auth-title { font-family: 'Cormorant Garamond', serif; font-size: 3rem; color: var(--slate); margin-bottom: 0.5rem; }
    .auth-subtitle { color: var(--slate-mid); font-size: 1.1rem; }

    .alert-error {
        background: #fef2f2; border: 1px solid #fee2e2; color: #b91c1c;
        padding: 1rem; border-radius: 12px; margin-bottom: 2rem; font-size: 0.9rem;
        display: flex; align-items: center; gap: 0.75rem;
    }

    .field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .form-group { margin-bottom: 1.5rem; }
    .form-label { display: block; font-size: 0.85rem; font-weight: 600; color: var(--slate); margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em; }
    .form-input {
        width: 100%; padding: 1rem; border: 1px solid var(--border); border-radius: 12px;
        background: var(--white); font-family: inherit; transition: var(--transition);
    }
    .form-input:focus { outline: none; border-color: var(--terra); box-shadow: 0 0 0 4px rgba(178,115,77,0.1); }

    .plan-badge {
        display: flex; align-items: center; justify-content: space-between;
        padding: 1rem; background: rgba(178,115,77,0.05); border: 1px solid rgba(178,115,77,0.2);
        border-radius: 12px; margin-bottom: 2rem;
    }
    .plan-badge-name { font-weight: 600; color: var(--slate); font-size: 0.9rem; display: block; }
    .plan-badge-price { font-family: 'Cormorant Garamond', serif; color: var(--terra); font-size: 1.1rem; }
    .plan-badge-change { color: var(--slate-mid); text-decoration: none; font-size: 0.8rem; border-bottom: 1px dashed var(--border); transition: var(--transition); }
    .plan-badge-change:hover { color: var(--terra); border-color: var(--terra); }

    .strength-wrap { margin-top: 0.75rem; display: flex; align-items: center; gap: 1rem; }
    .strength-track { flex: 1; height: 4px; background: var(--border); border-radius: 2px; overflow: hidden; }
    .strength-fill { height: 100%; width: 0%; background: var(--terra); transition: width 0.3s ease; }
    .strength-label { font-size: 0.75rem; color: var(--muted); font-weight: 600; text-transform: uppercase; min-width: 60px; text-align: right; }

    .btn-submit {
        width: 100%; padding: 1rem; background: var(--slate); color: var(--white);
        border: none; border-radius: var(--radius-pill); font-weight: 600; font-size: 1rem;
        cursor: pointer; transition: var(--transition); margin-top: 1rem;
    }
    .btn-submit:hover { background: var(--terra); transform: translateY(-2px); box-shadow: var(--shadow-md); }

    /* ── Social Buttons ── */
    .social-btns {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin-bottom: 2rem;
    }

    .btn-social {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        width: 100%;
        padding: 0.875rem 1.5rem;
        border-radius: 12px;
        border: 1.5px solid var(--border);
        background: var(--white);
        font-family: inherit;
        font-size: 0.9rem;
        font-weight: 500;
        color: var(--slate);
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-social:hover {
        border-color: var(--slate-mid);
        background: var(--cream-dark);
        transform: translateY(-1px);
        box-shadow: var(--shadow-sm);
    }

    .btn-social.facebook {
        background: #1877F2;
        border-color: #1877F2;
        color: white;
    }
    .btn-social.facebook:hover {
        background: #166fe5;
        border-color: #166fe5;
        box-shadow: 0 4px 12px rgba(24, 119, 242, 0.3);
    }

    .btn-social svg { width: 20px; height: 20px; flex-shrink: 0; }

    /* ── Divider ── */
    .auth-divider {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin: 0.5rem 0 2rem;
    }

    .auth-divider::before,
    .auth-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--border);
    }

    .auth-divider span {
        font-size: 0.75rem;
        color: var(--muted);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .terms-note { font-size: 0.8rem; color: var(--slate-mid); text-align: center; margin-top: 1.5rem; line-height: 1.6; }
    .terms-note a { color: var(--terra); text-decoration: none; font-weight: 600; }

    .auth-switch { margin-top: 2rem; text-align: center; color: var(--slate-mid); font-size: 0.95rem; }
    .auth-switch a { color: var(--terra); font-weight: 600; text-decoration: none; }
    .auth-switch a:hover { text-decoration: underline; }

    /* ── Mobile Optimization ── */
    @media (max-width: 960px) {
        .auth-layout { grid-template-columns: 1fr; min-height: auto; }
        .auth-panel-left { display: none; }
        .auth-panel-right { padding: 4rem 1.5rem; }
        .auth-title { font-size: 2.5rem; }
        .field-row { grid-template-columns: 1fr; }
    }
</style>

<div class="auth-layout">
    <div class="auth-panel-left">
        <div class="auth-panel-bg"></div>
        <div class="auth-panel-overlay"></div>
        <div class="auth-panel-top">
            <span class="auth-panel-logo">V I A</span>
            <div class="plan-overview">
                <div class="plan-chip">
                    <span class="plan-chip-name">Via Basic</span>
                    <span class="plan-chip-price">500/= /mo</span>
                </div>
                <div class="plan-chip highlight">
                    <span class="plan-chip-name">Via Core — Popular</span>
                    <span class="plan-chip-price">1,200/= /mo</span>
                </div>
                <div class="plan-chip">
                    <span class="plan-chip-name">Via Circle</span>
                    <span class="plan-chip-price">15,000/= /mo</span>
                </div>
            </div>
        </div>
        <div class="auth-panel-bottom">
            <p class="auth-panel-tagline">"A natural progression. No rush. Just forward motion."</p>
        </div>
    </div>

    <div class="auth-panel-right">
        <div class="auth-form-wrap">
            <div class="steps-indicator">
                <div class="step-dot active"></div>
                <div class="step-dot"></div>
                <div class="step-dot"></div>
            </div>

            <div class="auth-header">
                <div class="auth-icon-wrap">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" stroke-width="2"/></svg>
                </div>
                <h1 class="auth-title">Join VIA</h1>
                <p class="auth-subtitle">Start your journey today — choose how you want to begin</p>
            </div>

            @if ($errors->any())
                <div class="alert-error">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" stroke-width="2"/></svg>
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Social Logins -->
            <div class="social-btns">
                <a href="{{ route('socialite.redirect', 'google') }}" class="btn-social">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                    Continue with Google
                </a>
                <a href="{{ route('socialite.redirect', 'facebook') }}" class="btn-social facebook">
                    <svg fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    Continue with Facebook
                </a>
            </div>

            <div class="auth-divider"><span>or register with email</span></div>

            @php
                $plan = request('plan', 'core');
                $planNames  = ['basic' => 'Via Basic',  'core' => 'Via Core',  'circle' => 'Via Circle'];
                $planPrices = ['basic' => '500/= /mo', 'core' => '1,200/= /mo', 'circle' => '15,000/= /mo'];
                $planDisplay = $planNames[$plan]  ?? 'Via Core';
                $planPrice   = $planPrices[$plan] ?? '1,200/= /mo';
            @endphp

            <div class="plan-badge">
                <div>
                    <span class="plan-badge-name">{{ $planDisplay }}</span>
                    <span class="plan-badge-price">{{ $planPrice }}</span>
                </div>
                <a href="{{ route('subscribe') }}" class="plan-badge-change">Change plan</a>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <input type="hidden" name="plan" value="{{ $plan }}">

                <div class="field-row">
                    <div class="form-group">
                        <label class="form-label" for="first_name">First Name</label>
                        <input class="form-input" type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" placeholder="John" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="last_name">Last Name</label>
                        <input class="form-input" type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="Doe" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Email Address</label>
                    <input class="form-input" type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input class="form-input" type="password" id="password" name="password" placeholder="••••••••" required oninput="updateStrength(this.value)">
                    <div class="strength-wrap">
                        <div class="strength-track"><div class="strength-fill" id="strengthFill"></div></div>
                        <span class="strength-label" id="strengthLabel">Strength</span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Confirm Password</label>
                    <input class="form-input" type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••" required>
                </div>

                <button class="btn-submit" type="submit">Create My Account</button>

                <p class="terms-note">
                    By joining you agree to VIA's <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.
                </p>
            </form>

            <div class="auth-switch">
                Already have an account? <a href="{{ route('login') }}">Sign in</a>
            </div>
        </div>
    </div>
</div>

<script>
    function updateStrength(val) {
        const fill = document.getElementById('strengthFill');
        const label = document.getElementById('strengthLabel');
        let score = 0;
        if (val.length >= 8) score++;
        if (val.length >= 12) score++;
        if (/[A-Z]/.test(val) && /[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;
        
        const levels = [
            { w: '0%', c: 'var(--border)', t: 'Weak' },
            { w: '25%', c: '#f87171', t: 'Weak' },
            { w: '50%', c: '#fb923c', t: 'Fair' },
            { w: '75%', c: '#facc15', t: 'Good' },
            { w: '100%', c: 'var(--terra)', t: 'Strong' }
        ];
        
        const level = levels[score];
        fill.style.width = level.w;
        fill.style.background = level.c;
        label.textContent = level.t;
        label.style.color = score > 0 ? level.c : 'var(--muted)';
    }
</script>
@endsection
