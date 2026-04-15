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

    .hero-image-wrap { flex: 1; position: relative; }
    .hero-image { width: 100%; border-radius: var(--radius-lg); object-fit: cover; aspect-ratio: 4/5; box-shadow: var(--shadow-hover); }
    .hero-badge {
        position: absolute; bottom: 2rem; left: -2rem; background: var(--white);
        padding: 1rem 1.5rem; border-radius: var(--radius-md); box-shadow: var(--shadow-md);
        display: flex; align-items: center; gap: 1rem;
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
        position: absolute; top: 1rem; right: 1rem; display: flex; flex-direction: column; gap: 0.5rem;
        transform: translateX(20px); opacity: 0; transition: var(--transition);
    }
    .product-card:hover .product-actions { transform: translateX(0); opacity: 1; }
    .product-actions button {
        background: var(--white); border: none; width: 36px; height: 36px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center; cursor: pointer;
        box-shadow: var(--shadow-sm); transition: var(--transition); color: var(--slate-mid);
    }
    .product-actions button:hover { background: var(--terra); color: var(--white); }

    .product-cat { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-light); font-weight: 600; margin-bottom: 0.25rem; }
    .product-title { font-size: 1.1rem; font-weight: 600; color: var(--slate); margin-bottom: 0.5rem; text-decoration: none; display: block; transition: var(--transition); }
    .product-title:hover { color: var(--terra); }
    
    .product-btm { display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; }
    .product-price { font-weight: 600; color: var(--terra); font-size: 1.1rem; }
    .add-cart-btn {
        background: var(--slate); color: var(--white); border: none; width: 36px; height: 36px;
        border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: var(--transition);
    }
    .add-cart-btn:hover { background: var(--terra); transform: rotate(90deg); }

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
                    <button aria-label="Add to Wishlist"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" stroke-width="2"/></svg></button>
                    <button aria-label="Quick View"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178zM15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2"/></svg></button>
                </div>
            </div>
            <div class="product-cat">{{ $product->category }}</div>
            <a href="{{ route('store.show', $product->id) }}" class="product-title">{{ $product->name }}</a>
            <div style="font-size: 0.8rem; color: #fbbf24;">★★★★★ <span style="color: var(--slate-mid);">5.0</span></div>
            <div class="product-btm">
                <span class="product-price">${{ number_format($product->price, 2) }}</span>
                <button class="add-cart-btn" aria-label="Add to cart">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" stroke-width="2"/></svg>
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
