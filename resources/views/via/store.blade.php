@extends('layouts.via')

@section('content')
<style>
    .store-header { text-align: center; padding: 4rem 2rem; background: var(--white); border-bottom: 1px solid var(--border); }
    .store-header h1 { font-family: 'Cormorant Garamond', serif; font-size: 3.5rem; color: var(--slate); margin-bottom: 1rem; }
    .store-header p { color: var(--slate-mid); max-width: 600px; margin: 0 auto; }

    .shop-container { max-width: 1400px; margin: 0 auto; padding: 4rem 2rem; display: grid; grid-template-columns: 240px 1fr; gap: 3rem; }
    
    /* Sidebar */
    .sidebar-block { margin-bottom: 2.5rem; }
    .sidebar-title { font-size: 1.05rem; font-weight: 600; margin-bottom: 1.5rem; color: var(--slate); text-transform: uppercase; letter-spacing: 0.05em; }
    
    .filter-list { list-style: none; padding: 0; margin: 0; }
    .filter-list li { margin-bottom: 0.75rem; }
    
    .filter-link {
        display: flex; justify-content: space-between; text-decoration: none;
        color: var(--slate-mid); font-size: 0.95rem; padding: 0.5rem 0; border-radius: 6px; transition: var(--transition); align-items: center;
    }
    .filter-link:hover, .filter-link.active { color: var(--terra); font-weight: 600; }
    .filter-count { background: var(--cream); padding: 0.15rem 0.6rem; border-radius: var(--radius-pill); font-size: 0.75rem; color: var(--slate-light); }
    .filter-link.active .filter-count { background: #ebd6c9; color: var(--terra-dark); }

    .checkbox-group { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem; color: var(--slate-mid); font-size: 0.95rem; cursor: pointer; }
    .checkbox-group input { width: 16px; height: 16px; accent-color: var(--terra); }

    .color-swatches { display: flex; gap: 0.75rem; flex-wrap: wrap; }
    .color-swatch { width: 30px; height: 30px; border-radius: 50%; border: 1px solid var(--border); cursor: pointer; transition: var(--transition); }
    .color-swatch:hover { transform: scale(1.1); box-shadow: var(--shadow-sm); }

    /* Main Grid */
    .shop-toolbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 1px solid var(--border); }
    .toolbar-select { padding: 0.5rem 1rem; border: 1px solid var(--border); border-radius: 8px; font-family: inherit; font-size: 0.95rem; color: var(--slate); background: var(--white); outline: none; }
    
    .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 2rem; }
    
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
    .product-title { font-size: 1.1rem; font-weight: 600; color: var(--slate); margin-bottom: 0.5rem; text-decoration: none; display: block; }
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
        .store-header { padding: 2.5rem 1rem; }
        .store-header h1 { font-size: 2.5rem; }
        .shop-container { grid-template-columns: 1fr; padding: 2rem 1rem; }
        .sidebar { display: flex; flex-wrap: nowrap; overflow-x: auto; padding-bottom: 1rem; margin-bottom: 1rem; gap: 2rem; -webkit-overflow-scrolling: touch; }
        .sidebar-block { min-width: calc(100vw - 4rem); max-width: 300px; margin-bottom: 0; border-right: none; padding-right: 0; }
        .shop-toolbar { flex-direction: column; gap: 1rem; align-items: stretch; }
        .product-grid { grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 1.5rem; }
    }
</style>

<header class="store-header">
    <h1>Our Products</h1>
    <p>Browse our curated collection of premium goods and accessories.</p>
</header>

<div class="shop-container">
    
    <aside class="sidebar">
        <!-- Exact match for template layout requirements -->
        <h2 style="font-family: 'Cormorant Garamond', serif; font-size: 1.75rem; color: var(--slate); margin-bottom: 2rem;">Filters</h2>
        
        <div class="sidebar-block">
            <h3 class="sidebar-title">Category</h3>
            <ul class="filter-list">
                <li>
                    <a href="{{ route('store.index') }}" class="filter-link {{ $category === 'all' ? 'active' : '' }}">
                        <span>All Products</span>
                    </a>
                </li>
                @foreach($categories as $cat)
                <li>
                    <a href="{{ route('store.index', ['category' => $cat]) }}" class="filter-link {{ $category === $cat ? 'active' : '' }}">
                        <span>{{ $cat }}</span>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>

        <div class="sidebar-block">
            <h3 class="sidebar-title">Price Range</h3>
            <label class="checkbox-group"><input type="checkbox"> Under $50</label>
            <label class="checkbox-group"><input type="checkbox"> $50 to $100</label>
            <label class="checkbox-group"><input type="checkbox"> $100 to $200</label>
            <label class="checkbox-group"><input type="checkbox"> Over $200</label>
        </div>

        <div class="sidebar-block">
            <h3 class="sidebar-title">Min. Rating</h3>
            <label class="checkbox-group"><input type="radio" name="rating"> ★★★★★ (5.0)</label>
            <label class="checkbox-group"><input type="radio" name="rating"> ★★★★☆ (4.0+)</label>
            <label class="checkbox-group"><input type="radio" name="rating"> ★★★☆☆ (3.0+)</label>
        </div>

        <div class="sidebar-block">
            <h3 class="sidebar-title">Color</h3>
            <div class="color-swatches">
                <div class="color-swatch" style="background-color: #21242c;" title="Black"></div>
                <div class="color-swatch" style="background-color: #ffffff;" title="White"></div>
                <div class="color-swatch" style="background-color: #b2734d;" title="Terra"></div>
                <div class="color-swatch" style="background-color: #7c947a;" title="Sage"></div>
                <div class="color-swatch" style="background-color: #4a5568;" title="Slate"></div>
            </div>
        </div>

        <div class="sidebar-block">
            <h3 class="sidebar-title">Availability</h3>
            <label class="checkbox-group"><input type="checkbox" checked> In Stock</label>
            <label class="checkbox-group"><input type="checkbox"> Out of Stock</label>
        </div>
    </aside>

    <main>
        <div class="shop-toolbar">
            <div style="color: var(--slate-mid);">Showing <strong>{{ $products->count() }}</strong> items</div>
            <select class="toolbar-select">
                <option>Sort by: Featured</option>
                <option>Price: Low to High</option>
                <option>Price: High to Low</option>
                <option>Newest Arrivals</option>
            </select>
        </div>

        <div class="product-grid">
            @forelse($products as $product)
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
            @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 6rem 2rem; background: var(--white); border-radius: var(--radius-lg); border: 1px dashed var(--border);">
                <p style="color: var(--slate-mid); font-size: 1.1rem;">No products available matching your criteria.</p>
            </div>
            @endforelse
        </div>
    </main>
</div>
@endsection
