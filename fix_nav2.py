import re
import os

with open('/home/joel/Via/resources/views/via/splash.blade.php', 'r') as f:
    splash = f.read()

# CSS block extraction. It goes from /* ── Navigation ── */ up to /* ── Hero Section — Split Layout ── */
css_match = re.search(r'(/\* ── Navigation ── \*/.*?)(?=\s*/\* ── Hero Section)', splash, re.DOTALL)
if not css_match:
    print("FAILED TO FIND CSS IN SPLASH")
    exit(1)
nav_css = css_match.group(1).strip()

# HTML block extraction
html_match = re.search(r'(<nav class="navbar">.*?</nav>)', splash, re.DOTALL)
if not html_match:
    print("FAILED TO FIND HTML IN SPLASH")
    exit(1)
nav_html = html_match.group(1).strip()

files = [
    'store.blade.php',
    'login.blade.php',
    'register.blade.php',
    'subscription.blade.php',
    'profile.blade.php'
]

for file in files:
    path = f'/home/joel/Via/resources/views/via/{file}'
    if not os.path.exists(path):
        continue
    
    with open(path, 'r') as f:
        content = f.read()
        
    print(f"Modifying {file}...")
    
    # Replace CSS
    # Some start with /* ── Navigation ── */ or /* Navigation */
    # End before /* ── or </style>
    if '/* ── Navigation ── */' in content:
        content = re.sub(r'/\* ── Navigation ── \*/.*?(?=\s*/\* ──|\s*</style>)', nav_css, content, flags=re.DOTALL)
    elif '/* Navigation */' in content:
        content = re.sub(r'/\* Navigation \*/.*?(?=\s*/\* ──|\s*</style>|\s*/\* Main)', nav_css, content, flags=re.DOTALL)
    elif '/* ── Navigation (Matched to Splash) ── */' in content:
        content = re.sub(r'/\* ── Navigation \(Matched to Splash\) ── \*/.*?(?=\s*/\* ──|\s*</style>)', nav_css, content, flags=re.DOTALL)
    else:
        # Just inject it before </style> as a fallback?
        print(f"  Warning: could not find old css in {file}")

    # Replace HTML
    # Starts with <nav class="navbar"> and ends with </nav>
    old_html_match = re.search(r'<nav class="navbar">.*?</nav>', content, re.DOTALL)
    if old_html_match:
        custom_html = nav_html
        
        # Remove active from Home generally
        custom_html = custom_html.replace('href="/" class="active"', 'href="/"')
        
        # Add active where appropriate
        if file == 'store.blade.php':
            custom_html = custom_html.replace('href="/store"', 'href="/store" class="active"')
        elif file == 'subscription.blade.php':
            custom_html = custom_html.replace('href="/subscribe"', 'href="/subscribe" class="active"')
            
        content = content.replace(old_html_match.group(0), custom_html)
    else:
        print(f"  Warning: could not find old html in {file}")
        
    with open(path, 'w') as f:
        f.write(content)

print("Done")
