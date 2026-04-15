import re

files = [
    'store.blade.php',
    'login.blade.php',
    'register.blade.php',
    'subscription.blade.php',
    'profile.blade.php'
]

# Read splash.blade.php to extract original navbar css and html
with open('resources/views/via/splash.blade.php', 'r') as f:
    splash = f.read()

# Extract CSS
# From /* ── Navigation ── */ to the next /* ──
nav_css_match = re.search(r'(/\* ── Navigation ── \*/.*?\n        )(/\* ── |</style>)', splash, re.DOTALL)
nav_css = nav_css_match.group(1)

# Extract HTML
# From <!-- ── Navigation ── --> to </nav>
nav_html_match = re.search(r'(<!-- ── Navigation ── -->\s*<nav class="navbar">.*?</nav>)', splash, re.DOTALL)
nav_html = nav_html_match.group(1)

for file in files:
    path = f'resources/views/via/{file}'
    try:
        with open(path, 'r') as f:
            content = f.read()
    except FileNotFoundError:
        continue
        
    print(f"Processing {file}...")

    # Replace CSS
    # Some files use /* Navigation */ or /* ── Navigation ── */
    # Find start and end of nav css block 
    old_css_match = re.search(r'/\* ── Navigation ── \*/.*?}(?=\s*/\* ──|\s*</style>)', content, re.DOTALL)
    if not old_css_match:
        old_css_match = re.search(r'/\* Navigation \*/.*?}(?=\s*/\* ──|\s*</style>|\s*/\* Main)', content, re.DOTALL)
    if not old_css_match:
         # in store.blade.php it was /* ── Navigation (Matched to Splash) ── */
         old_css_match = re.search(r'/\* ── Navigation \(Matched to Splash\) ── \*/.*?}(?=\s*/\* ──|\s*</style>)', content, re.DOTALL)

    if old_css_match:
        content = content.replace(old_css_match.group(0) + "\n        ", nav_css)
    else:
        print(f"Could not find css in {file}")

    # Replace HTML
    # It starts with <!-- Navigation --> or <!-- ── Navigation ── -->
    old_html_match = re.search(r'<!-- [─]*\s*Navigation\s*[─]* -->\s*<nav class="navbar">.*?</nav>', content, re.DOTALL)
    
    if old_html_match:
        # Customize the nav html based on the page
        custom_html = nav_html
        
        # Remove active from Home usually
        custom_html = custom_html.replace('href="/" class="active"', 'href="/"')
        
        # Add active where needed
        if file == 'store.blade.php':
            custom_html = custom_html.replace('href="/store"', 'href="/store" class="active"')
        elif file == 'subscription.blade.php':
            custom_html = custom_html.replace('href="/subscribe"', 'href="/subscribe" class="active"')
            
        content = content.replace(old_html_match.group(0), custom_html)
    else:
        print(f"Could not find html in {file}")

    with open(path, 'w') as f:
        f.write(content)
    
    print(f"Updated {file}")

