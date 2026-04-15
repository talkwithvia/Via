@extends('layouts.via')

@section('content')
<style>
    .contact-header { text-align: center; padding: 6rem 2rem; background: var(--white); border-bottom: 1px solid var(--border); }
    .contact-header h1 { font-family: 'Cormorant Garamond', serif; font-size: 4rem; color: var(--slate); margin-bottom: 1rem; }
    .contact-header p { color: var(--slate-mid); font-size: 1.25rem; max-width: 600px; margin: 0 auto; }

    .contact-container { max-width: 1200px; margin: 5rem auto; padding: 0 2rem; display: grid; grid-template-columns: 1fr 2fr; gap: 4rem; }
    
    .contact-info-block { margin-bottom: 2.5rem; }
    .contact-info-block h3 { font-size: 1rem; color: var(--slate-light); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem; }
    .contact-info-block p { color: var(--slate); font-size: 1.1rem; font-weight: 500; }
    
    .contact-form-card { background: var(--white); padding: 3rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); border: 1px solid var(--border); }
    .contact-form-card h2 { font-family: 'Cormorant Garamond', serif; font-size: 2.5rem; margin-bottom: 1rem; color: var(--slate); }
    .contact-form-card p { color: var(--slate-mid); margin-bottom: 2rem; }

    .form-group { margin-bottom: 1.5rem; display: flex; flex-direction: column; }
    .form-label { font-size: 0.9rem; font-weight: 600; color: var(--slate); margin-bottom: 0.5rem; }
    .form-input, .form-textarea {
        width: 100%; padding: 0.85rem; border: 1px solid var(--border); border-radius: 8px;
        font-family: inherit; font-size: 1rem; transition: var(--transition); background: var(--cream);
    }
    .form-input:focus, .form-textarea:focus { outline: none; border-color: var(--terra); background: var(--white); box-shadow: 0 0 0 3px rgba(178,115,77,0.1); }
    
    .btn-submit {
        background: var(--slate); color: var(--white); font-weight: 600; border: none; padding: 1rem 2rem;
        border-radius: var(--radius-pill); cursor: pointer; transition: var(--transition); width: 100%; font-size: 1rem;
    }
    .btn-submit:hover { background: var(--terra); }

    .faq-section { max-width: 800px; margin: 0 auto 6rem; padding: 0 2rem; }
    .faq-section h2 { font-family: 'Cormorant Garamond', serif; font-size: 2.5rem; text-align: center; margin-bottom: 3rem; color: var(--slate); }
    .faq-item { border-bottom: 1px solid var(--border); padding: 1.5rem 0; }
    .faq-item h4 { font-size: 1.1rem; color: var(--slate); margin-bottom: 0.5rem; }
    .faq-item p { color: var(--slate-mid); }

    @media (max-width: 900px) {
        .contact-header { padding: 3rem 1rem; }
        .contact-header h1 { font-size: 2.5rem; }
        .contact-container { grid-template-columns: 1fr; margin: 2rem auto; padding: 0 1rem; gap: 2.5rem; }
        .contact-form-card { padding: 1.5rem; }
        .form-grid { grid-template-columns: 1fr !important; gap: 1.5rem !important; }
        .faq-section { padding: 0 1rem; margin-bottom: 3rem; }
        .faq-section h2 { font-size: 2rem; margin-bottom: 1.5rem; }
    }
</style>

<header class="contact-header">
    <h1>Get in Touch</h1>
    <p>Have a question or feedback? We're here to help.</p>
</header>

<main>
    <div class="contact-container">
        
        <aside>
            <div class="contact-info-block">
                <h3>Email Us</h3>
                <p>support@via-odyssey.com</p>
            </div>
            <div class="contact-info-block">
                <h3>Call Us</h3>
                <p>+1 (800) 555-0199</p>
            </div>
            <div class="contact-info-block">
                <h3>Visit Us</h3>
                <p>123 Odyssey Way,<br>San Francisco, CA 94107</p>
            </div>
            <div class="contact-info-block">
                <h3>Business Hours</h3>
                <p style="color: var(--slate-mid); font-size: 0.95rem; font-weight: 400;">Mon–Fri: 9am – 6pm<br>Sat: 10am – 4pm</p>
            </div>
        </aside>

        <section class="contact-form-card">
            <h2>Send Us a Message</h2>
            <p>Fill in the form below and we'll get back to you within 24 hours.</p>
            
            <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Message sent!');">
                <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label class="form-label">First Name</label>
                        <input type="text" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Last Name</label>
                        <input type="text" class="form-input" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Message</label>
                    <textarea class="form-textarea" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn-submit">Send Message</button>
            </form>
        </section>

    </div>

    <div class="faq-section">
        <h2>Common Questions</h2>
        
        <div class="faq-item">
            <h4>How long does shipping take?</h4>
            <p>Standard shipping typically takes 3–7 business days. Express options are available at checkout. Free standard shipping on all orders over $75.</p>
        </div>
        <div class="faq-item">
            <h4>What is your return policy?</h4>
            <p>We offer a 30-day hassle-free return policy. Items must be in original condition. Simply contact our team to initiate a return and we'll guide you through the process.</p>
        </div>
        <div class="faq-item">
            <h4>Do you ship internationally?</h4>
            <p>Yes! We ship to over 50 countries worldwide. International shipping rates and delivery times vary by location. Full details are available at checkout.</p>
        </div>
        <div class="faq-item">
            <h4>Can I track my order?</h4>
            <p>Once your order ships, you'll receive an email with a tracking number. You can use this to track your delivery in real-time via our shipping partner's website.</p>
        </div>
    </div>
</main>
@endsection
