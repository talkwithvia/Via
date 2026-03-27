<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIA — Store</title>
    <meta name="description" content="Shop the BFSUMA x VIA collection — notebooks, apparel, digital resources and services.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        /* ── Design Tokens (matching all Via pages) ── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --cream:      #f9f8f6;
            --cream-dark: #f0ede8;
            --slate:      #21242c;
            --slate-mid:  #4a5568;
            --muted:      #6b7280;
            --terra:      #b2734d;
            --terra-dark: #8f5a3a;
            --terra-light:#faf0ea;
            --border:     #dee0e4;
            --white:      #ffffff;
        }

        html { scroll-behavior: smooth; }

        body {
            background: var(--cream);
            font-family: 'Inter', system-ui, sans-serif;
            color: var(--slate);
            min-height: 100vh;
        }

        /* ── Navigation (same as all Via pages) ── */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2.5rem;
            height: 56px;
            background: rgba(249,248,246,0.92);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(222,224,228,0.6);
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

        .nav-center a:hover, .nav-center a.active { color: var(--slate); }
        .nav-center a.active { font-weight: 500; }

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

        /* Cart badge counter */
        .cart-count {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--terra);
            color: var(--white);
            font-size: 0.6rem;
            font-weight: 600;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            margin-left: -4px;
            margin-top: -8px;
            vertical-align: top;
        }

        /* ── Page Hero Strip ── */
        .store-hero {
            background: var(--cream-dark);
            border-bottom: 1px solid var(--border);
            padding: 3rem 2.5rem 2.5rem;
            text-align: center;
        }

        .store-eyebrow {
            font-size: 0.7rem;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            color: var(--terra);
            margin-bottom: 0.7rem;
        }

        .store-title {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 400;
            color: var(--slate);
            margin-bottom: 0.6rem;
        }

        .store-sub {
            font-size: 0.88rem;
            color: var(--muted);
            max-width: 460px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* ── Store Layout ── */
        .store-layout {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2.5rem 2rem 5rem;
            display: grid;
            grid-template-columns: 200px 1fr;
            gap: 2.5rem;
            align-items: start;
        }

        /* ── Category Sidebar ── */
        .category-sidebar {
            position: sticky;
            top: 72px;
        }

        .sidebar-heading {
            font-size: 0.65rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 0.75rem;
        }

        .category-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.15rem;
        }

        .category-list li a {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.5rem 0.85rem;
            border-radius: 8px;
            font-size: 0.85rem;
            color: var(--slate-mid);
            text-decoration: none;
            transition: background 0.2s, color 0.2s;
        }

        .category-list li a:hover {
            background: var(--cream-dark);
            color: var(--slate);
        }

        .category-list li a.active {
            background: var(--terra-light);
            color: var(--terra);
            font-weight: 500;
        }

        .cat-count {
            font-size: 0.72rem;
            color: var(--muted);
            background: var(--cream-dark);
            border-radius: 999px;
            padding: 0.1rem 0.5rem;
        }

        .category-list li a.active .cat-count {
            background: rgba(178,115,77,0.15);
            color: var(--terra);
        }

        /* ── Products Area ── */
        .products-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .products-count {
            font-size: 0.82rem;
            color: var(--muted);
        }

        .products-count strong {
            color: var(--slate);
            font-weight: 500;
        }

        /* ── Product Grid ── */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 1.4rem;
        }

        /* ── Product Card ── */
        .product-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: box-shadow 0.25s, transform 0.25s, border-color 0.25s;
            /* Entrance animation */
            opacity: 0;
            transform: translateY(14px);
            animation: cardIn 0.5s ease-out forwards;
        }

        .product-card:nth-child(1) { animation-delay: 0.05s; }
        .product-card:nth-child(2) { animation-delay: 0.10s; }
        .product-card:nth-child(3) { animation-delay: 0.15s; }
        .product-card:nth-child(4) { animation-delay: 0.20s; }
        .product-card:nth-child(5) { animation-delay: 0.25s; }
        .product-card:nth-child(6) { animation-delay: 0.30s; }
        .product-card:nth-child(7) { animation-delay: 0.35s; }
        .product-card:nth-child(8) { animation-delay: 0.40s; }
        .product-card:nth-child(9) { animation-delay: 0.45s; }

        @keyframes cardIn {
            to { opacity: 1; transform: translateY(0); }
        }

        .product-card:hover {
            box-shadow: 0 8px 32px rgba(0,0,0,0.08);
            transform: translateY(-3px);
            border-color: #cdd0d5;
        }

        /* Product image placeholder — elegant gradient */
        .product-image {
            aspect-ratio: 4/3;
            background: linear-gradient(135deg, var(--cream-dark) 0%, #e8e3db 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .product-image-icon {
            width: 48px;
            height: 48px;
            opacity: 0.25;
            color: var(--slate);
        }

        /* Category pill on image */
        .product-cat-pill {
            position: absolute;
            top: 0.75rem;
            left: 0.75rem;
            font-size: 0.62rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(6px);
            color: var(--slate-mid);
            border-radius: 999px;
            padding: 0.2rem 0.7rem;
            border: 1px solid rgba(222,224,228,0.6);
        }

        /* Low-stock pill */
        .product-stock-pill {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            font-size: 0.6rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            background: rgba(178,115,77,0.15);
            color: var(--terra);
            border-radius: 999px;
            padding: 0.2rem 0.65rem;
            border: 1px solid rgba(178,115,77,0.25);
        }

        /* Card body */
        .product-body {
            padding: 1.2rem 1.3rem 1.4rem;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .product-name {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 1.2rem;
            font-weight: 500;
            color: var(--slate);
            margin-bottom: 0.4rem;
            line-height: 1.25;
        }

        .product-desc {
            font-size: 0.8rem;
            color: var(--muted);
            line-height: 1.55;
            flex: 1;
            margin-bottom: 1rem;
        }

        .product-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
        }

        .product-price {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 1.5rem;
            font-weight: 400;
            color: var(--terra);
            line-height: 1;
        }

        .product-price small {
            font-family: 'Inter', sans-serif;
            font-size: 0.72rem;
            color: var(--muted);
        }

        /* Add to cart button */
        .btn-cart {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            background: var(--slate);
            color: var(--white);
            border: none;
            border-radius: 8px;
            padding: 0.6rem 1rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.78rem;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s;
            white-space: nowrap;
        }

        .btn-cart:hover {
            background: var(--terra);
            transform: translateY(-1px);
        }

        .btn-cart.added {
            background: #2d7a4f;
        }

        .btn-cart svg {
            width: 13px;
            height: 13px;
            flex-shrink: 0;
        }

        /* ── Empty state ── */
        .empty-state {
            text-align: center;
            padding: 5rem 2rem;
            grid-column: 1 / -1;
        }

        .empty-state svg {
            width: 48px;
            height: 48px;
            color: var(--border);
            margin-bottom: 1rem;
        }

        .empty-state p {
            font-size: 0.9rem;
            color: var(--muted);
        }

        /* ── Cart Drawer ── */
        .cart-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(33,36,44,0.4);
            z-index: 200;
            backdrop-filter: blur(3px);
        }

        .cart-backdrop.open { display: block; }

        .cart-drawer {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            width: min(90vw, 400px);
            background: var(--white);
            border-left: 1px solid var(--border);
            z-index: 201;
            display: flex;
            flex-direction: column;
            transform: translateX(100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .cart-drawer.open { transform: translateX(0); }

        .cart-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.4rem 1.6rem;
            border-bottom: 1px solid var(--border);
        }

        .cart-title {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 1.3rem;
            font-weight: 400;
            color: var(--slate);
        }

        .cart-close {
            background: none;
            border: none;
            font-size: 1.1rem;
            color: var(--muted);
            cursor: pointer;
            transition: color 0.2s;
            padding: 0.2rem;
        }

        .cart-close:hover { color: var(--slate); }

        .cart-items {
            flex: 1;
            overflow-y: auto;
            padding: 1rem 1.6rem;
        }

        .cart-item {
            display: flex;
            gap: 0.85rem;
            padding: 0.9rem 0;
            border-bottom: 1px solid rgba(222,224,228,0.5);
            align-items: flex-start;
        }

        .cart-item:last-child { border-bottom: none; }

        .cart-item-icon {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            background: var(--cream-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .cart-item-icon svg {
            width: 18px;
            height: 18px;
            color: var(--muted);
        }

        .cart-item-info { flex: 1; }

        .cart-item-name {
            font-size: 0.87rem;
            font-weight: 500;
            color: var(--slate);
            margin-bottom: 0.2rem;
        }

        .cart-item-price {
            font-size: 0.8rem;
            color: var(--terra);
        }

        .cart-item-qty {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.4rem;
        }

        .qty-btn {
            background: var(--cream-dark);
            border: 1px solid var(--border);
            border-radius: 5px;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            cursor: pointer;
            color: var(--slate);
            transition: background 0.15s;
        }

        .qty-btn:hover { background: var(--border); }

        .qty-number {
            font-size: 0.82rem;
            font-weight: 500;
            color: var(--slate);
            min-width: 18px;
            text-align: center;
        }

        .cart-remove {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--muted);
            font-size: 1rem;
            padding: 0.1rem;
            transition: color 0.2s;
            align-self: center;
        }

        .cart-remove:hover { color: #b91c1c; }

        .cart-empty-msg {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--muted);
            font-size: 0.88rem;
        }

        .cart-empty-msg svg {
            width: 40px;
            height: 40px;
            color: var(--border);
            margin: 0 auto 1rem;
            display: block;
        }

        /* Cart footer */
        .cart-footer {
            padding: 1.4rem 1.6rem;
            border-top: 1px solid var(--border);
            background: var(--cream);
        }

        .cart-total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.1rem;
        }

        .cart-total-label {
            font-size: 0.82rem;
            color: var(--muted);
        }

        .cart-total-value {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 1.5rem;
            color: var(--slate);
        }

        .btn-checkout {
            display: block;
            width: 100%;
            background: var(--terra);
            color: var(--white);
            border: none;
            border-radius: 9px;
            padding: 0.9rem 1.5rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.88rem;
            font-weight: 500;
            cursor: pointer;
            text-align: center;
            transition: background 0.2s, transform 0.15s;
        }

        .btn-checkout:hover {
            background: var(--terra-dark);
            transform: translateY(-1px);
        }

        .btn-checkout:disabled {
            background: var(--border);
            color: var(--muted);
            cursor: default;
            transform: none;
        }

        /* ── Checkout success toast ── */
        .toast {
            position: fixed;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%) translateY(120px);
            background: var(--slate);
            color: var(--white);
            padding: 0.75rem 1.5rem;
            border-radius: 999px;
            font-size: 0.84rem;
            font-weight: 500;
            z-index: 300;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            white-space: nowrap;
        }

        .toast.show { transform: translateX(-50%) translateY(0); }

        /* ── Responsive ── */
        @media (max-width: 860px) {
            .store-layout {
                grid-template-columns: 1fr;
                padding: 1.5rem 1.2rem 4rem;
            }

            .category-sidebar {
                position: static;
                display: flex;
                gap: 0.5rem;
                flex-wrap: wrap;
            }

            .sidebar-heading { display: none; }

            .category-list {
                flex-direction: row;
                flex-wrap: wrap;
                gap: 0.4rem;
            }

            .category-list li a {
                padding: 0.4rem 0.9rem;
                border: 1px solid var(--border);
                background: var(--white);
                gap: 0.4rem;
            }
        }

        @media (max-width: 600px) {
            .nav-center { display: none; }
            .navbar { padding: 0 1.2rem; }
            .product-grid { grid-template-columns: 1fr; }
            .store-hero { padding: 2rem 1.2rem; }
        }
    </style>
</head>
<body>

    <!-- ── Navigation ── -->
    <nav class="navbar">
        <a href="/" class="nav-logo">V I A</a>

        <div class="nav-center">
            <a href="/subscribe">Explore Opportunities</a>
            <a href="/store" class="active">Store</a>
            <a href="#">Community</a>
            <a href="#">Blog</a>
            <span style="display:flex;align-items:center;gap:0.5rem;">
                <a href="#">Events</a>
                <span class="nav-badge-tag">Coming Soon</span>
            </span>
        </div>

        <div class="nav-right">
            <!-- Cart trigger -->
            <a href="#" id="cartToggle" onclick="openCart(event)">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <path d="M16 10a4 4 0 0 1-8 0"/>
                </svg>
                Cart
                <span class="cart-count" id="cartCountBadge" style="display:none;">0</span>
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

    <!-- ── Hero Strip ── -->
    <div class="store-hero">
        <p class="store-eyebrow">BFSUMA × VIA</p>
        <h1 class="store-title">The Store</h1>
        <p class="store-sub">Medicinal products, wellness solutions and natural remedies curated by BFSUMA.</p>
    </div>

    <!-- ── Store Layout ── -->
    <div class="store-layout">

        <!-- Category Sidebar -->
        <aside class="category-sidebar">
            <p class="sidebar-heading">Categories</p>
            <ul class="category-list">
                <li>
                    <a href="{{ route('store.index') }}" class="{{ $category === 'all' ? 'active' : '' }}">
                        All Products
                        <span class="cat-count">{{ $products->count() + ($category !== 'all' ? 0 : 0) }}</span>
                    </a>
                </li>
                @php
                    // Get counts per category for display
                    use App\Models\Product;
                    $catCounts = Product::where('status','Active')->selectRaw('category, count(*) as total')->groupBy('category')->pluck('total','category');
                @endphp
                @foreach($categories as $cat)
                <li>
                    <a href="{{ route('store.index', ['category' => $cat]) }}" class="{{ $category === $cat ? 'active' : '' }}">
                        {{ $cat }}
                        <span class="cat-count">{{ $catCounts[$cat] ?? 0 }}</span>
                    </a>
                </li>
                @endforeach
            </ul>
        </aside>

        <!-- Products Area -->
        <main>
            <div class="products-header">
                <p class="products-count">
                    Showing <strong>{{ $products->count() }}</strong>
                    {{ $category !== 'all' ? $category : '' }}
                    {{ $products->count() === 1 ? 'item' : 'items' }}
                </p>
            </div>

            @if($products->isEmpty())
                <div class="empty-state">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <p>No products in this category yet.<br>Check back soon.</p>
                </div>
            @else
                <div class="product-grid">
                    @foreach($products as $product)
                    <div class="product-card" id="card-{{ $product->id }}">
                        <!-- Product Image Placeholder -->
                        <div class="product-image">
                            @php
                                $icons = [
                                    'Stationery' => '<path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"/>',
                                    'Apparel'    => '<path d="M20.38 3.46L16 2a4 4 0 01-8 0L3.62 3.46a2 2 0 00-1.34 2.23l.58 3.57a1 1 0 00.99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 002-2V10h2.15a1 1 0 00.99-.84l.58-3.57a2 2 0 00-1.34-2.23z"/>',
                                    'Digital'    => '<rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>',
                                    'Service'    => '<circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/>',
                                ];
                                $iconPath = $icons[$product->category] ?? '<circle cx="12" cy="12" r="10"/>';
                            @endphp
                            <svg class="product-image-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round">
                                {!! $iconPath !!}
                            </svg>
                            <span class="product-cat-pill">{{ $product->category }}</span>
                            {{-- Only show 'Sold Out' badge — never reveal stock count to users --}}
                            @if($product->stock === 0)
                                <span class="product-stock-pill" style="background:rgba(185,28,28,0.1);color:#b91c1c;border-color:rgba(185,28,28,0.2);">Sold out</span>
                            @endif
                        </div>

                        <!-- Product Body -->
                        <div class="product-body">
                            <div class="product-name">{{ $product->name }}</div>
                            @if($product->description)
                                <p class="product-desc">{{ $product->description }}</p>
                            @endif
                            <div class="product-footer">
                                <div class="product-price">
                                    {{ $product->price }}/=
                                    <small>KES</small>
                                </div>
                                @if($product->stock > 0)
                                    <button class="btn-cart" id="btn-{{ $product->id }}"
                                        onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', '{{ $product->price }}')">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                                        </svg>
                                        Add to Cart
                                    </button>
                                @else
                                    <button class="btn-cart" disabled style="background:var(--border);color:var(--muted);cursor:not-allowed;">
                                        Sold Out
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </main>
    </div>

    <!-- ── Cart Backdrop ── -->
    <div class="cart-backdrop" id="cartBackdrop" onclick="closeCart()"></div>

    <!-- ── Cart Drawer ── -->
    <div class="cart-drawer" id="cartDrawer">
        <div class="cart-header">
            <span class="cart-title">Your Cart</span>
            <button class="cart-close" onclick="closeCart()">✕</button>
        </div>

        <div class="cart-items" id="cartItems">
            <div class="cart-empty-msg" id="cartEmptyMsg">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Your cart is empty.<br>Start adding products!
            </div>
        </div>

        <div class="cart-footer">
            <div class="cart-total-row">
                <span class="cart-total-label">Total</span>
                <span class="cart-total-value" id="cartTotal">0/=</span>
            </div>
            <button class="btn-checkout" id="checkoutBtn" disabled onclick="checkout()">
                Proceed to Checkout
            </button>
        </div>
    </div>

    <!-- ── Toast ── -->
    <div class="toast" id="toast">Item added to cart</div>

    <script>
        // ── Cart state ─────────────────────────────────────────────────
        let cart = {}; // { id: { name, price(number), qty } }

        function parsePrice(str) {
            // Strip commas to parse "1,200" → 1200
            return parseInt(String(str).replace(/,/g, ''), 10) || 0;
        }

        function formatPrice(n) {
            return n.toLocaleString('en-KE') + '/=';
        }

        // ── Add to cart ────────────────────────────────────────────────
        function addToCart(id, name, priceStr) {
            const price = parsePrice(priceStr);
            if (cart[id]) {
                cart[id].qty += 1;
            } else {
                cart[id] = { name, price, qty: 1 };
            }
            renderCart();
            updateCartBadge();

            // Button feedback
            const btn = document.getElementById('btn-' + id);
            if (btn) {
                btn.classList.add('added');
                btn.innerHTML = `<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:13px;height:13px;"><polyline points="20 6 9 17 4 12"/></svg> Added`;
                setTimeout(() => {
                    btn.classList.remove('added');
                    btn.innerHTML = `<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:13px;height:13px;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg> Add to Cart`;
                }, 1600);
            }

            showToast(name + ' added to cart');
        }

        function changeQty(id, delta) {
            if (!cart[id]) return;
            cart[id].qty += delta;
            if (cart[id].qty <= 0) delete cart[id];
            renderCart();
            updateCartBadge();
        }

        function removeItem(id) {
            delete cart[id];
            renderCart();
            updateCartBadge();
        }

        // ── Render cart drawer contents ────────────────────────────────
        function renderCart() {
            const container = document.getElementById('cartItems');
            const emptyMsg  = document.getElementById('cartEmptyMsg');
            const totalEl   = document.getElementById('cartTotal');
            const checkoutBtn = document.getElementById('checkoutBtn');

            const ids = Object.keys(cart);
            let total = 0;

            if (ids.length === 0) {
                container.innerHTML = '';
                container.appendChild(emptyMsg);
                emptyMsg.style.display = 'block';
                totalEl.textContent = '0/=';
                checkoutBtn.disabled = true;
                return;
            }

            emptyMsg.style.display = 'none';
            let html = '';
            ids.forEach(id => {
                const item = cart[id];
                total += item.price * item.qty;
                html += `
                <div class="cart-item">
                    <div class="cart-item-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/>
                        </svg>
                    </div>
                    <div class="cart-item-info">
                        <div class="cart-item-name">${escHtml(item.name)}</div>
                        <div class="cart-item-price">${formatPrice(item.price)}</div>
                        <div class="cart-item-qty">
                            <button class="qty-btn" onclick="changeQty(${id}, -1)">−</button>
                            <span class="qty-number">${item.qty}</span>
                            <button class="qty-btn" onclick="changeQty(${id}, 1)">+</button>
                        </div>
                    </div>
                    <button class="cart-remove" onclick="removeItem(${id})" title="Remove">✕</button>
                </div>`;
            });

            container.innerHTML = html;
            totalEl.textContent = formatPrice(total);
            checkoutBtn.disabled = false;
        }

        // ── Cart badge ─────────────────────────────────────────────────
        function updateCartBadge() {
            const badge = document.getElementById('cartCountBadge');
            const total = Object.values(cart).reduce((s, i) => s + i.qty, 0);
            if (total > 0) {
                badge.textContent = total;
                badge.style.display = 'inline-flex';
            } else {
                badge.style.display = 'none';
            }
        }

        // ── Open / Close cart ──────────────────────────────────────────
        function openCart(e) {
            e && e.preventDefault();
            document.getElementById('cartBackdrop').classList.add('open');
            document.getElementById('cartDrawer').classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeCart() {
            document.getElementById('cartBackdrop').classList.remove('open');
            document.getElementById('cartDrawer').classList.remove('open');
            document.body.style.overflow = '';
        }

        // ── Checkout ──────────────────────────────────────────────────
        function checkout() {
            // Placeholder — replace with real payment integration
            cart = {};
            renderCart();
            updateCartBadge();
            closeCart();
            showToast('🎉 Order placed! We'll be in touch.', 3500);
        }

        // ── Toast ─────────────────────────────────────────────────────
        function showToast(msg, duration = 2200) {
            const t = document.getElementById('toast');
            t.textContent = msg;
            t.classList.add('show');
            setTimeout(() => t.classList.remove('show'), duration);
        }

        // ── Helpers ───────────────────────────────────────────────────
        function escHtml(str) {
            return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
        }

        // Initialise empty cart render
        renderCart();
    </script>

</body>
</html>
