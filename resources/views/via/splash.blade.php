@extends('layouts.via')

@section('content')
<style>
    /* Hero */
    .hero { display: flex; min-height: 85vh; align-items: center; padding: 4rem 2rem; max-width: 1400px; margin: 0 auto; }
    .hero-content { flex: 1; padding-right: 4rem; }
    .hero-eyebrow {
        display: inline-block; padding: 0.5rem 1rem; background-color: var(--terra-muted);
        color: var(--terra-dark); border-radius: var(--radius-pill); font-size: 0.85rem; font-weight: 600;
        margin-bottom: 1.5rem; text-transform: uppercase; letter-spacing: 0.05em;
    }
    .hero-title {
        font-family: 'Cormorant Garamond', serif; font-size: 4.5rem;
        line-height: 1.1; margin-bottom: 1.5rem; color: var(--slate);
    }
    .hero-title span { color: var(--terra); font-style: italic; }
    .hero-desc { font-size: 1.1rem; color: var(--slate-mid); margin-bottom: 2.5rem; max-width: 500px; }
    .btn-group { display: flex; gap: 1rem; }
    .btn {
        padding: 0.875rem 2rem; border-radius: var(--radius-pill); font-weight: 600;
        text-decoration: none; transition: var(--transition); display: inline-block;
        cursor: pointer; border: none; font-size: 1rem;
    }
    .btn-primary { background-color: var(--terra); color: var(--white); box-shadow: 0 4px 14px rgba(178,115,77,0.3); }
    .btn-primary:hover { background-color: var(--terra-dark); transform: translateY(-2px); }
    .btn-outline { background-color: transparent; border: 2px solid var(--slate); color: var(--slate); }
    .btn-outline:hover { background-color: var(--slate); color: var(--white); }

    /* ── Hero Image Animations ── */
    @keyframes heroFloat {
        0%, 100% { transform: translateY(0px); }
        50%       { transform: translateY(-14px); }
    }
    @keyframes fadeSlideLeft {
        from { opacity: 0; transform: translateX(-40px); }
        to   { opacity: 1; transform: translateX(0); }
    }
    @keyframes fadeSlideRight {
        from { opacity: 0; transform: translateX(40px); }
        to   { opacity: 1; transform: translateX(0); }
    }
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* Entrance animations for hero content */
    .hero-content  { animation: fadeSlideLeft  0.9s ease both; }
    .hero-image-wrap { animation: fadeSlideRight 0.9s ease 0.2s both; }

    .hero-image-wrap { flex: 1; position: relative; }
    .hero-image {
        width: 100%; border-radius: var(--radius-lg); object-fit: cover;
        aspect-ratio: 4/5; box-shadow: var(--shadow-md);
        /* Continuous floating (hardware accelerated) */
        animation: heroFloat 6s ease-in-out infinite;
        transition: transform 0.4s ease;
    }
    .hero-image:hover {
        /* Pause float on hover so user can inspect */
        animation-play-state: paused;
        transform: scale(1.02);
    }
    .hero-badge {
        position: absolute; bottom: 2rem; left: -2rem; background: var(--white);
        padding: 1rem 1.5rem; border-radius: var(--radius-md); box-shadow: var(--shadow-md);
        display: flex; align-items: center; gap: 1rem;
        /* Badge slides up after image appears */
        animation: fadeSlideUp 0.7s ease 0.8s both;
    }
    .badge-icon { background: var(--terra-muted); color: var(--terra); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
    .badge-text strong { display: block; color: var(--slate); font-weight: 600; }
    .badge-text span { color: var(--slate-mid); font-size: 0.85rem; }

    /* Featured Section */
    .section { padding: 5rem 2rem; max-width: 1400px; margin: 0 auto; }
    .section-header { text-align: center; margin-bottom: 4rem; }
    .section-header h2 { font-family: 'Cormorant Garamond', serif; font-size: 2.5rem; color: var(--slate); margin-bottom: 0.5rem; }
    .section-header p { color: var(--slate-mid); }
    
    .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 2rem; }
    
    /* Product Card */
    .product-card {
        background: var(--white); border-radius: var(--radius-lg); padding: 1rem;
        transition: var(--transition); border: 1px solid var(--border);
        position: relative; overflow: hidden;
    }
    .product-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-md); border-color: transparent; }
    
    .product-img-box { position: relative; border-radius: var(--radius-md); overflow: hidden; aspect-ratio: 1; background: var(--cream); margin-bottom: 1rem; }
    .product-img-box img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s; }
    .product-card:hover .product-img-box img { transform: scale(1.05); }
    
    .product-actions {
        position: absolute; top: 0.75rem; right: 0.75rem;
        display: flex; flex-direction: column; gap: 0.4rem;
        transform: translateX(16px); opacity: 0; transition: var(--transition);
    }
    .product-card:hover .product-actions { transform: translateX(0); opacity: 1; }
    .product-actions button {
        background: rgba(255,255,255,0.95);
        border: 1px solid rgba(0,0,0,0.05); width: 30px; height: 30px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: var(--transition); color: var(--slate-mid);
        padding: 0;
    }
    .product-actions button:hover        { background: var(--terra); color: var(--white); transform: scale(1.1); }
    .product-actions button.wishlisted   { background: #fee2e2; color: #ef4444; }
    .product-actions button.wishlisted:hover { background: #ef4444; color: var(--white); }
    .product-actions button svg { width: 14px; height: 14px; }

    .product-cat { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-light); font-weight: 600; margin-bottom: 0.25rem; }
    .product-title { font-size: 1.1rem; font-weight: 600; color: var(--slate); margin-bottom: 0.5rem; text-decoration: none; display: block; transition: var(--transition); }
    .product-title:hover { color: var(--terra); }
    
    .product-btm { display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; }
    .product-price { font-weight: 600; color: var(--terra); font-size: 1.1rem; }
    .add-cart-btn {
        background: var(--slate); color: var(--white); border: none;
        width: 30px; height: 30px; border-radius: var(--radius-md);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: var(--transition); padding: 0;
    }
    .add-cart-btn svg { width: 14px; height: 14px; }
    .add-cart-btn:hover { background: var(--terra); transform: rotate(90deg); }

    /* Toast notification */
    #via-toast {
        position: fixed; bottom: 1.5rem; right: 1.5rem; z-index: 9999;
        background: var(--slate); color: var(--white);
        padding: 0.75rem 1.25rem; border-radius: var(--radius-md);
        font-size: 0.9rem; box-shadow: var(--shadow-md);
        transform: translateY(80px); opacity: 0;
        transition: all 0.35s cubic-bezier(.4,0,.2,1);
        pointer-events: none; max-width: 280px;
    }
    #via-toast.show { transform: translateY(0); opacity: 1; }

    @media (max-width: 900px) {
        .hero { flex-direction: column; text-align: center; padding: 2rem 1rem; }
        .hero-content { padding-right: 0; margin-bottom: 3rem; }
        .hero-title { font-size: 3rem; }
        .hero-desc { margin: 0 auto 2rem; font-size: 1rem; }
        .btn-group { justify-content: center; flex-direction: column; width: 100%; max-width: 300px; margin: 0 auto; gap: 1rem; }
        .btn-group .btn { width: 100%; }
        .hero-badge { display: none; }
        .section { padding: 3rem 1rem; }
        .section-header h2 { font-size: 2rem; }
        .product-grid { grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 1.5rem; }
    }
</style>

<header class="hero">
    <div class="hero-content">
        <span class="hero-eyebrow">✦ New Collection 2026</span>
        <h1 class="hero-title">Navigate Your Odyssey<br><span>With VIA</span></h1>
        <p class="hero-desc">Discover premium goods designed to accompany your professional journey. Exceptional quality paired with seamless experience.</p>
        <div class="btn-group">
            <a href="/store" class="btn btn-primary">Shop Collection</a>
            <a href="#featured" class="btn btn-outline">Explore Products</a>
        </div>
    </div>
    <div class="hero-image-wrap">
        <img src="https://images.unsplash.com/photo-1491553895911-0055eca6402d?auto=format&fit=crop&q=80&w=800" alt="VIA Collection" class="hero-image">
        <div class="hero-badge">
            <div class="badge-icon">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" width="24" height="24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" stroke-width="2"/></svg>
            </div>
            <div class="badge-text">
                <strong>4.9 / 5 Stars</strong>
                <span>From 10,000+ Happy Customers</span>
            </div>
        </div>
    </div>
</header>

<section id="featured" class="section">
    <div class="section-header">
        <h2>Featured Products</h2>
        <p>Our bestsellers loved by thousands of users worldwide.</p>
    </div>
    
    <div class="product-grid">
        @php
            $featuredProducts = \App\Models\Product::where('status', 'Active')->inRandomOrder()->take(4)->get();
        @endphp
        
        @foreach($featuredProducts as $product)
        <article class="product-card">
            <div class="product-img-box">
                <img src="{{ Str::startsWith($product->image_path, 'http') ? $product->image_path : asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" onerror="this.src='https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&auto=format'">
                <div class="product-actions">
                    {{-- Wishlist toggle button --}}
                    <button
                        class="wishlist-btn"
                        data-id="{{ $product->id }}"
                        data-url="{{ route('wishlist.toggle', $product->id) }}"
                        aria-label="Add to Wishlist"
                        title="Add to Wishlist">
                        {{-- Heart icon --}}
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </button>
                    {{-- Quick View — links to the product detail page --}}
                    <a
                        href="{{ route('store.show', $product->id) }}"
                        class="quick-view-btn"
                        aria-label="Quick View"
                        title="Quick View"
                        style="background:rgba(255,255,255,0.92);backdrop-filter:blur(6px);border:none;width:30px;height:30px;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 8px rgba(0,0,0,0.12);color:var(--slate-mid);text-decoration:none;transition:var(--transition);">
                        {{-- Eye icon --}}
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="product-cat">{{ $product->category }}</div>
            <a href="{{ route('store.show', $product->id) }}" class="product-title">{{ $product->name }}</a>
            <div style="font-size: 0.8rem; color: #fbbf24;">★★★★★ <span style="color: var(--slate-mid);">5.0</span></div>
            <div class="product-btm">
                <span class="product-price">${{ number_format($product->price, 2) }}</span>
                {{-- Add to cart button --}}
                <button
                    class="add-cart-btn"
                    data-id="{{ $product->id }}"
                    data-url="{{ route('cart.add', $product->id) }}"
                    aria-label="Add to cart"
                    title="Add to Cart">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                </button>
            </div>
        </article>
        @endforeach
        
        @if($featuredProducts->isEmpty())
            <p style="text-align: center; grid-column: 1/-1;">No products found.</p>
        @endif
    </div>
</section>
@endsection

{{-- Toast notification element --}}
<div id="via-toast"></div>

@push('scripts')
<script>
// CSRF token for POST requests
const csrf = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

/**
 * Show a brief toast notification at the bottom-right of the screen.
 * @param {string} msg - The message to display.
 * @param {boolean} success - Green tint if true, red if false.
 */
function showToast(msg, success = true) {
    const toast = document.getElementById('via-toast');
    toast.textContent = msg;
    toast.style.background = success ? 'var(--slate)' : '#ef4444';
    toast.classList.add('show');
    clearTimeout(toast._timer);
    toast._timer = setTimeout(() => toast.classList.remove('show'), 2800);
}

// ── Add to Cart ─────────────────────────────────────────────────────────
document.querySelectorAll('.add-cart-btn').forEach(btn => {
    btn.addEventListener('click', async () => {
        const { url } = btn.dataset;
        
        // Optimistic UI: Show success immediately so it feels instant
        showToast('Added to cart!', true);
        
        try {
            const res = await fetch(url, {
                method:      'POST',
                credentials: 'same-origin',
                headers:     { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
            });

            if (!res.ok) {
                showToast(`Error: Could not add to cart.`, false);
            }
        } catch (err) {
            console.error('Cart error:', err);
            showToast('Could not add to cart. Please try again.', false);
        }
    });
});

// ── Wishlist Toggle ──────────────────────────────────────────────────────
document.querySelectorAll('.wishlist-btn').forEach(btn => {
    btn.addEventListener('click', async () => {
        const { url } = btn.dataset;
        
        // Optimistic UI: Toggle the heart colour instantly
        const isNowWishlisted = btn.classList.toggle('wishlisted');
        btn.title = isNowWishlisted ? 'Remove from Wishlist' : 'Add to Wishlist';
        showToast(isNowWishlisted ? 'Added to wishlist' : 'Removed from wishlist', true);

        try {
            const res = await fetch(url, {
                method:      'POST',
                credentials: 'same-origin',
                headers:     { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
            });

            if (!res.ok) {
                // Revert on error
                btn.classList.toggle('wishlisted', !isNowWishlisted);
                showToast(`Error updating wishlist.`, false);
            }
        } catch (err) {
            console.error('Wishlist error:', err);
            btn.classList.toggle('wishlisted', !isNowWishlisted);
            showToast('Could not update wishlist. Please try again.', false);
        }
    });
});
</script>
@endpush
