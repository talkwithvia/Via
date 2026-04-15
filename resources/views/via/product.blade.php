@extends('layouts.via')

@section('content')
<style>
    .pdp-container { max-width: 1200px; margin: 4rem auto; padding: 0 2rem; display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; }
    
    .pdp-image-col {
        background: var(--white); border-radius: var(--radius-lg); padding: 4rem;
        display: flex; align-items: center; justify-content: center; box-shadow: var(--shadow-sm);
        aspect-ratio: 1/1; position: relative; overflow: hidden; border: 1px solid var(--border);
    }
    .pdp-image { max-width: 100%; max-height: 100%; object-fit: contain; }

    .pdp-info-col { display: flex; flex-direction: column; justify-content: center; }
    .pdp-category { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.15em; color: var(--terra); font-weight: 600; margin-bottom: 1rem; }
    .pdp-title { font-family: 'Cormorant Garamond', serif; font-size: 3.5rem; font-weight: 500; color: var(--slate); line-height: 1.1; margin-bottom: 1rem; }
    
    .pdp-price { font-size: 1.5rem; font-weight: 600; color: var(--slate); margin-bottom: 2rem; display: flex; align-items: baseline; gap: 0.5rem; }
    
    .pdp-desc { font-size: 1.05rem; color: var(--slate-mid); line-height: 1.7; margin-bottom: 2.5rem; }

    .color-selector { display: flex; gap: 1rem; margin-bottom: 2rem; }
    .color-label { font-size: 0.85rem; font-weight: 600; color: var(--slate); margin-bottom: 1rem; display: block; }
    .color-btn { width: 36px; height: 36px; border-radius: 50%; border: 2px solid transparent; cursor: pointer; padding: 3px; transition: var(--transition); background-clip: content-box; }
    .color-btn.active { border-color: var(--slate); }
    .color-btn[data-color="1"] { background-color: var(--slate); }
    .color-btn[data-color="2"] { background-color: var(--terra); }
    .color-btn[data-color="3"] { background-color: #7c947a; }

    .stock-status {
        display: inline-flex; align-items: center; padding: 0.5rem 1rem;
        background: rgba(16, 185, 129, 0.1); color: #10b981;
        font-size: 0.85rem; font-weight: 600; border-radius: var(--radius-pill); margin-bottom: 2rem;
    }
    .stock-status.out { color: #ef4444; background: rgba(239, 68, 68, 0.1); }

    .btn-add {
        width: 100%; background: var(--terra); color: var(--white); border: none; padding: 1.25rem;
        font-size: 1.1rem; font-weight: 600; border-radius: var(--radius-pill); cursor: pointer;
        transition: var(--transition); box-shadow: 0 4px 14px rgba(178,115,77,0.3); display: flex; align-items: center; justify-content: center; gap: 0.5rem;
    }
    .btn-add:hover { background: var(--terra-dark); transform: translateY(-2px); }
    .btn-add:disabled { background: var(--slate-light); box-shadow: none; cursor: not-allowed; transform: none; }
    
    .section-related { max-width: 1200px; margin: 6rem auto; padding: 0 2rem; }
    .section-related h3 { font-family: 'Cormorant Garamond', serif; font-size: 2.5rem; margin-bottom: 2rem; text-align: center; }

    .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 2rem; }
    .product-card { background: var(--white); border-radius: var(--radius-lg); padding: 1rem; border: 1px solid var(--border); position: relative; overflow: hidden; transition: var(--transition); }
    .product-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-md); border-color: transparent; }
    .product-img-box { position: relative; border-radius: var(--radius-md); overflow: hidden; aspect-ratio: 1; background: var(--cream); margin-bottom: 1rem; }
    .product-img-box img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s; }
    .product-card:hover .product-img-box img { transform: scale(1.05); }
    .product-cat { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-light); font-weight: 600; margin-bottom: 0.25rem; }
    .product-title { font-size: 1.1rem; font-weight: 600; color: var(--slate); margin-bottom: 0.5rem; text-decoration: none; display: block; }
    .product-btm { display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; }
    .product-price { font-weight: 600; color: var(--terra); }

    @media (max-width: 900px) {
        .pdp-container { grid-template-columns: 1fr; gap: 2rem; padding: 1rem; margin: 1rem auto; }
        .pdp-image-col { padding: 2rem; }
        .pdp-title { font-size: 2.5rem; }
        .section-related { padding: 0 1rem; margin: 4rem auto; }
        
        /* ── Horizontal Scrolling Grid ── */
        .product-grid { 
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            gap: 1.5rem;
            padding-bottom: 1.5rem;
            -webkit-overflow-scrolling: touch;
            scroll-snap-type: x mandatory;
            scrollbar-width: none; /* Hide scrollbar Firefox */
        }
        .product-grid::-webkit-scrollbar { display: none; } /* Hide scrollbar Chrome/Safari */
        
        .product-card { 
            min-width: 280px;
            scroll-snap-align: center;
            flex-shrink: 0;
        }
    }
</style>

<div class="pdp-container">
    <div class="pdp-image-col">
        <img src="{{ Str::startsWith($product->image_path, 'http') ? $product->image_path : asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="pdp-image" onerror="this.src='https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=800&auto=format'">
    </div>
    
    <div class="pdp-info-col">
        <div class="pdp-category">{{ $product->category }}</div>
        <h1 class="pdp-title">{{ $product->name }}</h1>
        
        <div style="font-size: 1rem; color: #fbbf24; margin-bottom: 1.5rem;">★★★★★ <span style="color: var(--slate-mid); font-size: 0.9rem;">(128 reviews)</span></div>

        <div class="pdp-price">${{ number_format($product->price, 2) }}</div>
        <p class="pdp-desc">{{ $product->description }}</p>

        <div>
            <span class="color-label">Color</span>
            <div class="color-selector">
                <button class="color-btn active" data-color="1" aria-label="Slate"></button>
                <button class="color-btn" data-color="2" aria-label="Terra"></button>
                <button class="color-btn" data-color="3" aria-label="Sage"></button>
            </div>
        </div>

        @if($product->stock > 0)
            <div class="stock-status">In Stock</div>
            <button class="btn-add">Add to Cart</button>
        @else
            <div class="stock-status out">Out of Stock</div>
            <button class="btn-add" disabled>Out of Stock</button>
        @endif
    </div>
</div>

@if($relatedProducts->isNotEmpty())
<div class="section-related">
    <h3>You May Also Like</h3>
    <div class="product-grid">
        @foreach($relatedProducts as $related)
        <article class="product-card">
            <div class="product-img-box">
                <img src="{{ Str::startsWith($related->image_path, 'http') ? $related->image_path : asset('storage/' . $related->image_path) }}" alt="{{ $related->name }}" onerror="this.src='https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&auto=format'">
            </div>
            <div class="product-cat">{{ $related->category }}</div>
            <a href="{{ route('store.show', $related->id) }}" class="product-title">{{ $related->name }}</a>
            <div class="product-btm">
                <span class="product-price">${{ number_format($related->price, 2) }}</span>
            </div>
        </article>
        @endforeach
    </div>
</div>
@endif

@endsection
