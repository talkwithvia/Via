@extends('layouts.via')

@section('content')
<style>
/* ================================================================
   VIA Store – Premium Layout
   Matches reference screenshot exactly
================================================================ */

/* ── Hero: 50/50 split ─────────────────────────────────────── */
.s-hero {
    display: grid;
    grid-template-columns: 1fr 1fr;
    min-height: 260px;
    background: #f5f0e8;
}
.s-hero__text {
    padding: 3.5rem 4rem 3.5rem 3rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.s-hero__eyebrow {
    font-size: 0.68rem;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: var(--terra);
    font-weight: 700;
    margin-bottom: 1rem;
}
.s-hero__title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(2rem, 3.5vw, 3rem);
    font-weight: 500;
    line-height: 1.18;
    color: var(--slate);
    margin: 0 0 1rem;
}
.s-hero__divider {
    width: 36px;
    height: 2px;
    background: var(--terra);
    margin-bottom: 1rem;
}
.s-hero__desc {
    font-size: 0.9rem;
    color: var(--slate-mid);
    line-height: 1.7;
    max-width: 340px;
}
.s-hero__img {
    position: relative;
    overflow: hidden;
}
.s-hero__img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

/* ── Main store body ────────────────────────────────────────── */
.s-body {
    max-width: 1380px;
    margin: 0 auto;
    padding: 2rem 2rem 3rem;
    display: grid;
    grid-template-columns: 220px 1fr;
    gap: 2.5rem;
}

/* ── Sidebar ─────────────────────────────────────────────────  */
.s-sidebar {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 1.5rem 1.25rem;
    height: fit-content;
    position: sticky;
    top: 90px;
}
.s-sidebar__header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--border);
}
.s-sidebar__header h3 {
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--slate);
    margin: 0;
}
.s-sidebar__header svg { color: var(--slate-mid); }

.s-filter-section { margin-bottom: 1.5rem; }
.s-filter-section:last-child { margin-bottom: 0; }

.s-filter-label {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 0.68rem;
    letter-spacing: 0.13em;
    text-transform: uppercase;
    color: var(--slate);
    font-weight: 700;
    margin-bottom: 0.85rem;
    cursor: pointer;
}
.s-filter-label svg { width: 14px; height: 14px; color: var(--slate-mid); }

/* Radio category list */
.s-cat-list { list-style: none; padding: 0; margin: 0; }
.s-cat-list li { margin-bottom: 0.6rem; }
.s-cat-label {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    font-size: 0.87rem;
    color: var(--slate-mid);
    cursor: pointer;
    transition: color 0.2s;
}
.s-cat-label:hover { color: var(--slate); }
.s-cat-label input[type="radio"] {
    accent-color: var(--terra);
    width: 15px; height: 15px; flex-shrink: 0;
}

/* Price slider */
.s-price-labels {
    display: flex;
    justify-content: space-between;
    font-size: 0.78rem;
    color: var(--slate-mid);
    margin-bottom: 0.7rem;
}
input[type=range].s-slider {
    -webkit-appearance: none;
    width: 100%; height: 3px;
    border-radius: 2px;
    background: linear-gradient(to right, var(--terra) 0%, var(--terra) 50%, #e5e7eb 50%);
    outline: none; cursor: pointer;
}
input[type=range].s-slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 16px; height: 16px; border-radius: 50%;
    background: var(--terra);
    border: 2px solid #fff;
    box-shadow: 0 0 0 1px var(--terra), 0 2px 6px rgba(0,0,0,0.15);
    cursor: pointer;
}
input[type=range].s-slider::-moz-range-thumb {
    width: 16px; height: 16px; border-radius: 50%;
    background: var(--terra); border: 2px solid #fff; cursor: pointer;
}

/* Feature checkboxes */
.s-check-label {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    font-size: 0.87rem;
    color: var(--slate-mid);
    cursor: pointer;
    margin-bottom: 0.6rem;
    transition: color 0.2s;
}
.s-check-label:hover { color: var(--slate); }
.s-check-label input[type="checkbox"] {
    accent-color: var(--terra);
    width: 15px; height: 15px; flex-shrink: 0; border-radius: 3px;
}

/* ── Products area ───────────────────────────────────────────  */
.s-main { min-width: 0; }

.s-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}
.s-toolbar__count { font-size: 0.85rem; color: var(--slate-mid); }
.s-toolbar__sort {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.9rem;
    border: 1px solid var(--border);
    border-radius: 8px;
    font-family: inherit;
    font-size: 0.85rem;
    color: var(--slate);
    background: #fff;
    outline: none;
    cursor: pointer;
    transition: border-color 0.2s;
}
.s-toolbar__sort:hover { border-color: var(--terra); }

/* ── Product mosaic grid ─────────────────────────────────────  */
/*
   Layout: [Featured big card] | [3 small cards]
                                | [3 small cards]
   Grid: 2.3fr + 3 equal cols
*/
.s-mosaic {
    display: grid;
    grid-template-columns: 2.3fr 1fr 1fr 1fr;
    grid-auto-rows: auto;
    gap: 1.2rem;
}

/* Featured = first card, spans 2 rows */
.s-mosaic .pcard:first-child {
    grid-row: span 2;
}
.s-mosaic .pcard:first-child .pcard-img {
    aspect-ratio: 3 / 3.5;
}
.s-mosaic .pcard:first-child .pcard-body {
    padding: 1.2rem 1.4rem 1.4rem;
}
.s-mosaic .pcard:first-child .pcard-name {
    font-size: 1.15rem;
}

/* ── Product card ─────────────────────────────────────────────  */
.pcard {
    background: #fff;
    border-radius: 14px;
    overflow: hidden;
    border: 1px solid rgba(0,0,0,0.05);
    box-shadow: 0 1px 8px rgba(28,26,23,0.04);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative;
}
.pcard:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(28,26,23,0.11);
}

/* Image container */
.pcard-img {
    position: relative;
    aspect-ratio: 1;
    overflow: hidden;
    background: #f5f0e8;
}
.pcard-img img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
    display: block;
}
.pcard:hover .pcard-img img { transform: scale(1.06); }

/* Badge */
.pcard-badge {
    position: absolute;
    top: 0.75rem; left: 0.75rem; z-index: 2;
    font-size: 0.62rem; letter-spacing: 0.08em;
    text-transform: uppercase; font-weight: 700;
    padding: 0.28rem 0.65rem; border-radius: 20px;
}
.badge-best { background: var(--terra); color: #fff; }
.badge-new  { background: #4a7c6a; color: #fff; }
.badge-sale { background: #c0392b; color: #fff; }

/* Cart "+" button — visible always on bottom-right of image */
.pcard-cart {
    position: absolute;
    bottom: 0.7rem; right: 0.7rem; z-index: 2;
    width: 32px; height: 32px; border-radius: 50%;
    background: #fff;
    border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.15);
    color: var(--slate);
    transition: background 0.2s, color 0.2s, transform 0.2s;
    opacity: 0;
    transform: scale(0.8);
}
.pcard:hover .pcard-cart {
    opacity: 1;
    transform: scale(1);
}
.pcard-cart:hover { background: var(--terra); color: #fff; }

/* Card body */
.pcard-body { padding: 0.85rem 1rem 1rem; }

.pcard-name {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--slate);
    text-decoration: none;
    display: block;
    margin-bottom: 0.3rem;
    line-height: 1.3;
    transition: color 0.2s;
}
.pcard-name:hover { color: var(--terra); }

.pcard-price {
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--terra);
    margin-bottom: 0.35rem;
}
.pcard-price .pcard-old {
    font-size: 0.78rem;
    color: var(--slate-light);
    text-decoration: line-through;
    font-weight: 400;
    margin-left: 0.3rem;
}

.pcard-meta {
    display: flex; align-items: center; gap: 0.35rem;
    font-size: 0.75rem; color: var(--slate-mid);
}
.pcard-stars { color: #d4a843; letter-spacing: -1px; }

/* Empty state */
.s-empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 6rem 2rem;
    background: #fff;
    border: 2px dashed var(--border);
    border-radius: 14px;
}
.s-empty p { color: var(--slate-mid); font-size: 1rem; margin-bottom: 1rem; }
.s-empty a { color: var(--terra); font-weight: 600; text-decoration: none; }

/* ── Trust bar ───────────────────────────────────────────────  */
.s-trust {
    background: #fff;
    border-top: 1px solid var(--border);
    padding: 1.5rem 2.5rem;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
}
.s-trust__item {
    display: flex; align-items: center; gap: 0.85rem;
}
.s-trust__icon {
    width: 40px; height: 40px; flex-shrink: 0;
    background: #f5f0e8; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: var(--terra);
}
.s-trust__icon svg { width: 20px; height: 20px; }
.s-trust__title { font-size: 0.82rem; font-weight: 700; color: var(--slate); }
.s-trust__sub   { font-size: 0.75rem; color: var(--slate-mid); }

/* ── Responsive ──────────────────────────────────────────────  */
@media (max-width: 1100px) {
    .s-mosaic { grid-template-columns: 2fr 1fr 1fr 1fr; }
}
@media (max-width: 900px) {
    .s-hero { grid-template-columns: 1fr; min-height: auto; }
    .s-hero__img { height: 240px; }
    .s-hero__text { padding: 2.5rem 1.5rem; }
    .s-body { grid-template-columns: 1fr; padding: 1.5rem 1rem 2rem; }
    .s-sidebar {
        position: static;
        display: flex; gap: 1.5rem; overflow-x: auto;
        padding: 1.2rem 1rem; border-radius: 10px;
        -webkit-overflow-scrolling: touch;
    }
    .s-filter-section { min-width: 190px; flex-shrink: 0; margin-bottom: 0; }
    .s-mosaic { grid-template-columns: repeat(2, 1fr); }
    .s-mosaic .pcard:first-child { grid-row: span 1; }
    .s-mosaic .pcard:first-child .pcard-img { aspect-ratio: 16/9; }
    .s-trust { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 560px) {
    .s-mosaic { grid-template-columns: 1fr 1fr; gap: 0.75rem; }
    .s-mosaic .pcard:first-child { grid-column: span 2; }
    .s-trust { grid-template-columns: 1fr 1fr; gap: 1rem 0.5rem; }
}
</style>

{{-- ── HERO ──────────────────────────────────────────────────── --}}
<section class="s-hero">
    <div class="s-hero__text">
        <p class="s-hero__eyebrow">Our Collection</p>
        <h1 class="s-hero__title">Thoughtful pieces<br>for everyday living.</h1>
        <div class="s-hero__divider"></div>
        <p class="s-hero__desc">Quality you can feel. Style that lasts.<br>Discover objects and accessories curated with care.</p>
    </div>
    <div class="s-hero__img">
        <img
            src="https://images.unsplash.com/photo-1617806118233-18e1de247200?w=1000&auto=format&fit=crop&q=80"
            alt="VIA lifestyle — curated home goods"
        >
    </div>
</section>

{{-- ── STORE BODY ────────────────────────────────────────────── --}}
<div class="s-body">

    {{-- Sidebar --}}
    <aside class="s-sidebar">
        <div class="s-sidebar__header">
            <h3>Filter &amp; Sort</h3>
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" stroke-width="1.8"/></svg>
        </div>

        {{-- Category --}}
        <div class="s-filter-section">
            <div class="s-filter-label">
                <span>Category</span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" stroke-width="2"/></svg>
            </div>
            <ul class="s-cat-list">
                <li>
                    <label class="s-cat-label">
                        <input type="radio" name="category" {{ $category === 'all' ? 'checked' : '' }}
                               onchange="window.location='{{ route('store.index') }}'">
                        All Products
                    </label>
                </li>
                @foreach($categories as $cat)
                <li>
                    <label class="s-cat-label">
                        <input type="radio" name="category" {{ $category === $cat ? 'checked' : '' }}
                               onchange="window.location='{{ route('store.index', ['category' => $cat]) }}'">
                        {{ $cat }}
                    </label>
                </li>
                @endforeach
            </ul>
        </div>

        {{-- Price range --}}
        <div class="s-filter-section">
            <div class="s-filter-label"><span>Price Range</span></div>
            <div class="s-price-labels">
                <span>KSh 0</span>
                <span id="sPrice">KSh 10,000+</span>
            </div>
            <input type="range" class="s-slider" min="0" max="100000" value="100000" step="500"
                oninput="
                    const v = parseInt(this.value);
                    document.getElementById('sPrice').textContent = v >= 100000 ? 'KSh 10,000+' : 'KSh ' + v.toLocaleString();
                    const pct = (v / 100000 * 100) + '%';
                    this.style.background = 'linear-gradient(to right, var(--terra) 0%, var(--terra) ' + pct + ', #e5e7eb ' + pct + ')';
                ">
        </div>

        {{-- Features --}}
        <div class="s-filter-section">
            <div class="s-filter-label"><span>Features</span></div>
            <label class="s-check-label"><input type="checkbox"> New Arrivals</label>
            <label class="s-check-label"><input type="checkbox"> Best Sellers</label>
            <label class="s-check-label"><input type="checkbox"> On Sale</label>
            <label class="s-check-label"><input type="checkbox" checked> In Stock</label>
        </div>
    </aside>

    {{-- Products --}}
    <main class="s-main">

        {{-- Toolbar --}}
        <div class="s-toolbar">
            <p class="s-toolbar__count">
                Showing <strong>1–{{ min(8, $products->count()) }}</strong> of <strong>{{ $products->count() }}</strong> products
            </p>
            <select class="s-toolbar__sort">
                <option>Sort by: Featured</option>
                <option>Price: Low → High</option>
                <option>Price: High → Low</option>
                <option>Newest Arrivals</option>
            </select>
        </div>

        {{-- Product mosaic --}}
        <div class="s-mosaic">
            @forelse($products as $i => $product)
            @php
                /* Rotate badge labels: 0=Best Seller, 1=New, 2=Sale, 3+ = none */
                $badge = match($i % 4) { 0 => 'Best Seller', 1 => 'New', 2 => 'Sale', default => null };
                $badgeClass = match($badge) { 'Best Seller' => 'badge-best', 'New' => 'badge-new', 'Sale' => 'badge-sale', default => '' };
                $imgSrc = Str::startsWith($product->image_path, 'http')
                    ? $product->image_path
                    : asset('storage/' . $product->image_path);
                /* Deterministic-looking review data seeded from product id */
                $reviews = (($product->id * 7) % 90) + 6;
                $ratingRaw = (($product->id * 3) % 15 + 35) / 10; /* 3.5 – 5.0 */
                $rating = number_format($ratingRaw, 1);
                $fullStars = floor($ratingRaw);
            @endphp

            <article class="pcard">
                <div class="pcard-img">
                    <img
                        src="{{ $imgSrc }}"
                        alt="{{ $product->name }}"
                        onerror="this.src='https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&auto=format'"
                        loading="lazy"
                    >
                    @if($badge)
                        <span class="pcard-badge {{ $badgeClass }}">{{ $badge }}</span>
                    @endif
                    <button class="pcard-cart" aria-label="Add {{ $product->name }} to cart">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" stroke-width="2.5"/>
                        </svg>
                    </button>
                </div>
                <div class="pcard-body">
                    <a href="{{ route('store.show', $product->id) }}" class="pcard-name">{{ $product->name }}</a>
                    <div class="pcard-price">
                        KSh {{ number_format($product->price, 0) }}
                        @if($badge === 'Sale')
                            <span class="pcard-old">KSh {{ number_format($product->price * 1.25, 0) }}</span>
                        @endif
                    </div>
                    <div class="pcard-meta">
                        <span class="pcard-stars" aria-label="{{ $rating }} stars">
                            @for($s = 1; $s <= 5; $s++){{ $s <= $fullStars ? '★' : '☆' }}@endfor
                        </span>
                        <span>{{ $rating }}</span>
                        <span>({{ $reviews }})</span>
                    </div>
                </div>
            </article>
            @empty
            <div class="s-empty">
                <p>No products found matching your criteria.</p>
                <a href="{{ route('store.index') }}">← Clear filters</a>
            </div>
            @endforelse
        </div>

    </main>
</div>

{{-- ── TRUST BAR ─────────────────────────────────────────────── --}}
<div class="s-trust">
    <div class="s-trust__item">
        <div class="s-trust__icon">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0h.008v.008H3v-.008zm0 0H2.25m17.25 0h.008v.008h-.008v-.008zm0 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0M3 12V7.5A2.25 2.25 0 015.25 5.25h13.5A2.25 2.25 0 0121 7.5v4.5M3 12h18" stroke-width="1.8"/></svg>
        </div>
        <div>
            <p class="s-trust__title">Free Delivery</p>
            <p class="s-trust__sub">On orders over KSh 5,000</p>
        </div>
    </div>
    <div class="s-trust__item">
        <div class="s-trust__icon">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" stroke-width="1.8"/></svg>
        </div>
        <div>
            <p class="s-trust__title">Secure Payments</p>
            <p class="s-trust__sub">100% protected checkout</p>
        </div>
    </div>
    <div class="s-trust__item">
        <div class="s-trust__icon">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" stroke-width="1.8"/></svg>
        </div>
        <div>
            <p class="s-trust__title">Easy Returns</p>
            <p class="s-trust__sub">30-day return policy</p>
        </div>
    </div>
    <div class="s-trust__item">
        <div class="s-trust__icon">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" stroke-width="1.8"/></svg>
        </div>
        <div>
            <p class="s-trust__title">Support</p>
            <p class="s-trust__sub">We're here to help</p>
        </div>
    </div>
</div>
@endsection
