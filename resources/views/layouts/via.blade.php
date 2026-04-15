<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'VIA') }}</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --cream: #f9f8f6; --white: #ffffff;
            --slate: #21242c; --slate-mid: #4a5568; --slate-light: #9ca3af;
            --terra: #b2734d; --terra-dark: #8f5a3a; --terra-muted: #ebd6c9;
            --border: #e5e7eb;
            --shadow-sm: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.08);
            --shadow-hover: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            --radius-md: 12px; --radius-lg: 20px; --radius-pill: 9999px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body { font-family: 'Inter', sans-serif; background-color: var(--cream); color: var(--slate); line-height: 1.6; }
        
        .promo-banner {
            background-color: var(--slate); color: var(--cream);
            text-align: center; padding: 0.6rem; font-size: 0.85rem; letter-spacing: 0.05em;
        }
        .promo-banner a { color: #d49875; text-decoration: none; font-weight: 600; margin-left: 0.5rem; transition: var(--transition); }
        .promo-banner a:hover { color: var(--terra); }

        .navbar {
            background-color: rgba(255, 255, 255, 0.95); backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 50;
            padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center;
        }
        .nav-brand { font-family: 'Cormorant Garamond', serif; font-size: 1.5rem; font-weight: 600; color: var(--slate); text-decoration: none; letter-spacing: 0.1em; }
        .nav-links { display: flex; gap: 2rem; list-style: none; margin: 0; padding: 0; }
        .nav-links li { margin: 0; }
        .nav-links a { text-decoration: none; color: var(--slate-mid); font-weight: 500; font-size: 0.95rem; transition: var(--transition); }
        .nav-links a:hover, .nav-links a.active { color: var(--terra); text-decoration: none; }
        .nav-actions { display: flex; gap: 1rem; align-items: center; }
        .icon-btn {
            background: none; border: none; cursor: pointer; color: var(--slate); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: var(--transition); position: relative;
        }
        .icon-btn:hover { background-color: var(--cream); color: var(--terra); }
        .icon-btn svg { width: 22px; height: 22px; }
        .cart-badge {
            position: absolute; top: 2px; right: 2px; background-color: var(--terra); color: var(--white);
            font-size: 0.65rem; border-radius: 50%; width: 16px; height: 16px;
            display: flex; align-items: center; justify-content: center; font-weight: bold;
        }

        .footer { background: var(--white); padding: 4rem 2rem 2rem; border-top: 1px solid var(--border); margin-top: 4rem; }
        .footer-grid { max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 3rem; margin-bottom: 3rem; }
        .footer-col h4 { font-size: 1rem; font-weight: 600; color: var(--slate); margin-bottom: 1.5rem; }
        .footer-col ul { list-style: none; padding: 0; margin: 0; }
        .footer-col ul li { margin-bottom: 0.75rem; }
        .footer-col ul a { color: var(--slate-mid); text-decoration: none; font-size: 0.9rem; transition: var(--transition); }
        .footer-col ul a:hover { color: var(--terra); }
        .footer-bottom { max-width: 1200px; margin: 0 auto; padding-top: 2rem; border-top: 1px solid var(--border); text-align: center; color: var(--slate-light); font-size: 0.85rem; }

        @media (max-width: 900px) {
            .navbar { padding: 1rem; flex-wrap: wrap; }
            .nav-left { flex: 1; display: flex; align-items: center; }
            .mobile-menu-btn { display: flex; align-items: center; justify-content: center; background: none; border: none; cursor: pointer; color: var(--slate); margin-right: 1rem; }
            .nav-links { 
                position: fixed; top: 0; left: -100%; width: 280px; height: 100vh;
                background: var(--white); flex-direction: column; text-align: left;
                padding: 6rem 2rem; gap: 1.5rem; z-index: 100; transition: var(--transition);
                box-shadow: 20px 0 50px rgba(0,0,0,0.1);
            }
            .nav-links.is-open { left: 0; }
            .nav-actions { order: 2; }
            
            /* Backdrop when menu is open */
            .nav-backdrop {
                position: fixed; inset: 0; background: rgba(0,0,0,0.3); backdrop-filter: blur(4px);
                z-index: 90; opacity: 0; pointer-events: none; transition: var(--transition);
            }
            .nav-backdrop.is-open { opacity: 1; pointer-events: auto; }
            
            .nav-links a { font-size: 1.2rem; display: block; padding: 0.5rem 0; border-bottom: 1px solid var(--border); }
            .nav-links li:last-child a { border-bottom: none; }
            .footer-grid { 
                grid-template-columns: repeat(2, 1fr); 
                gap: 2rem; 
                text-align: left; 
            }
            .footer-col:first-child { grid-column: 1 / -1; text-align: center; margin-bottom: 2rem; }
            .footer-col:first-child p { margin: 0 auto; }
            .footer-col h4 { margin-top: 1rem; }
        }
        @media (min-width: 901px) {
            .mobile-menu-btn { display: none; }
        }
    </style>
</head>
<body>
    
    <div class="promo-banner">
        ✦ New memberships now open — Start your journey today. <a href="{{ route('register') }}">Join Now &rarr;</a>
    </div>

    <div class="nav-backdrop" id="navBackdrop" onclick="toggleMobileNav()"></div>
    <nav class="navbar">
        <div class="nav-left" style="display: flex; align-items: center;">
            <button class="mobile-menu-btn" onclick="toggleMobileNav()" aria-label="Toggle navigation">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" width="24" height="24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-width="2"/></svg>
            </button>
            <a href="/" class="nav-brand">VIA</a>
        </div>
        
        <script>
            function toggleMobileNav() {
                document.getElementById('mobileNavLinks').classList.toggle('is-open');
                document.getElementById('navBackdrop').classList.toggle('is-open');
                document.body.style.overflow = document.body.style.overflow === 'hidden' ? '' : 'hidden'; // Prevent scroll
            }
        </script>
        
        <ul class="nav-links" id="mobileNavLinks">
            <li><a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Home</a></li>
            <li><a href="/store" class="{{ request()->is('store*') ? 'active' : '' }}">Shop</a></li>
            <li><a href="/about" class="{{ request()->is('about') ? 'active' : '' }}">About</a></li>
            <li><a href="/contact" class="{{ request()->is('contact') ? 'active' : '' }}">Contact</a></li>
        </ul>

        <div class="nav-actions">
            <button class="icon-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M16.65 16.65A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" stroke-width="2"/></svg></button>
            <a href="/login" class="icon-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" stroke-width="2"/></svg></a>
            <button class="icon-btn">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" stroke-width="2"/></svg>
                <span class="cart-badge">0</span>
            </button>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="footer-grid">
            <div class="footer-col" style="grid-column: span 2;">
                <a href="/" class="nav-brand" style="margin-bottom: 1rem; display: inline-block;">VIA</a>
                <p style="color: var(--slate-mid); font-size: 0.95rem; max-width: 300px;">A premium platform bringing you the finest goods designed for the modern professional.</p>
            </div>
            <div class="footer-col">
                <h4>Shop</h4>
                <ul>
                    <li><a href="/store">All Products</a></li>
                    <li><a href="/store">New Arrivals</a></li>
                    <li><a href="/store">Sale</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Help</h4>
                <ul>
                    <li><a href="/contact">Contact</a></li>
                    <li><a href="#">FAQs</a></li>
                    <li><a href="#">Returns</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Company</h4>
                <ul>
                    <li><a href="/about">About</a></li>
                    <li><a href="#">Privacy</a></li>
                    <li><a href="#">Terms</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; {{ date('Y') }} VIA. All rights reserved.
        </div>
    </footer>
</body>
</html>
