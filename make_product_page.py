import re

with open('resources/views/via/store.blade.php', 'r') as f:
    store = f.read()

# 1. Extract everything up to </style>
css_match = re.search(r'(.*?</style>)', store, re.DOTALL)
top_html_css = css_match.group(1)

# 2. Extract Nav block (from <nav> to </nav>)
# Also get the announcement banner
announcement_match = re.search(r'(<!-- ── Announcement Banner ── -->.*?</div>)', store, re.DOTALL)
announcement = announcement_match.group(1) if announcement_match else ""

nav_match = re.search(r'(<nav class="navbar">.*?</nav>)', store, re.DOTALL)
nav = nav_match.group(1) if nav_match else ""

# 3. Form the base CSS layout for product page
pdp_css = """
        /* ── PDP Styles ── */
        .pdp-container {
            max-width: 1200px;
            margin: 4rem auto;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
        }

        .pdp-image-col {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 4rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-sm);
            aspect-ratio: 1/1;
        }

        .pdp-image {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            transition: filter 0.3s;
        }

        .pdp-icon {
            width: 140px;
            height: 140px;
            color: var(--slate);
            opacity: 0.1;
        }

        .pdp-info-col {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .pdp-category {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: var(--terra);
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .pdp-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 3rem;
            font-weight: 500;
            color: var(--slate);
            line-height: 1.1;
            margin-bottom: 1rem;
        }

        .pdp-price {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--slate);
            margin-bottom: 2rem;
            display: flex;
            align-items: baseline;
            gap: 0.3rem;
        }

        .pdp-price span {
            font-size: 0.9rem;
            color: var(--muted);
            font-weight: 500;
        }

        .pdp-desc {
            font-size: 1rem;
            color: var(--slate-mid);
            line-height: 1.7;
            margin-bottom: 2.5rem;
        }

        /* ── Options (Color) ── */
        .pdp-options {
            margin-bottom: 2.5rem;
        }

        .pdp-options-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--slate);
            margin-bottom: 1rem;
        }

        .color-selector {
            display: flex;
            gap: 1rem;
        }

        .color-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 2px solid transparent;
            cursor: pointer;
            padding: 3px;
            transition: all 0.2s;
            background-clip: content-box;
        }
        
        .color-btn.active {
            border-color: var(--slate);
        }

        /* Standard simulated colors */
        .color-btn[data-color="1"] { background-color: var(--slate); }
        .color-btn[data-color="2"] { background-color: var(--terra); }
        .color-btn[data-color="3"] { background-color: #7c947a; } /* Sage */
        .color-btn[data-color="4"] { background-color: var(--cream-dark); border: 2px solid var(--border); } 

        .stock-status {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            font-weight: 500;
            color: #10b981;
            margin-bottom: 2rem;
            padding: 0.5rem 1rem;
            background: rgba(16, 185, 129, 0.1);
            border-radius: var(--radius-pill);
        }

        .stock-status.out {
            color: #ef4444;
            background: rgba(239, 68, 68, 0.1);
        }

        .btn-add-huge {
            width: 100%;
            background: var(--slate);
            color: var(--white);
            border: none;
            padding: 1.25rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: var(--radius-pill);
            cursor: pointer;
            transition: transform 0.2s, background 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-add-huge:hover:not(:disabled) {
            background: #000;
            transform: translateY(-2px);
        }

        .btn-add-huge:disabled {
            background: var(--muted);
            cursor: not-allowed;
            transform: none;
        }

        /* ── Related Products ── */
        .related-section {
            max-width: 1200px;
            margin: 6rem auto 4rem;
            padding: 0 2rem;
        }

        .related-section h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.2rem;
            font-weight: 500;
            color: var(--slate);
            margin-bottom: 2rem;
            text-align: center;
        }

        .related-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }

        .breadcrumb {
            max-width: 1200px;
            margin: 2rem auto 0;
            padding: 0 2rem;
            font-size: 0.85rem;
            color: var(--muted);
        }
        .breadcrumb a {
            color: var(--slate);
            text-decoration: none;
            font-weight: 500;
        }
        .breadcrumb span {
            margin: 0 0.5rem;
        }
</style>
"""

top_html_css = top_html_css.replace('</style>', pdp_css)

# 4. Form HTML body
pdp_html = f"""</head>
<body>
    {announcement}
    {nav}

    <div class="breadcrumb">
        <a href="/store">Store</a> <span>/</span> <a href="/store?category={{{{ urlencode($product->category) }}}}">{{{{ $product->category }}}}</a> <span>/</span> {{{{ $product->name }}}}
    </div>

    <main class="pdp-container">
        <!-- Left: Image Gallery -->
        <div class="pdp-image-col">
            @if($product->image_path)
                <img src="{{{{ asset('storage/' . $product->image_path) }}}}" alt="{{{{ $product->name }}}}" class="pdp-image" id="mainProdImage">
            @else
                <svg class="pdp-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                    <circle cx="12" cy="12" r="10"/>
                </svg>
            @endif
        </div>

        <!-- Right: Info -->
        <div class="pdp-info-col">
            <div class="pdp-category">{{{{ $product->category }}}}</div>
            <h1 class="pdp-title">{{{{ $product->name }}}}</h1>
            <div class="pdp-price">
                {{{{ number_format($product->price, 2) }}}} <span>KES</span>
            </div>

            <p class="pdp-desc">
                {{{{ $product->description ?: 'An elegant choice carefully refined for simplicity and function. This premium selection complements any modern lifestyle while maintaining superior quality.' }}}}
            </p>

            <div class="pdp-options">
                <span class="pdp-options-label">Select Color Edition</span>
                <div class="color-selector">
                    <button class="color-btn active" data-color="1" data-hue="0" onclick="selectColor(this)" aria-label="Original Slider"></button>
                    <button class="color-btn" data-color="2" data-hue="30" onclick="selectColor(this)" aria-label="Terra Slider"></button>
                    <button class="color-btn" data-color="3" data-hue="90" onclick="selectColor(this)" aria-label="Sage Slider"></button>
                    <button class="color-btn" data-color="4" data-hue="-45" onclick="selectColor(this)" aria-label="Cream Slider"></button>
                </div>
            </div>

            @if($product->stock > 0)
                <div class="stock-status">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                    In Stock ({{{{ $product->stock }}}} available)
                </div>
                <button class="btn-add-huge" onclick="triggerAdded()">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                    Add to Cart
                </button>
            @else
                 <div class="stock-status out">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Out of Stock Currently
                </div>
                <button class="btn-add-huge" disabled>
                    Currently Unavailable
                </button>
            @endif
        </div>
    </main>

    @if($relatedProducts->count() > 0)
    <section class="related-section">
        <h2>You Might Also Like</h2>
        <div class="related-grid" style="display:flex; gap:1.5rem; justify-content:center; flex-wrap:wrap">
            @foreach($relatedProducts as $related)
                <div class="product-card" style="width:260px; background:var(--white); padding:1rem; border-radius:16px; text-align:center; box-shadow:var(--shadow-sm)">
                    <a href="{{{{ route('store.show', $related->id) }}}}" style="display:block; text-decoration:none">
                        <div style="aspect-ratio:1/1; background:var(--cream); border-radius:12px; margin-bottom:1rem; display:flex; align-items:center; justify-content:center; overflow:hidden;">
                            @if($related->image_path)
                                <img src="{{{{ asset('storage/' . $related->image_path) }}}}" alt="{{{{ $related->name }}}}" style="max-height:80%; max-width:80%; object-fit:contain">
                            @else
                                <svg style="width:40px; color:var(--slate); opacity:0.2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                     <circle cx="12" cy="12" r="10"/>
                                </svg>
                            @endif
                        </div>
                        <h4 style="font-size:0.9rem; font-weight:600; color:var(--slate); margin-bottom:0.25rem">{{{{ $related->name }}}}</h4>
                        <div style="font-size:0.85rem; color:var(--muted)">{{{{ number_format($related->price, 2) }}}} KES</div>
                    </a>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    <script>
        // Simple Color Simulator using Hue Rotate on the image
        function selectColor(btn) {{
            // Remove active from all
            document.querySelectorAll('.color-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            
            // Check hue
            let hue = btn.getAttribute('data-hue');
            let img = document.getElementById('mainProdImage');
            
            // Apply a CSS filter to the image to simulate color changing if an image exists
            if (img) {{
                img.style.filter = `hue-rotate(${{hue}}deg) saturate(1.2)`;
            }}
        }}

        function triggerAdded() {{
            let btn = document.querySelector('.btn-add-huge');
            let original = btn.innerHTML;
            btn.innerHTML = `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> Added to Cart`;
            btn.style.background = '#10b981';
            
            setTimeout(() => {{
                btn.innerHTML = original;
                btn.style.background = '';
            }}, 2000);
        }}
    </script>
</body>
</html>
"""

final = top_html_css + pdp_html

with open('resources/views/via/product.blade.php', 'w') as f:
    f.write(final)

print("Product page generated successfully.")
