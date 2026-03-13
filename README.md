# VIA — The Wealth Ecosystem

> A premium, Afro-Minimalist onboarding flow built with Laravel Blade. VIA guides members through a cinematic brand experience into a structured subscription funnel.

---

## ✦ Project Overview

VIA is a wealth-ecosystem platform. The frontend onboarding flow is designed to communicate power, discipline, and status from the very first frame — dark backgrounds, muted-gold accents, and deliberate animations make the experience feel like a **system**, not a startup.

---

## ✦ Onboarding Funnel

```
1. Opening VIA Animation     →  /
2. Get Started (Email Entry) →  /get-started
3. Subscription Selection    →  /subscribe
4. Account Creation          →  /create-account
5. VIA Dashboard             →  /dashboard
```

### Screen Breakdown

| Step | Route | View File | Purpose |
|------|-------|-----------|---------|
| 1 | `/` | `via/splash.blade.php` | Cinematic brand intro — logo reveals, shimmer, then login card fades in |
| 2 | `/get-started` | `via/login.blade.php` | Standalone email entry with watermark & step indicator |
| 3 | `/subscribe` | `via/subscription.blade.php` | Three-tier card selection (Basic / Core / Circle) |
| 4 | `/create-account` | `via/register.blade.php` | Full profile + password form with plan confirmation |
| 5 | `/dashboard` | _(to be built)_ | Post-registration entry point |

---

## ✦ Design System

### Color Tokens
| Token | Value | Usage |
|-------|-------|-------|
| `--gold` | `#c9a227` | Accent, borders, buttons |
| `--gold-light` | `#d4b04a` | Hover states, status values |
| `--dark` | `#0d0b08` | Page background |
| `--white` | `#f5f0e8` | Body text, headings |
| `--muted` | `rgba(245,240,232,0.45)` | Subtext, labels |

### Typography
| Usage | Font | Weight |
|-------|------|--------|
| Logo / Headings | Cormorant Garamond | 300, 400 |
| Body / UI | Inter | 300, 400, 500, 600 |

### Animation Language
- **Splash**: Logo fades in → zooms → shimmer sweeps letters → slides upward → login card rises
- **Cards (Subscription)**: Staggered fade + rise on page load; lift + shadow increase on hover
- **Buttons**: Shimmer sweep on hover; loading state on submit

---

## ✦ Subscription Tiers

| Tier | Price | Highlight |
|------|-------|-----------|
| **Basic** | $9 / mo | Eco Wallet, Savings tracking, Marketplace access |
| **Core** ⭐ | $24 / mo | Leaderboard, Public profile, Investment features |
| **Circle** | $49 / mo | Private community, Exclusive opportunities |

Each card includes a **"Your future status"** preview panel — a psychological framing that sells identity, not just features.

---

## ✦ Tech Stack

- **Framework**: Laravel 10 / PHP
- **Templates**: Blade (no frontend build step required for views)
- **Fonts**: Google Fonts (Cormorant Garamond + Inter)
- **CSS**: Vanilla CSS with custom properties — no Tailwind, no frameworks
- **JS**: Vanilla JS (form state, password strength indicator)

---

## ✦ Getting Started

### Prerequisites
- PHP ≥ 8.1
- Composer

### Install & Run

```bash
# 1. Install PHP dependencies
composer install

# 2. Copy environment file
cp .env.example .env

# 3. Generate application key
php artisan key:generate

# 4. Start the dev server
php artisan serve
```

App will be available at `http://127.0.0.1:8000`.

---

## ✦ File Structure

```
resources/views/via/
├── splash.blade.php       # Step 1 — Brand opening animation
├── login.blade.php        # Step 2 — Email entry (Get Started)
├── subscription.blade.php # Step 3 — Choose membership tier
└── register.blade.php     # Step 4 — Create account

routes/
└── web.php                # All onboarding routes defined here
```

---

## ✦ Routes Reference

```php
GET  /              → Splash screen
GET  /get-started   → Email entry page
POST /get-started   → Validates email → redirects to /subscribe
GET  /subscribe     → Subscription selection
GET  /create-account → Registration form (accepts ?plan=basic|core|circle)
POST /create-account → Creates account → redirects to /dashboard
GET  /dashboard     → Post-onboarding entry point (placeholder)
```

---

## ✦ Changelog

| Date | Change |
|------|--------|
| 2026-03-13 | Added `login.blade.php` (standalone Get Started page) |
| 2026-03-13 | Added `POST /create-account` route with validation |
| 2026-03-13 | Added `POST /get-started` with email validation + session storage |
| 2026-03-13 | Replaced default Laravel README with VIA project documentation |
| — | `splash.blade.php` — cinematic opener with logo animation |
| — | `subscription.blade.php` — three-tier membership cards |
| — | `register.blade.php` — account creation form with plan badge |

---

*VIA — Enter the ecosystem.*
