<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIA — Admin Dashboard</title>
    <meta name="description" content="VIA admin control panel.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        /* ── Reset & Design Tokens ── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --cream:      #f9f8f6;
            --cream-dark: #f0ede8;
            --slate:      #21242c;
            --slate-mid:  #4a5568;
            --muted:      #6b7280;
            --terra:      #b2734d;
            --terra-dark: #8f5a3a;
            --terra-light:#faf0ea;
            --border:     #dee0e4;
            --white:      #ffffff;
            --success:    #2d7a4f;
            --success-bg: #edf7f2;
            --danger:     #b91c1c;
            --danger-bg:  #fef2f2;
            --sidebar-w:  240px;
        }

        body {
            background: var(--cream);
            font-family: 'Inter', system-ui, sans-serif;
            color: var(--slate);
            min-height: 100vh;
            display: flex;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: var(--white);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 50;
        }

        .sidebar-logo {
            padding: 1.6rem 1.8rem 1.2rem;
            border-bottom: 1px solid var(--border);
        }

        .sidebar-logo a {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 1.25rem;
            font-weight: 500;
            letter-spacing: 0.25em;
            color: var(--slate);
            text-decoration: none;
            display: block;
        }

        .sidebar-logo .admin-badge {
            display: inline-block;
            margin-top: 0.35rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.62rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--terra);
            background: var(--terra-light);
            border: 1px solid rgba(178,115,77,0.25);
            border-radius: 999px;
            padding: 0.18rem 0.65rem;
        }

        .sidebar-nav {
            flex: 1;
            padding: 1.5rem 0.75rem;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        /* Each sidebar nav item */
        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 400;
            color: var(--slate-mid);
            cursor: pointer;
            border: none;
            background: transparent;
            width: 100%;
            text-align: left;
            transition: background 0.2s, color 0.2s;
        }

        .nav-item:hover {
            background: var(--cream-dark);
            color: var(--slate);
        }

        .nav-item.active {
            background: var(--terra-light);
            color: var(--terra);
            font-weight: 500;
        }

        .nav-item svg {
            width: 16px; height: 16px;
            flex-shrink: 0;
            stroke: currentColor;
        }

        /* Nav section label */
        .nav-section-label {
            font-size: 0.65rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--muted);
            padding: 0.6rem 1rem 0.3rem;
            margin-top: 0.5rem;
        }

        /* Sidebar bottom */
        .sidebar-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--border);
            font-size: 0.78rem;
            color: var(--muted);
        }

        .sidebar-footer a {
            color: var(--terra);
            text-decoration: none;
            font-size: 0.78rem;
        }

        /* ── Main Content ── */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ── Top Header Bar ── */
        .topbar {
            background: rgba(249,248,246,0.9);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 40;
        }

        .topbar-title {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 1.3rem;
            font-weight: 400;
            color: var(--slate);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: 0.82rem;
            color: var(--muted);
        }

        .topbar-right a {
            color: var(--slate-mid);
            text-decoration: none;
            transition: color 0.2s;
        }

        .topbar-right a:hover { color: var(--terra); }

        /* ── Tab Panels ── */
        .tab-panel {
            display: none;
            padding: 2rem;
            animation: fadeIn 0.3s ease;
        }

        .tab-panel.active { display: block; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(6px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Page Section Header ── */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.8rem;
        }

        .section-title {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 1.8rem;
            font-weight: 400;
            color: var(--slate);
        }

        .section-subtitle {
            font-size: 0.82rem;
            color: var(--muted);
            margin-top: 0.2rem;
        }

        /* ── Flash Notice ── */
        .flash-msg {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.7rem 1rem;
            border-radius: 8px;
            font-size: 0.82rem;
            margin-bottom: 1.5rem;
            background: var(--success-bg);
            color: var(--success);
            border: 1px solid rgba(45, 122, 79, 0.2);
        }

        /* ── Primary Button ── */
        .btn-primary {
            background: var(--terra);
            color: var(--white);
            border: none;
            border-radius: 8px;
            padding: 0.65rem 1.3rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.84rem;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: background 0.2s, transform 0.15s;
        }

        .btn-primary:hover {
            background: var(--terra-dark);
            transform: translateY(-1px);
        }

        .btn-outline {
            background: transparent;
            color: var(--slate);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 0.62rem 1.2rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.84rem;
            font-weight: 400;
            cursor: pointer;
            transition: background 0.2s, border-color 0.2s;
        }

        .btn-outline:hover {
            background: var(--cream-dark);
            border-color: #c5c8ce;
        }

        /* ── Table ── */
        .table-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: var(--cream-dark);
        }

        th {
            text-align: left;
            padding: 0.75rem 1.25rem;
            font-size: 0.7rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--muted);
            font-weight: 500;
            border-bottom: 1px solid var(--border);
        }

        td {
            padding: 0.9rem 1.25rem;
            font-size: 0.875rem;
            color: var(--slate-mid);
            border-bottom: 1px solid rgba(222,224,228,0.5);
        }

        tr:last-child td { border-bottom: none; }

        tr:hover td { background: rgba(249,248,246,0.7); }

        .td-name {
            font-weight: 500;
            color: var(--slate);
        }

        /* Status badges */
        .badge {
            display: inline-block;
            font-size: 0.7rem;
            font-weight: 500;
            padding: 0.22rem 0.65rem;
            border-radius: 999px;
        }

        .badge-active {
            background: var(--success-bg);
            color: var(--success);
        }

        .badge-inactive {
            background: var(--cream-dark);
            color: var(--muted);
        }

        .badge-plan {
            background: var(--terra-light);
            color: var(--terra);
        }

        /* ── Product Grid ── */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 1.25rem;
        }

        .product-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.5rem;
            transition: box-shadow 0.25s, transform 0.25s;
        }

        .product-card:hover {
            box-shadow: 0 6px 24px rgba(0,0,0,0.07);
            transform: translateY(-2px);
        }

        .product-card-category {
            font-size: 0.65rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--terra);
            margin-bottom: 0.5rem;
        }

        .product-card-name {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 1.3rem;
            font-weight: 500;
            color: var(--slate);
            margin-bottom: 0.4rem;
        }

        .product-card-price {
            font-size: 1rem;
            color: var(--slate-mid);
            margin-bottom: 0.75rem;
        }

        .product-card-price strong {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 1.4rem;
            color: var(--terra);
        }

        .product-card-meta {
            font-size: 0.78rem;
            color: var(--muted);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* ── Subscription Cards ── */
        .sub-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .sub-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 2rem;
        }

        .sub-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.2rem;
        }

        .sub-card-name {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 1.4rem;
            font-weight: 500;
            color: var(--slate);
        }

        .sub-card-tagline {
            font-size: 0.8rem;
            color: var(--muted);
        }

        .sub-card-price-display {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 2rem;
            color: var(--terra);
            text-align: right;
        }

        .sub-card-price-display small {
            font-family: 'Inter', sans-serif;
            font-size: 0.75rem;
            color: var(--muted);
            display: block;
        }

        /* Edit form inside sub card */
        .sub-edit-form {
            display: none;
            margin-top: 1.25rem;
            padding-top: 1.25rem;
            border-top: 1px solid var(--border);
        }

        .sub-edit-form.open { display: block; }

        .sub-features-preview {
            font-size: 0.82rem;
            color: var(--slate-mid);
            line-height: 1.7;
            margin-bottom: 0.9rem;
        }

        .sub-features-preview li {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sub-features-preview li::before {
            content: '·';
            color: var(--terra);
            font-size: 1.1rem;
        }

        /* ── Analytics ── */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2.5rem;
        }

        .stat-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.4rem 1.5rem;
        }

        .stat-label {
            font-size: 0.7rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 2.2rem;
            font-weight: 400;
            color: var(--slate);
            line-height: 1;
        }

        .stat-sub {
            font-size: 0.75rem;
            color: var(--muted);
            margin-top: 0.35rem;
        }

        .stat-change {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.72rem;
            font-weight: 500;
            margin-top: 0.3rem;
        }

        .stat-change.up   { color: var(--success); }
        .stat-change.down { color: var(--danger); }

        /* ── Bar Chart ── */
        .chart-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.8rem;
            margin-bottom: 1.5rem;
        }

        .chart-title {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 1.2rem;
            font-weight: 500;
            color: var(--slate);
            margin-bottom: 1.5rem;
        }

        .bar-chart {
            display: flex;
            align-items: flex-end;
            gap: 0.6rem;
            height: 160px;
        }

        .bar-group {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.4rem;
        }

        .bar {
            width: 100%;
            background: var(--terra);
            border-radius: 4px 4px 0 0;
            opacity: 0.85;
            transition: opacity 0.2s;
            min-height: 4px;
        }

        .bar:hover { opacity: 1; }

        .bar-label {
            font-size: 0.68rem;
            color: var(--muted);
            text-align: center;
        }

        .bar-val {
            font-size: 0.7rem;
            color: var(--slate-mid);
            font-weight: 500;
        }

        /* Donut stand-in: plan distribution */
        .plan-dist {
            display: flex;
            flex-direction: column;
            gap: 0.9rem;
        }

        .plan-row {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .plan-row-label {
            min-width: 80px;
            font-size: 0.82rem;
            color: var(--slate-mid);
        }

        .plan-bar-track {
            flex: 1;
            height: 8px;
            background: var(--cream-dark);
            border-radius: 999px;
            overflow: hidden;
        }

        .plan-bar-fill {
            height: 100%;
            border-radius: 999px;
            background: var(--terra);
            transition: width 0.6s ease;
        }

        .plan-bar-fill.light { background: rgba(178,115,77,0.45); }
        .plan-bar-fill.lighter { background: rgba(178,115,77,0.2); }

        .plan-row-pct {
            width: 36px;
            text-align: right;
            font-size: 0.78rem;
            color: var(--muted);
        }

        /* Analytics two-col layout */
        .analytics-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 1.5rem;
        }

        @media (max-width: 900px) {
            .analytics-grid { grid-template-columns: 1fr; }
        }

        /* ── Modal ── */
        .modal-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(33,36,44,0.45);
            z-index: 200;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px);
        }

        .modal-backdrop.open { display: flex; }

        .modal {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 2rem 2.2rem;
            width: min(90vw, 480px);
            animation: cardIn 0.3s ease-out;
        }

        @keyframes cardIn {
            from { opacity: 0; transform: translateY(12px) scale(0.98); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .modal-title {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 1.5rem;
            font-weight: 400;
            color: var(--slate);
        }

        .modal-close {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--muted);
            font-size: 1.2rem;
            line-height: 1;
            padding: 0.2rem;
            transition: color 0.2s;
        }

        .modal-close:hover { color: var(--slate); }

        /* ── Form Fields (shared) ── */
        .field-wrap { margin-bottom: 1rem; }

        .field-label {
            display: block;
            font-size: 0.7rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 0.4rem;
        }

        .field-input,
        .field-select,
        .field-textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--cream);
            font-family: 'Inter', sans-serif;
            font-size: 0.875rem;
            color: var(--slate);
            outline: none;
            transition: border-color 0.2s;
        }

        .field-input:focus,
        .field-select:focus,
        .field-textarea:focus {
            border-color: var(--terra);
            background: var(--white);
        }

        .field-textarea {
            resize: vertical;
            min-height: 90px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main { margin-left: 0; }
            .form-row { grid-template-columns: 1fr; }
            .stats-row { grid-template-columns: 1fr 1fr; }
        }
    </style>
</head>
<body>

    {{-- ── Sidebar ── --}}
    <aside class="sidebar">
        <div class="sidebar-logo">
            <a href="/">V I A</a>
            <span class="admin-badge">Admin</span>
        </div>

        <nav class="sidebar-nav">
            <span class="nav-section-label">Manage</span>

            <button class="nav-item active" onclick="switchTab('users', this)" id="nav-users">
                <svg fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                Users
            </button>

            <button class="nav-item" onclick="switchTab('products', this)" id="nav-products">
                <svg fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/>
                </svg>
                Store Products
            </button>

            <button class="nav-item" onclick="switchTab('subscriptions', this)" id="nav-subscriptions">
                <svg fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/>
                </svg>
                Subscriptions
            </button>

            <button class="nav-item" onclick="switchTab('categories', this)" id="nav-categories">
                <svg fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M3 3h7v7H3zM14 3h7v7h-7zM3 14h7v7H3zM14 14h7v7h-7z"/>
                </svg>
                Categories
            </button>

            <span class="nav-section-label">Insights</span>

            <button class="nav-item" onclick="switchTab('analytics', this)" id="nav-analytics">
                <svg fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>
                </svg>
                Analytics
            </button>
        </nav>

        <div class="sidebar-footer">
            <span>Logged in as admin</span><br>
            <a href="/">← Back to site</a>
        </div>
    </aside>

    {{-- ── Main Area ── --}}
    <div class="main">

        {{-- Top Bar --}}
        <header class="topbar">
            <span class="topbar-title" id="topbar-title">Users</span>
            <div class="topbar-right">
                <span>{{ now()->format('M d, Y') }}</span>
                <a href="/">VIA Site ↗</a>
            </div>
        </header>

        {{-- Toast / Flash --}}
        @if(session('success'))
            <div style="padding: 1rem 2rem 0;">
                <div class="flash-msg">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        {{-- ════════════════════════════════════════ --}}
        {{--  TAB: USERS                              --}}
        {{-- ════════════════════════════════════════ --}}
        <div class="tab-panel active" id="tab-users">
            <div class="section-header">
                <div>
                    <div class="section-title">Members</div>
                    <div class="section-subtitle">{{ count($users) }} registered users</div>
                </div>
                <button class="btn-primary" onclick="openModal('addUserModal')">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Add User
                </button>
            </div>

            <div class="table-card">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Plan</th>
                            <th>Joined</th>
                            <th>Status</th>
                            <th style="text-align:right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="td-name">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="badge badge-plan">{{ $user->subscription->name ?? 'None' }}</span></td>
                            <td>{{ $user->created_at ? $user->created_at->format('M d, Y') : '—' }}</td>
                            <td>
                                <span class="badge {{ ($user->status ?? 'Active') === 'Active' ? 'badge-active' : 'badge-inactive' }}">
                                    {{ $user->status ?? 'Active' }}
                                </span>
                            </td>
                            <td style="text-align:right; display:flex; gap:0.5rem; justify-content:flex-end;">
                                <button type="button" class="btn-outline" style="padding:0.3rem 0.6rem;font-size:0.7rem;" onclick="openEditUserModal({{ json_encode($user) }})">Edit</button>
                                <button type="button" class="btn-outline" style="padding:0.3rem 0.6rem;font-size:0.7rem;color:var(--danger);border-color:rgba(185,28,28,0.2);" onclick="deleteItem('{{ route('admin.users.destroy', $user->id) }}', 'Delete user &ldquo;{{ addslashes($user->name) }}&rdquo;? This cannot be undone.')">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ════════════════════════════════════════ --}}
        {{--  TAB: PRODUCTS                          --}}
        {{-- ════════════════════════════════════════ --}}
        <div class="tab-panel" id="tab-products">
            <div class="section-header">
                <div>
                    <div class="section-title">Store Products</div>
                    <div class="section-subtitle">{{ count($products) }} items listed</div>
                </div>
                <button class="btn-primary" onclick="openModal('addProductModal')">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Add Product
                </button>
            </div>

            <div class="product-grid">
                @foreach($products as $product)
                <div class="product-card">
                    {{-- Product thumbnail --}}
                    @if($product->image_path)
                        <div style="aspect-ratio:4/3;overflow:hidden;border-bottom:1px solid var(--border);">
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" style="width:100%;height:100%;object-fit:cover;">
                        </div>
                    @else
                        <div style="aspect-ratio:4/3;background:linear-gradient(135deg,var(--cream-dark),#e8e3db);display:flex;align-items:center;justify-content:center;border-bottom:1px solid var(--border);">
                            <svg width="36" height="36" fill="none" viewBox="0 0 24 24" stroke="#aaa" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="3"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        </div>
                    @endif
                    <div style="padding:0.9rem;">
                        <div class="product-card-category">{{ $product->category }}</div>
                        <div class="product-card-name">{{ $product->name }}</div>
                        <div class="product-card-price"><strong>{{ $product->price }}/=</strong></div>
                        <div class="product-card-meta">
                            <div>
                                <span class="badge {{ $product->status === 'Active' ? 'badge-active' : 'badge-inactive' }}">{{ $product->status }}</span>
                                <span style="margin-left:0.5rem;font-size:0.75rem;color:var(--muted);">{{ $product->stock }} in stock</span>
                            </div>
                            <div style="display:flex; gap:0.25rem;margin-top:0.5rem;">
                                <button type="button" class="btn-outline" style="padding:0.25rem 0.5rem;font-size:0.7rem;border-color:transparent;" onclick="openEditProductModal({{ json_encode($product) }})">Edit</button>
                                <button type="button" class="btn-outline" style="padding:0.25rem 0.5rem;font-size:0.7rem;color:var(--danger);border-color:transparent;" onclick="deleteItem('{{ route('admin.products.destroy', $product->id) }}', 'Delete &ldquo;{{ addslashes($product->name) }}&rdquo;? This cannot be undone.')">Del</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- ════════════════════════════════════════ --}}
        {{--  TAB: SUBSCRIPTIONS                     --}}
        {{-- ════════════════════════════════════════ --}}
        <div class="tab-panel" id="tab-subscriptions">
            <div class="section-header">
                <div>
                    <div class="section-title">Subscription Tiers</div>
                    <div class="section-subtitle">Edit membership plans shown on the pricing page</div>
                </div>
            </div>

            <div class="sub-grid">
                @foreach($subscriptions as $sub)
                <div class="sub-card">
                    <div class="sub-card-header">
                        <div>
                            <div class="sub-card-name">{{ $sub->name }}</div>
                            <div class="sub-card-tagline">{{ $sub->tagline }}</div>
                        </div>
                        <div class="sub-card-price-display">
                            {{ $sub->price }}/=
                            <small>{{ $sub->period }}</small>
                        </div>
                    </div>

                    {{-- Features preview --}}
                    <ul class="sub-features-preview" style="list-style:none;">
                        @foreach(explode("\n", $sub->features) as $feature)
                            @if(trim($feature))
                                <li>{{ trim($feature) }}</li>
                            @endif
                        @endforeach
                    </ul>

                    {{-- Toggle edit button --}}
                    <button class="btn-outline" style="width:100%;margin-top:0.5rem;" onclick="toggleSubEdit({{ $sub->id }})">
                        Edit Tier
                    </button>

                    {{-- Inline Edit Form --}}
                    <div class="sub-edit-form" id="sub-edit-{{ $sub->id }}">
                        <form method="POST" action="{{ route('admin.subscriptions.update', $sub->id) }}">
                            @csrf
                            <div class="form-row">
                                <div class="field-wrap">
                                    <label class="field-label">Plan Name</label>
                                    <input class="field-input" type="text" name="name" value="{{ $sub->name }}" required>
                                </div>
                                <div class="field-wrap">
                                    <label class="field-label">Price (e.g. 1,200)</label>
                                    <input class="field-input" type="text" name="price" value="{{ $sub->price }}" required>
                                </div>
                            </div>
                            <div class="field-wrap">
                                <label class="field-label">Tagline</label>
                                <input class="field-input" type="text" name="tagline" value="{{ $sub->tagline }}" required>
                            </div>
                            <div class="field-wrap">
                                <label class="field-label">Features (one per line)</label>
                                <textarea class="field-textarea" name="features" required>{{ $sub->features }}</textarea>
                            </div>
                            <div style="display:flex;gap:0.7rem;margin-top:0.25rem;">
                                <button type="submit" class="btn-primary" style="flex:1;">Save Changes</button>
                                <button type="button" class="btn-outline" onclick="toggleSubEdit({{ $sub->id }})">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- ════════════════════════════════════════ --}}
        {{--  TAB: CATEGORIES                        --}}
        {{-- ════════════════════════════════════════ --}}
        <div class="tab-panel" id="tab-categories">
            <div class="section-header">
                <div>
                    <div class="section-title">Product Categories</div>
                    <div class="section-subtitle">{{ count($categories) }} categories — used to filter products on the store</div>
                </div>
                <button class="btn-primary" onclick="openModal('addCategoryModal')">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Add Category
                </button>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Category Name</th>
                            <th>Description</th>
                            <th>Products</th>
                            <th style="text-align:right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $cat)
                        <tr>
                            <td class="td-name">{{ $cat->name }}</td>
                            <td style="color:var(--muted);font-size:0.82rem;">{{ $cat->description ?? '—' }}</td>
                            <td>{{ $cat->products()->count() }}</td>
                            <td style="text-align:right;">
                                <div style="display:flex;gap:0.5rem;justify-content:flex-end;">
                                    <button type="button" class="btn-outline" style="padding:0.3rem 0.6rem;font-size:0.7rem;" onclick="openEditCategoryModal({{ json_encode($cat) }})">Edit</button>
                                    <button type="button" class="btn-outline" style="padding:0.3rem 0.6rem;font-size:0.7rem;color:var(--danger);border-color:rgba(185,28,28,0.2);" onclick="deleteItem('{{ route('admin.categories.destroy', $cat->id) }}', 'Delete category &ldquo;{{ addslashes($cat->name) }}&rdquo;? Products in this category will not be deleted.')">Delete</button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" style="text-align:center;color:var(--muted);padding:2rem;">No categories yet. Add one above.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{--  TAB: ANALYTICS                         --}}
        {{-- ════════════════════════════════════════ --}}
        <div class="tab-panel" id="tab-analytics">
            <div class="section-header">
                <div>
                    <div class="section-title">Analytics</div>
                    <div class="section-subtitle">Overview of platform performance</div>
                </div>
            </div>

            {{-- Stat chips --}}
            @php
                $totalUsers  = $users->count();
                $activeSubs  = $users->where('status', 'Active')->whereNotNull('subscription_id')->count();
                $mrr = $users->where('status','Active')->sum(fn($u) => (int)str_replace(',', '', $u->subscription->price ?? '0'));
            @endphp

            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-label">Total Members</div>
                    <div class="stat-value">{{ $totalUsers }}</div>
                    <div class="stat-change up">↑ 12% this month</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Active Subscriptions</div>
                    <div class="stat-value">{{ $activeSubs }}</div>
                    <div class="stat-sub">Out of {{ $totalUsers }} users</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Monthly Revenue (MRR)</div>
                    <div class="stat-value" style="font-size:1.6rem;">{{ number_format($mrr) }}/=</div>
                    <div class="stat-change up">↑ 8% vs last month</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Store Products</div>
                    <div class="stat-value">{{ count($products) }}</div>
                    <div class="stat-sub">All active</div>
                </div>
            </div>

            {{-- Charts row --}}
            <div class="analytics-grid">

                {{-- Monthly Users Bar Chart --}}
                <div class="chart-card">
                    <div class="chart-title">New Members — Last 6 Months</div>
                    @php
                        $chartData = [
                            ['month' => 'Oct', 'val' => 3],
                            ['month' => 'Nov', 'val' => 5],
                            ['month' => 'Dec', 'val' => 4],
                            ['month' => 'Jan', 'val' => 7],
                            ['month' => 'Feb', 'val' => 6],
                            ['month' => 'Mar', 'val' => $totalUsers],
                        ];
                        $maxVal = max(array_column($chartData, 'val'));
                    @endphp
                    <div class="bar-chart">
                        @foreach($chartData as $bar)
                        @php $pct = $maxVal > 0 ? round(($bar['val'] / $maxVal) * 100) : 0; @endphp
                        <div class="bar-group">
                            <span class="bar-val">{{ $bar['val'] }}</span>
                            <div class="bar" style="height: {{ $pct }}%;"></div>
                            <span class="bar-label">{{ $bar['month'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Plan Distribution --}}
                <div class="chart-card">
                    <div class="chart-title">Plan Distribution</div>
                    @php
                        $total = max($totalUsers, 1);
                        $classes = ['', 'light', 'lighter'];
                        $planStats = [];
                    @endphp
                    <div class="plan-dist">
                        @foreach($subscriptions as $idx => $sub)
                        @php 
                            $count = $users->where('subscription_id', $sub->id)->count();
                            $pct = round(($count / $total) * 100); 
                            $rev = $count * (int)str_replace(',', '', $sub->price);
                            $planStats[] = ['name' => $sub->name, 'rev' => $rev];
                        @endphp
                        <div class="plan-row">
                            <span class="plan-row-label">{{ $sub->name }}</span>
                            <div class="plan-bar-track">
                                <div class="plan-bar-fill {{ $classes[$idx % 3] }}" style="width: {{ $pct }}%;"></div>
                            </div>
                            <span class="plan-row-pct">{{ $pct }}%</span>
                        </div>
                        @endforeach
                    </div>

                    {{-- Revenue breakdown --}}
                    <div style="margin-top:1.5rem;border-top:1px solid var(--border);padding-top:1.2rem;">
                        <div class="chart-title" style="font-size:1rem;margin-bottom:0.8rem;">Revenue by Plan</div>
                        @foreach($planStats as $stat)
                        <div style="display:flex;justify-content:space-between;align-items:center;padding:0.4rem 0;border-bottom:1px solid rgba(222,224,228,0.4);font-size:0.82rem;">
                            <span style="color:var(--slate-mid);">{{ $stat['name'] }}</span>
                            <span style="font-weight:500;color:var(--slate);">{{ number_format($stat['rev']) }}/=</span>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>{{-- /analytics-grid --}}

            {{-- Recent activity table --}}
            <div class="chart-card">
                <div class="chart-title">Recent Members</div>
                <div class="table-card" style="border:none;">
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Plan</th>
                                <th>Joined</th>
                                <th>MRR Contribution</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users->take(5) as $u)
                            <tr>
                                <td class="td-name">{{ $u->name }}</td>
                                <td><span class="badge badge-plan">{{ $u->subscription->name ?? 'None' }}</span></td>
                                <td>{{ $u->created_at ? $u->created_at->format('M d, Y') : '—' }}</td>
                                <td style="color:var(--terra);font-weight:500;">{{ number_format((int)str_replace(',', '', $u->subscription->price ?? '0')) }}/=</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>{{-- /tab-analytics --}}

    </div>{{-- /main --}}


    {{-- ════════════════════════════════════════════════════════════════ --}}
    {{-- SHARED: Hidden delete form — used by all deleteItem() calls     --}}
    {{-- ════════════════════════════════════════════════════════════════ --}}
    <form id="deleteForm" method="POST" action="" style="display:none;">
        @csrf
        @method('DELETE')
    </form>

    {{-- ════════════════════════════════════════ --}}
    {{--  MODAL: Delete Confirmation             --}}
    {{-- ════════════════════════════════════════ --}}
    <div class="modal-backdrop" id="deleteConfirmModal">
        <div class="modal" style="max-width:420px;">
            <div class="modal-header" style="border-bottom:none;padding-bottom:0;">
                <span class="modal-title" style="color:var(--danger);">⚠ Confirm Delete</span>
                <button class="modal-close" onclick="closeDeleteModal()">✕</button>
            </div>
            <div style="padding:1rem 2rem 0.5rem;font-size:0.88rem;color:var(--muted);line-height:1.6;" id="deleteConfirmMsg">
                Are you sure? This action cannot be undone.
            </div>
            <div style="display:flex;gap:0.7rem;padding:1.25rem 2rem 1.75rem;">
                <button type="button" class="btn-outline" onclick="closeDeleteModal()" style="flex:1;">Cancel</button>
                <button type="button" onclick="submitDelete()" style="flex:1;background:var(--danger);color:#fff;border:none;border-radius:8px;padding:0.7rem 1rem;font-size:0.85rem;font-weight:500;cursor:pointer;">Yes, Delete</button>
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════════════ --}}
    {{--  MODAL: Add User                        --}}
    {{-- ════════════════════════════════════════ --}}
    <div class="modal-backdrop" id="addUserModal" onclick="closeModalOnBackdrop(event, 'addUserModal')">
        <div class="modal">
            <div class="modal-header">
                <span class="modal-title">Add New User</span>
                <button class="modal-close" onclick="closeModal('addUserModal')">✕</button>
            </div>

            {{-- Validation errors inside modal --}}
            @if($errors->any())
                <div class="flash-msg" style="background:var(--danger-bg);color:var(--danger);border-color:rgba(185,28,28,0.2);margin-bottom:1rem;">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="field-wrap">
                    <label class="field-label">Full Name</label>
                    <input class="field-input" type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Amara Osei" required>
                </div>
                <div class="field-wrap">
                    <label class="field-label">Email Address</label>
                    <input class="field-input" type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required>
                </div>
                <div class="form-row">
                    <div class="field-wrap">
                        <label class="field-label">Password</label>
                        <input class="field-input" type="password" name="password" placeholder="Min. 8 characters" required>
                    </div>
                    <div class="field-wrap">
                        <label class="field-label">Confirm Password</label>
                        <input class="field-input" type="password" name="password_confirmation" placeholder="Repeat password" required>
                    </div>
                </div>
                <div class="field-wrap">
                    <label class="field-label">Membership Plan</label>
                    <select class="field-select" name="subscription_id" required>
                        <option value="">Select a plan</option>
                        @foreach($subscriptions as $sub)
                            <option value="{{ $sub->id }}" {{ old('subscription_id') == $sub->id ? 'selected' : '' }}>{{ $sub->name }} — {{ $sub->price }}/=</option>
                        @endforeach
                    </select>
                </div>
                <div style="display:flex;gap:0.7rem;margin-top:1.25rem;">
                    <button type="submit" class="btn-primary" style="flex:1;">Add User</button>
                    <button type="button" class="btn-outline" onclick="closeModal('addUserModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ════════════════════════════════════════ --}}
    {{--  MODAL: Add Product                     --}}
    {{-- ════════════════════════════════════════ --}}
    <div class="modal-backdrop" id="addProductModal" onclick="closeModalOnBackdrop(event, 'addProductModal')">
        <div class="modal">
            <div class="modal-header">
                <span class="modal-title">Add BFSUMA Product</span>
                <button class="modal-close" onclick="closeModal('addProductModal')">✕</button>
            </div>
            {{-- enctype required for file upload --}}
            <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="field-wrap">
                    <label class="field-label">Product Name</label>
                    <input class="field-input" type="text" name="name" placeholder="e.g. BFSUMA Moringa Capsules" required>
                </div>
                <div class="field-wrap">
                    <label class="field-label">Product Image</label>
                    <input class="field-input" type="file" name="image" accept="image/*" style="padding:0.5rem;">
                    <small style="color:var(--muted);font-size:0.75rem;">JPG, PNG or WebP · Max 4MB</small>
                </div>
                <div class="field-wrap">
                    <label class="field-label">Description</label>
                    <textarea class="field-textarea" name="description" placeholder="What does this product do? Benefits, ingredients, usage…"></textarea>
                </div>
                <div class="form-row">
                    <div class="field-wrap">
                        <label class="field-label">Price (KES, e.g. 1,500)</label>
                        <input class="field-input" type="text" name="price" placeholder="1,500" required>
                    </div>
                    <div class="field-wrap">
                        <label class="field-label">Stock Qty</label>
                        <input class="field-input" type="number" name="stock" placeholder="50" min="0" required>
                    </div>
                </div>
                <div class="field-wrap" style="margin-top:1rem;">
                    <label class="field-label">Category</label>
                    <select class="field-select" name="category" required>
                        <option value="">Select a category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                        @endforeach
                        @if($categories->isEmpty())
                            <option value="" disabled>— Add a category first —</option>
                        @endif
                    </select>
                </div>
                <div style="display:flex;gap:0.7rem;margin-top:1.25rem;">
                    <button type="submit" class="btn-primary" style="flex:1;">Add Product</button>
                    <button type="button" class="btn-outline" onclick="closeModal('addProductModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ════════════════════════════════════════ --}}
    {{--  MODAL: Edit User                       --}}
    {{-- ════════════════════════════════════════ --}}
    <div class="modal-backdrop" id="editUserModal" onclick="closeModalOnBackdrop(event, 'editUserModal')">
        <div class="modal">
            <div class="modal-header">
                <span class="modal-title">Edit User</span>
                <button class="modal-close" onclick="closeModal('editUserModal')">✕</button>
            </div>
            <form id="editUserForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="field-wrap">
                    <label class="field-label">Full Name</label>
                    <input class="field-input" type="text" name="name" id="editUserName" required>
                </div>
                <div class="field-wrap">
                    <label class="field-label">Email Address</label>
                    <input class="field-input" type="email" name="email" id="editUserEmail" required>
                </div>
                <div class="form-row">
                    <div class="field-wrap">
                        <label class="field-label">New Password (Optional)</label>
                        <input class="field-input" type="password" name="password" placeholder="Leave blank to keep current">
                    </div>
                    <div class="field-wrap">
                        <label class="field-label">Confirm New Password</label>
                        <input class="field-input" type="password" name="password_confirmation" placeholder="Repeat password">
                    </div>
                </div>
                <div class="form-row">
                    <div class="field-wrap">
                        <label class="field-label">Membership Plan</label>
                        <select class="field-select" name="subscription_id" id="editUserPlan" required>
                            @foreach($subscriptions as $sub)
                                <option value="{{ $sub->id }}">{{ $sub->name }} — {{ $sub->price }}/=</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field-wrap">
                        <label class="field-label">Status</label>
                        <select class="field-select" name="status" id="editUserStatus" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div style="display:flex;gap:0.7rem;margin-top:1.25rem;">
                    <button type="submit" class="btn-primary" style="flex:1;">Save Changes</button>
                    <button type="button" class="btn-outline" onclick="closeModal('editUserModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ════════════════════════════════════════ --}}
    {{--  MODAL: Edit Product                    --}}
    {{-- ════════════════════════════════════════ --}}
    <div class="modal-backdrop" id="editProductModal" onclick="closeModalOnBackdrop(event, 'editProductModal')">
        <div class="modal">
            <div class="modal-header">
                <span class="modal-title">Edit BFSUMA Product</span>
                <button class="modal-close" onclick="closeModal('editProductModal')">✕</button>
            </div>
            {{-- POST with _method override and enctype for file upload --}}
            <form id="editProductForm" method="POST" action="" enctype="multipart/form-data">
                @csrf
                <div class="field-wrap">
                    <label class="field-label">Product Name</label>
                    <input class="field-input" type="text" name="name" id="editProductName" required>
                </div>
                <div class="field-wrap">
                    <label class="field-label">Replace Image (leave blank to keep current)</label>
                    <input class="field-input" type="file" name="image" accept="image/*" style="padding:0.5rem;">
                    <small style="color:var(--muted);font-size:0.75rem;">Current image will be used if nothing is uploaded</small>
                </div>
                <div class="field-wrap">
                    <label class="field-label">Description</label>
                    <textarea class="field-textarea" name="description" id="editProductDescription" placeholder="Product description…"></textarea>
                </div>
                <div class="form-row">
                    <div class="field-wrap">
                        <label class="field-label">Price (KES)</label>
                        <input class="field-input" type="text" name="price" id="editProductPrice" required>
                    </div>
                    <div class="field-wrap">
                        <label class="field-label">Stock Qty</label>
                        <input class="field-input" type="number" name="stock" id="editProductStock" min="0" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="field-wrap">
                        <label class="field-label">Category</label>
                        <select class="field-select" name="category" id="editProductCategory" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field-wrap">
                        <label class="field-label">Status</label>
                        <select class="field-select" name="status" id="editProductStatus" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div style="display:flex;gap:0.7rem;margin-top:1.25rem;">
                    <button type="submit" class="btn-primary" style="flex:1;">Save Changes</button>
                    <button type="button" class="btn-outline" onclick="closeModal('editProductModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ════════════════════════════════════════ --}}
    {{--  MODAL: Add Category                    --}}
    {{-- ════════════════════════════════════════ --}}
    <div class="modal-backdrop" id="addCategoryModal" onclick="closeModalOnBackdrop(event, 'addCategoryModal')">
        <div class="modal">
            <div class="modal-header">
                <span class="modal-title">Add Category</span>
                <button class="modal-close" onclick="closeModal('addCategoryModal')">✕</button>
            </div>
            <form method="POST" action="{{ route('admin.categories.store') }}">
                @csrf
                <div class="field-wrap">
                    <label class="field-label">Category Name</label>
                    <input class="field-input" type="text" name="name" placeholder="e.g. Herbal Supplements" required>
                </div>
                <div class="field-wrap">
                    <label class="field-label">Description (Optional)</label>
                    <input class="field-input" type="text" name="description" placeholder="Short description for this category">
                </div>
                <div style="display:flex;gap:0.7rem;margin-top:1.25rem;">
                    <button type="submit" class="btn-primary" style="flex:1;">Add Category</button>
                    <button type="button" class="btn-outline" onclick="closeModal('addCategoryModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ════════════════════════════════════════ --}}
    {{--  MODAL: Edit Category                   --}}
    {{-- ════════════════════════════════════════ --}}
    <div class="modal-backdrop" id="editCategoryModal" onclick="closeModalOnBackdrop(event, 'editCategoryModal')">
        <div class="modal">
            <div class="modal-header">
                <span class="modal-title">Edit Category</span>
                <button class="modal-close" onclick="closeModal('editCategoryModal')">✕</button>
            </div>
            <form id="editCategoryForm" method="POST" action="">
                @csrf
                <div class="field-wrap">
                    <label class="field-label">Category Name</label>
                    <input class="field-input" type="text" name="name" id="editCategoryName" required>
                </div>
                <div class="field-wrap">
                    <label class="field-label">Description (Optional)</label>
                    <input class="field-input" type="text" name="description" id="editCategoryDescription">
                </div>
                <div style="display:flex;gap:0.7rem;margin-top:1.25rem;">
                    <button type="submit" class="btn-primary" style="flex:1;">Save Changes</button>
                    <button type="button" class="btn-outline" onclick="closeModal('editCategoryModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // ── Tab switching ──────────────────────────────────────────────
        const tabTitles = {
            users: 'Users',
            products: 'Store Products',
            subscriptions: 'Subscriptions',
            categories: 'Categories',
            analytics: 'Analytics'
        };

        function switchTab(name, btn) {
            // Deactivate all panels and nav items
            document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
            document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));

            // Activate selected
            document.getElementById('tab-' + name).classList.add('active');
            btn.classList.add('active');
            document.getElementById('topbar-title').textContent = tabTitles[name] || name;
        }

        // ── Modal helpers ──────────────────────────────────────────────
        function openModal(id) {
            document.getElementById(id).classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('open');
            document.body.style.overflow = '';
        }

        function closeModalOnBackdrop(e, id) {
            if (e.target === document.getElementById(id)) closeModal(id);
        }

        // ── Subscription inline edit toggle ───────────────────────────
        function toggleSubEdit(id) {
            const form = document.getElementById('sub-edit-' + id);
            form.classList.toggle('open');
        }

        // ── Edit Modals Population ─────────────────────────────────────
        function openEditUserModal(user) {
            document.getElementById('editUserForm').action = '/admin/users/' + user.id;
            document.getElementById('editUserName').value = user.name || '';
            document.getElementById('editUserEmail').value = user.email || '';
            document.getElementById('editUserPlan').value = user.subscription_id || '';
            document.getElementById('editUserStatus').value = user.status || 'Active';
            openModal('editUserModal');
        }

        function openEditProductModal(product) {
            document.getElementById('editProductForm').action = '/admin/products/' + product.id;
            document.getElementById('editProductName').value = product.name || '';
            document.getElementById('editProductPrice').value = product.price || '';
            document.getElementById('editProductStock').value = product.stock || 0;
            document.getElementById('editProductCategory').value = product.category || '';
            document.getElementById('editProductStatus').value = product.status || 'Active';
            document.getElementById('editProductDescription').value = product.description || '';
            openModal('editProductModal');
        }

        function openEditCategoryModal(cat) {
            document.getElementById('editCategoryForm').action = '/admin/categories/' + cat.id;
            document.getElementById('editCategoryName').value = cat.name || '';
            document.getElementById('editCategoryDescription').value = cat.description || '';
            openModal('editCategoryModal');
        }

        // ── Delete Confirmation (shared) ───────────────────────────────
        // Call this from any Delete button. It opens the confirmation modal
        // and, if the user confirms, submits the hidden #deleteForm via DELETE.
        function deleteItem(url, message) {
            // Set the hidden form's action to the delete endpoint
            document.getElementById('deleteForm').action = url;
            // Show the contextual message in the modal
            document.getElementById('deleteConfirmMsg').innerHTML = message;
            // Open the confirmation modal
            document.getElementById('deleteConfirmModal').classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            document.getElementById('deleteConfirmModal').classList.remove('open');
            document.body.style.overflow = '';
        }

        function submitDelete() {
            // Submit the shared hidden DELETE form
            document.getElementById('deleteForm').submit();
        }

        // ── Auto-open correct tab if redirected back with ?tab= ────────
        (function () {
            const params = new URLSearchParams(window.location.search);
            const tab = params.get('tab');
            if (tab) {
                const navBtn = document.getElementById('nav-' + tab);
                if (navBtn) switchTab(tab, navBtn);
            }
        })();

        // ── Animate bar chart heights on load ──────────────────────────
        // Heights are already set inline via style; CSS transitions handle it.
    </script>

</body>
</html>
