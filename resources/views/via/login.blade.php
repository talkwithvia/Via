@extends('layouts.via')

@section('content')
<style>
    /* ── Split Layout for Auth Pages ── */
    .auth-layout {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        min-height: calc(100vh - 120px); /* Adjust for header/promo */
    }

    .auth-panel-left {
        position: relative;
        background: var(--slate);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 4rem;
    }

    .auth-panel-bg {
        position: absolute;
        inset: 0;
        background-image: url('https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1200&q=80&auto=format');
        background-size: cover;
        background-position: center;
        filter: brightness(0.6) sepia(0.1);
        transition: transform 10s ease-out;
    }
    .auth-panel-left:hover .auth-panel-bg { transform: scale(1.1); }

    .auth-panel-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(33,36,44,0.9) 0%, rgba(33,36,44,0.2) 60%, transparent 100%);
    }

    .auth-panel-content { position: relative; z-index: 2; }
    .auth-panel-logo { font-family: 'Cormorant Garamond', serif; font-size: 2.5rem; color: var(--white); letter-spacing: 0.3em; margin-bottom: 1.5rem; display: block; }
    .auth-panel-tagline { font-family: 'Cormorant Garamond', serif; font-size: 1.5rem; color: rgba(255,255,255,0.85); line-height: 1.4; font-weight: 300; font-style: italic; max-width: 400px; }

    .auth-panel-right {
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        padding: 4rem; background: var(--cream);
    }

    .auth-form-wrap { width: 100%; max-width: 440px; }

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

    .form-group { margin-bottom: 1.5rem; }
    .form-label { display: block; font-size: 0.85rem; font-weight: 600; color: var(--slate); margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em; }
    .form-input {
        width: 100%; padding: 1rem; border: 1px solid var(--border); border-radius: 12px;
        background: var(--white); font-family: inherit; transition: var(--transition);
    }
    .form-input:focus { outline: none; border-color: var(--terra); box-shadow: 0 0 0 4px rgba(178,115,77,0.1); }

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

    .auth-switch { margin-top: 2rem; text-align: center; color: var(--slate-mid); font-size: 0.95rem; }
    .auth-switch a { color: var(--terra); font-weight: 600; text-decoration: none; }
    .auth-switch a:hover { text-decoration: underline; }

    /* ── Mobile Optimization ── */
    @media (max-width: 900px) {
        .auth-layout { grid-template-columns: 1fr; min-height: auto; }
        .auth-panel-left { display: none; }
        .auth-panel-right { padding: 4rem 1.5rem; }
        .auth-title { font-size: 2.5rem; }
    }
</style>

<div class="auth-layout">
    <div class="auth-panel-left">
        <div class="auth-panel-bg"></div>
        <div class="auth-panel-overlay"></div>
        <div class="auth-panel-content">
            <span class="auth-panel-logo">V I A</span>
            <p class="auth-panel-tagline">"The path forward isn't always clear — and that's okay. VIA exists to help you find it."</p>
        </div>
    </div>

    <div class="auth-panel-right">
        <div class="auth-form-wrap">
            <div class="auth-header">
                <div class="auth-icon-wrap">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" stroke-width="2"/></svg>
                </div>
                <h1 class="auth-title">Welcome back</h1>
                <p class="auth-subtitle">Continue your odyssey with VIA</p>
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

            <div class="auth-divider"><span>or sign in with email</span></div>

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="email">Email Address</label>
                    <input class="form-input" type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
                </div>

                <div class="form-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                        <label class="form-label" for="password" style="margin-bottom: 0;">Password</label>
                        <a href="{{ route('password.request') }}" style="font-size: 0.8rem; color: var(--terra); text-decoration: none;">Forgot password?</a>
                    </div>
                    <input class="form-input" type="password" id="password" name="password" placeholder="••••••••" required>
                </div>

                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 2rem;">
                    <input type="checkbox" name="remember" id="remember" style="accent-color: var(--terra);">
                    <label for="remember" style="font-size: 0.9rem; color: var(--slate-mid); cursor: pointer;">Remember me</label>
                </div>

                <button class="btn-submit" type="submit">Sign In</button>
            </form>

            <div class="auth-switch">
                Don't have an account yet? <a href="{{ route('register') }}">Join VIA</a>
            </div>
        </div>
    </div>
</div>
<!-- @endsection -->
