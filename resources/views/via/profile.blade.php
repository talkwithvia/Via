<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIA — My Profile</title>
    <meta name="description" content="Manage your VIA account.">

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
            --terra-light:  #d4a185;
            --terra-dark: #8f5a3a;
            --border:     #dee0e4;
            --white:      #ffffff;
            --danger:     #dc2626;
            --danger-bg:  #fef2f2;
        }

        body {
            background-color: var(--cream);
            font-family: 'Inter', system-ui, sans-serif;
            color: var(--slate);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

         /* ── Announcement Banner ── */
        .announcement-bar {
            background: var(--slate);
            color: rgba(255,255,255,0.85);
            text-align: center;
            padding: 0.55rem 1rem;
            font-size: 0.78rem;
            letter-spacing: 0.04em;
        }

        .announcement-bar a {
            color: var(--terra-light);
            text-decoration: none;
            font-weight: 500;
            margin-left: 0.5rem;
        }

        /* ── Navigation ── */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 200;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2.5rem;
            height: 64px;
            background: rgba(249, 248, 246, 0.95);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(222, 224, 228, 0.7);
            box-shadow: var(--shadow-sm);
        }

        .nav-logo {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 1.4rem;
            font-weight: 600;
            letter-spacing: 0.3em;
            color: var(--slate);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-logo-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--terra);
        }

        .nav-center {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .nav-center a {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--slate-mid);
            text-decoration: none;
            padding: 0.5rem 0.9rem;
            border-radius: var(--radius-pill);
            transition: color 0.2s, background 0.2s;
        }

        .nav-center a:hover,
        .nav-center a.active {
            color: var(--slate);
            background: var(--cream-dark);
        }

        .nav-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .coming-soon-tag {
            font-size: 0.62rem;
            background: var(--terra);
            color: var(--white);
            border-radius: var(--radius-pill);
            padding: 0.15rem 0.55rem;
            letter-spacing: 0.04em;
            font-weight: 500;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-icon-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: var(--radius-sm);
            color: var(--slate-mid);
            text-decoration: none;
            transition: background 0.2s, color 0.2s;
        }

        .nav-icon-btn:hover {
            background: var(--cream-dark);
            color: var(--slate);
        }

        .nav-icon-btn svg { width: 18px; height: 18px; }

        .btn-nav-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: var(--terra);
            color: var(--white);
            font-size: 0.82rem;
            font-weight: 600;
            letter-spacing: 0.02em;
            text-decoration: none;
            padding: 0.55rem 1.2rem;
            border-radius: var(--radius-pill);
            border: none;
            cursor: pointer;
            transition: background 0.2s, transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 8px rgba(178,115,77,0.3);
        }

        .btn-nav-primary:hover {
            background: var(--terra-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(178,115,77,0.4);
        }

        /* Main content */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 3rem 1.5rem;
        }

        .sections-container {
            width: min(100%, 700px);
            display: flex;
            flex-direction: column;
            gap: 2rem;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Section Card */
        .profile-card {
            background: var(--cream-dark);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 2.5rem;
            display: flex;
            flex-direction: column;
        }

        .profile-card h2 {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 1.7rem;
            font-weight: 400;
            color: var(--slate);
            margin-bottom: 0.3rem;
        }

        .profile-card p.desc {
            font-size: 0.88rem;
            color: var(--muted);
            margin-bottom: 2rem;
        }

        /* Form elements */
        .field-wrap { margin-bottom: 1.25rem; }

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
            font-size: 0.9rem;
            color: var(--slate);
            outline: none;
            transition: border-color 0.2s;
        }

        .field-input:focus { border-color: var(--terra); }

        .btn-submit {
            background: var(--slate);
            color: var(--white);
            border: none;
            border-radius: 8px;
            padding: 0.8rem 1.5rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.88rem;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-submit:hover {
            background: #111;
            transform: translateY(-1px);
        }

        .btn-danger {
            background: var(--danger-bg);
            color: var(--danger);
            border: 1px solid rgba(220, 38, 38, 0.2);
            border-radius: 8px;
            padding: 0.8rem 1.5rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.88rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-danger:hover {
            background: var(--danger);
            color: var(--white);
            border-color: var(--danger);
        }

        .error-msg, .success-msg {
            font-size: 0.8rem;
            margin-top: 0.4rem;
        }
        .error-msg { color: var(--danger); }
        .success-msg { color: #166534; font-weight: 500; }
        
        .form-actions {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-top: 1rem;
        }

        @media (max-width: 600px) {
            .nav-center { display: none; }
            .navbar { padding: 0 1.2rem; }
            .profile-card { padding: 1.5rem; }
        }
    </style>
</head>
<body>

<!-- ── Announcement Banner ── -->
    <div class="announcement-bar">
        ✦ New memberships now open — Start your journey today.
        <a href="/register">Join Now →</a>
    </div>

    <!-- ── Navigation ── -->
    <nav class="navbar">
        <a href="/" class="nav-logo">
            <span class="nav-logo-dot"></span>
            VIA
        </a>

        <div class="nav-center">
            <a href="/">Home</a>
            <a href="/subscribe">Opportunities</a>
            <a href="/store">Store</a>
            <a href="#">Community</a>
            <a href="#">Blog</a>
            <span class="nav-badge">
                <a href="#">Events</a>
                <span class="coming-soon-tag">Soon</span>
            </span>
        </div>

        <div class="nav-right">
            <!-- Cart -->
            <a href="/store" class="nav-icon-btn" aria-label="Cart">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <path d="M16 10a4 4 0 0 1-8 0"/>
                </svg>
            </a>
            <!-- Login -->
            <a href="/login" class="nav-icon-btn" aria-label="Login">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                    <polyline points="10 17 15 12 10 7"/>
                    <line x1="15" y1="12" x2="3" y2="12"/>
                </svg>
            </a>
            <a href="/register" class="btn-nav-primary">Join VIA</a>

            <div class="nav-mobile-toggle" onclick="toggleMobileNav()" aria-label="Menu">
                <span></span><span></span><span></span>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="sections-container">
            
            <!-- Update Profile Info Card -->
            <div class="profile-card">
                <h2>Profile Information</h2>
                <p class="desc">Update your account's profile information and email address.</p>

                <form method="post" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')

                    <div class="field-wrap">
                        <label class="field-label" for="name">Full Name</label>
                        <input class="field-input" type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                        @if($errors->has('name'))
                            <div class="error-msg">{{ $errors->first('name') }}</div>
                        @endif
                    </div>

                    <div class="field-wrap">
                        <label class="field-label" for="email">Email Address</label>
                        <input class="field-input" type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
                        @if($errors->has('email'))
                            <div class="error-msg">{{ $errors->first('email') }}</div>
                        @endif
                    </div>

                    <div class="form-actions">
                        <button class="btn-submit" type="submit">Save Changes</button>
                        @if (session('status') === 'profile-updated')
                            <span class="success-msg">Saved.</span>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Update Password Card -->
            <div class="profile-card">
                <h2>Update Password</h2>
                <p class="desc">Ensure your account is using a long, random password to stay secure.</p>

                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')

                    <div class="field-wrap">
                        <label class="field-label" for="current_password">Current Password</label>
                        <input class="field-input" type="password" id="current_password" name="current_password" autocomplete="current-password">
                        @if($errors->updatePassword->has('current_password'))
                            <div class="error-msg">{{ $errors->updatePassword->first('current_password') }}</div>
                        @endif
                    </div>

                    <div class="field-wrap">
                        <label class="field-label" for="update_password">New Password</label>
                        <input class="field-input" type="password" id="update_password" name="password" autocomplete="new-password">
                        @if($errors->updatePassword->has('password'))
                            <div class="error-msg">{{ $errors->updatePassword->first('password') }}</div>
                        @endif
                    </div>

                    <div class="field-wrap">
                        <label class="field-label" for="password_confirmation">Confirm Password</label>
                        <input class="field-input" type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
                        @if($errors->updatePassword->has('password_confirmation'))
                            <div class="error-msg">{{ $errors->updatePassword->first('password_confirmation') }}</div>
                        @endif
                    </div>

                    <div class="form-actions">
                        <button class="btn-submit" type="submit">Update Password</button>
                        @if (session('status') === 'password-updated')
                            <span class="success-msg">Saved.</span>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Delete Account Card -->
            <div class="profile-card">
                <h2>Delete Account</h2>
                <p class="desc">Once your account is deleted, all of its resources and data will be permanently deleted.</p>

                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="field-wrap">
                        <label class="field-label" for="delete_password">Password</label>
                        <input class="field-input" type="password" id="delete_password" name="password" placeholder="Verify password to delete">
                        @if($errors->userDeletion->has('password'))
                            <div class="error-msg">{{ $errors->userDeletion->first('password') }}</div>
                        @endif
                    </div>

                    <div class="form-actions">
                        <button class="btn-danger" type="submit">Delete Account</button>
                    </div>
                </form>
            </div>

        </div>
    </main>
</body>
</html>
