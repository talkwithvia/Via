<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIA — Build Wealth Through Disciplined Habits</title>

    <!-- Google Fonts: Inter for general typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ── Reset & Base ── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --brand-gold: #D2A850;
            --text-dark: #1A1A1A;
            --text-light: #666666;
            --bg-light: #FDFDFD;
            --font-main: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-light);
            font-family: var(--font-main);
            color: var(--text-dark);
            line-height: 1.5;
            overflow-x: hidden;
        }

        /* ── Navigation ── */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 5%;
            max-width: 1400px;
            margin: 0 auto;
        }

        .nav-logo {
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: -0.05em;
            color: var(--text-dark);
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-dark);
            font-size: 0.95rem;
            font-weight: 500;
        }

        .nav-links a:hover {
            color: var(--brand-gold);
        }

        .btn-signin {
            color: var(--text-dark);
        }

        .btn-primary {
            background-color: var(--text-dark);
            color: white !important;
            padding: 0.6rem 1.2rem;
            border-radius: 999px;
            transition: opacity 0.2s;
        }

        .btn-primary:hover {
            opacity: 0.85;
            color: white !important;
        }

        /* ── Hero Section ── */
        .hero {
            display: flex;
            max-width: 1400px;
            margin: 2rem auto 0;
            padding: 0 5%;
            min-height: calc(100vh - 100px);
            align-items: center;
            position: relative;
        }

        .hero-content {
            flex: 1;
            padding-right: 2rem;
            z-index: 2;
        }

        /* The faint big VIA in the background */
        .hero-bg-text {
            position: absolute;
            left: 30%;
            top: 50%;
            transform: translateY(-50%);
            font-size: 35vw;
            font-weight: 800;
            color: #F0F0F0;
            z-index: 0;
            line-height: 0.8;
            letter-spacing: -0.05em;
            user-select: none;
            pointer-events: none;
        }

        .badge {
            display: inline-block;
            background-color: #F2F2F2;
            color: #555;
            padding: 0.4rem 1rem;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 2rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .hero h1 {
            font-size: clamp(3rem, 5vw, 5rem);
            line-height: 1.1;
            font-weight: 700;
            letter-spacing: -0.03em;
            margin-bottom: 1.5rem;
            max-width: 600px;
        }

        .hero h1 .highlight {
            color: var(--brand-gold);
            display: block;
        }

        .hero p {
            color: var(--text-light);
            font-size: 1.1rem;
            max-width: 500px;
            margin-bottom: 2.5rem;
            line-height: 1.6;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            align-items: center;
            margin-bottom: 3rem;
        }

        .btn-hero {
            background-color: var(--text-dark);
            color: white;
            text-decoration: none;
            padding: 1.2rem 2.5rem;
            border-radius: 8px;
            font-weight: 500;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-hero:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .btn-secondary {
            background-color: transparent;
            color: var(--text-dark);
            border: 1px solid #E0E0E0;
        }

        .btn-secondary:hover {
            border-color: var(--text-dark);
            transform: translateY(-2px);
        }

        /* ── Simple Stats Section ── */
        .stats {
            display: flex;
            gap: 4rem;
            margin-top: 1rem;
        }

        .stat {
            display: flex;
            flex-direction: column;
        }

        .stat-val {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .stat-lbl {
            font-size: 0.85rem;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 500;
            margin-top: 0.5rem;
        }

        /* ── Placeholder for Right Side Image ── */
        .hero-image {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 2;
        }
        
        .hero-image-placeholder {
            width: 100%;
            max-width: 500px;
            aspect-ratio: 4/5;
            background-color: #F5EFEB; /* Matching the warm tone in the PDF image */
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Faux image styling representing the person in the PDF */
        .hero-image-placeholder::after {
            content: '';
            position: absolute;
            bottom: 0;
            width: 80%;
            height: 90%;
            background-color: #D2A850;
            opacity: 0.1;
            border-radius: 50% 50% 0 0;
        }

        /* ── Responsive ── */
        @media (max-width: 900px) {
            .hero {
                flex-direction: column;
                text-align: center;
                padding-top: 2rem;
            }
            .hero-content {
                padding-right: 0;
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            .hero-bg-text {
                top: 20%;
                left: 50%;
                transform: translateX(-50%);
            }
            .stats {
                justify-content: center;
                flex-wrap: wrap;
                gap: 2rem;
            }
            .hero-image {
                margin-top: 3rem;
                width: 100%;
            }
            .nav-links {
                display: none; /* simple mobile nav hide for now */
            }
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <a href="/" class="nav-logo">VIA</a>
        <div class="nav-links">
            <a href="#">Features</a>
            <a href="#">Pricing</a>
            <a href="#">About</a>
            <a href="#">Contact</a>
            <a href="/login" class="btn-signin">Sign In</a>
            <a href="/create-account" class="btn-primary">Get Started</a>
        </div>
    </nav>

    <main class="hero">
        <div class="hero-bg-text">VIA</div>
        
        <div class="hero-content">
            <div class="badge">Launching March 2026</div>
            <h1>
                Build Wealth Through
                <span class="highlight">Disciplined Habits</span>
            </h1>
            <p>Join the VIA ecosystem and transform your financial future. Access powerful tools, exclusive communities, and opportunities designed for serious wealth builders.</p>
            
            <div class="hero-buttons">
                <a href="/create-account" class="btn-hero">Start Your Journey</a>
                <a href="#" class="btn-hero btn-secondary">Learn More</a>
            </div>

            <div class="stats">
                <div class="stat">
                    <span class="stat-val">10K+</span>
                    <span class="stat-lbl">Active Members</span>
                </div>
                <div class="stat">
                    <span class="stat-val">$50M+</span>
                    <span class="stat-lbl">Wealth Created</span>
                </div>
                <div class="stat">
                    <span class="stat-val">98%</span>
                    <span class="stat-lbl">Satisfaction Rate</span>
                </div>
            </div>
        </div>

        <div class="hero-image">
            <div class="hero-image-placeholder">
                <!-- This serves as a placeholder for the actual image from the PDF -->
                <span style="color: rgba(0,0,0,0.3); font-size: 0.9rem; z-index: 1;">[ Hero Image Placeholder ]</span>
            </div>
        </div>
    </main>

</body>
</html>
