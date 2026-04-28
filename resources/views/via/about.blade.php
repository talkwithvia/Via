@extends('layouts.via')

@section('content')
<style>
    .about-header { text-align: center; padding: 2rem 1rem; background: var(--white); border-bottom: 1px solid var(--border); }
    .about-header h1 { font-family: 'Cormorant Garamond', serif; font-size: 4rem; color: var(--slate); margin-bottom: 1rem; }
    .about-header p { color: var(--slate-mid); font-size: 1.25rem; max-width: 600px; margin: 0 auto; }

    .about-section { padding: 5rem 1 artisrem; max-width: 1000px; margin: 0 auto; }
    
    .story-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center; margin-bottom: 6rem; }
    .story-content h2 { font-family: 'Cormorant Garamond', serif; font-size: 2.5rem; color: var(--slate); margin-bottom: 1.5rem; }
    .story-content p { color: var(--slate-mid); margin-bottom: 1.5rem; font-size: 1.05rem; }
    .story-img { border-radius: var(--radius-lg); max-width: 100%; height: auto; box-shadow: var(--shadow-md); }

    .values-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 3rem; margin-bottom: 6rem; }
    .value-card h3 { font-size: 1.25rem; color: var(--slate); margin-bottom: 1rem; }
    .value-card p { color: var(--slate-mid); }

    .team-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem; }
    .team-member { text-align: center; }
    .team-member img { width: 100%; aspect-ratio: 1; object-fit: cover; border-radius: var(--radius-lg); margin-bottom: 1rem; }
    .team-member h4 { font-size: 1.1rem; color: var(--slate); margin-bottom: 0.25rem; }
    .team-member span { color: var(--terra); font-size: 0.9rem; font-weight: 500; }

    .cta-banner { background: var(--slate); color: var(--white); text-align: center; padding: 5rem 2rem; border-radius: var(--radius-lg); margin-top: 4rem; }
    .cta-banner h2 { font-family: 'Cormorant Garamond', serif; font-size: 3rem; margin-bottom: 1rem; }
    .cta-banner p { color: var(--slate-light); margin-bottom: 2rem; max-width: 500px; margin-left: auto; margin-right: auto; }
    .btn-terra { display: inline-block; padding: 1rem 2rem; background: var(--terra); color: var(--white); font-weight: 600; text-decoration: none; border-radius: var(--radius-pill); transition: var(--transition); }
    .btn-terra:hover { background: var(--terra-dark); transform: translateY(-2px); }

    @media (max-width: 900px) {
        .about-header { padding: 3rem 1rem; }
        .about-header h1 { font-size: 2.5rem; }
        .about-header p { font-size: 1.1rem; }
        .about-section { padding: 2rem 1rem; }
        .story-grid { grid-template-columns: 1fr; gap: 2rem; margin-bottom: 4rem; }
        .story-content h2 { font-size: 2rem; }
        .values-grid { gap: 1.5rem; margin-bottom: 4rem; }
        .cta-banner { padding: 3rem 1.5rem; }
        .cta-banner h2 { font-size: 2.2rem; }
    }
</style>

<header class="about-header">
    <h1>About Our Store</h1>
    <p>Discover who we are, what we believe in, and why we do what we do.</p>
</header>

<main class="about-section">
    
    <div class="story-grid">
        <div class="story-content">
            <h2>Built with Passion, Driven by Quality</h2>
            <p>At VIA, our journey began with a simple idea: to provide professionals with gear that perfectly balances elegant aesthetics with rugged durability. We noticed a gap in the market for goods that transition seamlessly from the boardroom to the weekend getaway.</p>
            <p>Our commitment to quality ensures that every material is ethically sourced and rigorously tested. Making your experience delightful is our main priority.</p>
            <a href="/store" style="color: var(--terra); font-weight: 600; text-decoration: none; margin-top: 1rem; display: inline-block;">Shop Our Collection &rarr;</a>
        </div>
        <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&q=80&w=800" alt="Team collaborating" class="story-img">
    </div>

    <h2 style="font-family: 'Cormorant Garamond', serif; font-size: 2.5rem; text-align: center; margin-bottom: 3rem;">Our Core Values</h2>
    <div class="values-grid">
        <div class="value-card">
            <h3>Uncompromising Quality</h3>
            <p>Every product in our store is hand-picked and tested to meet our strict quality standards. We never compromise on quality – neither should you.</p>
        </div>
        <div class="value-card">
            <h3>Global Sustainability</h3>
            <p>We are committed to sustainable sourcing, eco-friendly packaging, and reducing our carbon footprint. Shopping here means choosing a better future.</p>
        </div>
        <div class="value-card">
            <h3>Customer Happiness</h3>
            <p>Your satisfaction is our top priority. From fast shipping to hassle-free returns, we've built every process around making your experience delightful.</p>
        </div>
        <div class="value-card">
            <h3>Fair & Transparent Pricing</h3>
            <p>No hidden fees. No surprise charges. We believe in honest pricing and regularly run promotions so you always get the best possible value.</p>
        </div>
    </div>

    <h2 style="font-family: 'Cormorant Garamond', serif; font-size: 2.5rem; text-align: center; margin-bottom: 3rem;">Meet the Team</h2>
    <div class="team-grid">
        <div class="team-member">
            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&q=80&w=400" alt="CEO">
            <h4>Sarah Jenkins</h4>
            <span>Founder & CEO</span>
        </div>
        <div class="team-member">
            <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&q=80&w=400" alt="Operations">
            <h4>Marcus Cole</h4>
            <span>Head of Operations</span>
        </div>
        <div class="team-member">
            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=400" alt="Design">
            <h4>Elena Rodriguez</h4>
            <span>Lead Designer</span>
        </div>
        <div class="team-member">
            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&q=80&w=400" alt="Support">
            <h4>David Kim</h4>
            <span>Customer Success</span>
        </div>
    </div>

    <div class="cta-banner">
        <h2>Ready to Start Shopping?</h2>
        <p>Explore our full range of products and find exactly what you're looking for. Free shipping on orders over $75.</p>
        <a href="/store" class="btn-terra">Browse Products</a>
    </div>

</main>
@endsection
