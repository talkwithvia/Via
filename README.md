# VIA — Navigate Your Odyssey

> A premium, Afro-Minimalist platform built with Laravel Blade. VIA guides members through a refined brand experience into a structured membership funnel — light, intentional, and built around movement.

---

## ✦ Project Overview

VIA is a personal growth and wealth-ecosystem platform. The design language is calm and high-end: cream backgrounds, terracotta (`#B2734D`) accents, serif typography (Cormorant Garamond), and a clean top navigation. The experience communicates clarity and purpose, not urgency.

---

## ✦ Site Structure

```
1. Landing / Splash Page   →  /
2. Login                   →  /login
3. Subscription Selection  →  /subscribe
4. Account Creation        →  /create-account
5. VIA Dashboard           →  /dashboard
```

### Page Breakdown

| Step | Route | View File | Purpose |
|------|-------|-----------|---------|
| 1 | `/` | `via/splash.blade.php` | Full landing page — hero, brand statement, journey steps, pricing preview |
| 2 | `/login` | `via/login.blade.php` | Clean login form with terracotta CTA |
| 3 | `/subscribe` | `via/subscription.blade.php` | Three-tier membership card selection |
| 4 | `/create-account` | `via/register.blade.php` | Full profile + password form with plan confirmation |
| 5 | `/dashboard` | _(to be built)_ | Post-registration entry point |

---

## ✦ Design System

### Color Tokens
| Token | Value | Usage |
|-------|-------|-------|
| `--cream` | `#f9f8f6` | Page background |
| `--cream-dark` | `#f0ede8` | Alternate sections, footer |
| `--slate` | `#21242c` | Headings, dark text |
| `--slate-mid` | `#4a5568` | Body text, nav links |
| `--muted` | `#6b7280` | Subtext, labels |
| `--terra` | `#b2734d` | Primary accent — buttons, highlights, step numbers |
| `--terra-dark` | `#8f5a3a` | Hover states for terracotta elements |
| `--border` | `#dee0e4` | Card borders, dividers |
| `--white` | `#ffffff` | Card backgrounds |

### Typography
| Usage | Font | Weight |
|-------|------|--------|
| Logo / Headings / Prices | Cormorant Garamond | 300, 400, 500 |
| Body / UI / Navigation | Inter | 300, 400, 500, 600 |

### Layout & Navigation
- Fixed frosted-glass navbar (`backdrop-filter: blur(12px)`) with logo left, nav links center, Cart + Login right
- Hero: full-viewport-height image with gradient overlay, centered italic heading + CTA
- Sections alternate between `--cream` and `--cream-dark` backgrounds for visual rhythm

### Animation Language
- **Hero button**: subtle `translateY(-1px)` on hover
- **Price cards**: lift + shadow increase on hover; featured card has terracotta border
- **Buttons (all pages)**: smooth color + background transitions (0.2s ease)

---

## ✦ Splash Page Sections

The splash (`/`) is a full landing page, not just a cinematic intro. It contains:

| Section | Description |
|---------|-------------|
| **Navbar** | Sticky; links to Explore Opportunities, Store, Mentorship, Blog, Events (coming soon), Cart, Login |
| **Hero** | Full-screen photographic hero with italic Cormorant title *"VIVA LA VIA"* and terracotta CTA |
| **VIA Is Not A Product** | Brand statement + three pillars: Learn / Do / Grow |
| **Your Journey** | Four-step progression: Discover → Engage → Build → Grow |
| **Access VIA** | Inline pricing preview — three tiers, matching the `/subscribe` page |
| **Footer** | Logo + footer links + copyright |

---

## ✦ Subscription Tiers

Prices are in Kenyan Shillings (KES).

| Tier | Price | Tagline | Highlights |
|------|-------|---------|------------|
| **Via Basic** | KES 500 / mo | Entry to the ecosystem | Educational content, community forums, weekly insights |
| **Via Core** ⭐ | KES 1,200 / mo | Tools and guidance | Everything in Basic + curated opportunities, group mentorship, product guidance |
| **Via Circle** | KES 15,000 / mo | Personal mentorship | Everything in Core + 1-on-1 mentorship, career guidance, equity participation |

---

## ✦ Tech Stack

- **Framework**: Laravel 10 / PHP
- **Templates**: Blade (no frontend build step required for views)
- **Fonts**: Google Fonts — Cormorant Garamond + Inter
- **CSS**: Vanilla CSS with custom properties — no Tailwind, no frameworks
- **JS**: Vanilla JS (form state, password strength indicator, plan selection)

---

## ✦ Getting Started

### Prerequisites
- PHP ≥ 8.1
- Composer
- PostgreSQL (via Supabase)

### Install & Run

```bash
# 1. Install PHP dependencies
composer install

# 2. Copy environment file
cp .env.example .env

# 3. Generate application key
php artisan key:generate

# 4. Configure your database in .env
#    DB_CONNECTION=pgsql
#    DB_HOST=...  DB_PORT=5432  DB_DATABASE=...  DB_USERNAME=...  DB_PASSWORD=...

# 5. Run migrations
php artisan migrate

# 6. Start the dev server
php artisan serve
```

App will be available at `http://127.0.0.1:8000`.

---

## ✦ File Structure

```
resources/views/via/
├── splash.blade.php       # Full landing page (hero, brand sections, pricing)
├── login.blade.php        # Login form
├── subscription.blade.php # Membership tier selection
└── register.blade.php     # Account creation form

routes/
└── web.php                # All onboarding routes defined here
```

---

## ✦ Routes Reference

```php
GET  /               → Landing / splash page
GET  /login          → Login page
POST /login          → Authenticates user
GET  /subscribe      → Subscription tier selection
GET  /create-account → Registration form (accepts ?plan=basic|core|circle)
POST /create-account → Creates account → redirects to /dashboard
GET  /dashboard      → Post-onboarding entry point (placeholder)
```

---

## ✦ Changelog

| Date | Change |
|------|--------|
| 2026-03-24 | Full design overhaul — switched from dark/gold aesthetic to cream/terracotta Afro-minimalist design |
| 2026-03-24 | `splash.blade.php` rebuilt as a multi-section landing page (hero, brand statement, journey, pricing, footer) |
| 2026-03-24 | Updated all pages (login, subscription, register) to match new light design system |
| 2026-03-24 | Pricing updated to KES (500 / 1,200 / 15,000 per month) |
| 2026-03-24 | Replaced `--gold` design tokens with `--terra` (#B2734D) terracotta accent system |
| 2026-03-15 | Themed subscription, register, and login pages to match splash aesthetic |
| 2026-03-13 | Added `login.blade.php` (standalone Get Started page) |
| 2026-03-13 | Added `POST /create-account` route with validation |
| 2026-03-13 | Added `POST /get-started` with email validation + session storage |
| 2026-03-13 | Replaced default Laravel README with VIA project documentation |

---

*VIA — Navigate Your Odyssey.*
