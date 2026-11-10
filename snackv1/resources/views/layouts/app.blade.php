<!DOCTYPE html>
<html lang="id" data-bs-theme="{{ session('theme', 'light') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SnackCheck') – Analisis Gizi Snack</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #0f172a;
            --sidebar-text: #94a3b8;
            --sidebar-active: #22d3ee;
            --accent: #22d3ee;
            --accent-glow: rgba(34,211,238,.15);
        }

        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ── Sidebar ── */
        #sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0; left: 0;
            z-index: 1040;
            transition: transform .3s ease;
            overflow-y: auto;
        }
        #sidebar .brand {
            padding: 1.5rem 1.25rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,.06);
        }
        #sidebar .brand-name {
            font-size: 1.2rem; font-weight: 700;
            color: #fff; letter-spacing: -.3px;
        }
        #sidebar .brand-sub {
            font-size: .7rem; color: var(--sidebar-text); text-transform: uppercase;
            letter-spacing: 1px;
        }
        #sidebar .nav-label {
            font-size: .65rem; text-transform: uppercase; letter-spacing: 1.2px;
            color: #475569; padding: .75rem 1.25rem .25rem; font-weight: 600;
        }
        #sidebar .nav-link {
            color: var(--sidebar-text);
            padding: .6rem 1.25rem;
            border-radius: .5rem;
            margin: .1rem .75rem;
            display: flex; align-items: center; gap: .75rem;
            font-size: .875rem; font-weight: 500;
            transition: all .2s;
        }
        #sidebar .nav-link:hover {
            color: #fff; background: rgba(255,255,255,.06);
        }
        #sidebar .nav-link.active {
            color: var(--sidebar-active);
            background: var(--accent-glow);
        }
        #sidebar .nav-link i { font-size: 1.05rem; width: 1.2rem; text-align: center; }

        /* ── Main ── */
        #main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin .3s ease;
        }

        /* ── Topbar ── */
        .topbar {
            height: 60px;
            background: var(--bs-body-bg);
            border-bottom: 1px solid var(--bs-border-color);
            display: flex; align-items: center;
            padding: 0 1.5rem;
            position: sticky; top: 0; z-index: 1030;
        }

        /* ── Cards ── */
        .stat-card {
            border: 1px solid var(--bs-border-color);
            border-radius: 1rem;
            padding: 1.25rem 1.5rem;
            transition: box-shadow .2s;
        }
        .stat-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,.08); }
        .stat-icon {
            width: 48px; height: 48px; border-radius: .75rem;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
        }

        /* ── Badge override ── */
        .badge.bg-sehat    { background: #d1fae5 !important; color: #065f46; }
        .badge.bg-perlu    { background: #fef3c7 !important; color: #92400e; }
        .badge.bg-diragukan{ background: #fee2e2 !important; color: #991b1b; }

        /* ── Mobile ── */
        @media (max-width: 991px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.show { transform: translateX(0); }
            #main-content { margin-left: 0; }
        }
    </style>

    @stack('styles')
</head>
<body>

{{-- ── Sidebar ── --}}
<nav id="sidebar">
    <div class="brand">
        <div class="d-flex align-items-center gap-2">
            <div class="stat-icon bg-cyan-900" style="background:var(--accent-glow); color:var(--accent); width:36px; height:36px; font-size:1.1rem;">
                <i class="bi bi-shield-check"></i>
            </div>
            <div>
                <div class="brand-name">SnackCheck</div>
                <div class="brand-sub">Decision Tree CART</div>
            </div>
        </div>
    </div>

    <div class="pt-2 pb-3">
        <div class="nav-label">Menu Utama</div>
        <a href="{{ route('dashboard') }}"
           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2"></i> Dashboard
        </a>

        <div class="nav-label">Data</div>
        <a href="{{ route('snacks.index') }}"
           class="nav-link {{ request()->routeIs('snacks.*') ? 'active' : '' }}">
            <i class="bi bi-bag-check"></i> Data Snack
        </a>
        <a href="{{ route('snacks.create') }}"
           class="nav-link">
            <i class="bi bi-plus-circle"></i> Tambah Snack
        </a>
        <a href="{{ route('histories.index') }}"
           class="nav-link {{ request()->routeIs('histories.*') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i> Riwayat Klasifikasi
        </a>

        <div class="nav-label">Export</div>
        <a href="{{ route('snacks.export.pdf') }}" class="nav-link" target="_blank">
            <i class="bi bi-file-pdf"></i> Export PDF
        </a>
        <a href="{{ route('snacks.export.excel') }}" class="nav-link">
            <i class="bi bi-file-excel"></i> Export Excel
        </a>
    </div>

    {{-- User Info --}}
    <div class="mt-auto px-3 pb-4" style="position:absolute; bottom:0; width:100%;">
        <div class="d-flex align-items-center gap-2 p-2 rounded-3" style="background:rgba(255,255,255,.05);">
            <div class="rounded-circle bg-cyan-500 d-flex align-items-center justify-content-center"
                 style="width:34px;height:34px;background:var(--accent-glow);color:var(--accent);font-weight:700;font-size:.8rem;flex-shrink:0;">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div style="flex:1;min-width:0;">
                <div class="text-white fw-600" style="font-size:.8rem;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                    {{ Auth::user()->name }}
                </div>
                <div style="font-size:.7rem;color:#64748b;">{{ Auth::user()->email }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-sm p-1 border-0" style="color:#64748b;" title="Logout">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>
</nav>

{{-- ── Main Content ── --}}
<div id="main-content">

    {{-- Topbar --}}
    <div class="topbar">
        <button class="btn btn-sm me-3 d-lg-none" onclick="document.getElementById('sidebar').classList.toggle('show')">
            <i class="bi bi-list fs-5"></i>
        </button>
        <span class="fw-600 text-body-secondary" style="font-size:.875rem;">@yield('page-title', 'Dashboard')</span>
        <div class="ms-auto d-flex align-items-center gap-2">
            {{-- Dark mode toggle --}}
            <button class="btn btn-sm rounded-circle" id="themeToggle" title="Toggle Dark Mode">
                <i class="bi bi-moon-stars" id="themeIcon"></i>
            </button>
        </div>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible m-3 mb-0 border-0 rounded-3" role="alert"
         style="background:#d1fae5;color:#065f46;">
        <i class="bi bi-check-circle me-2"></i>{!! session('success') !!}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible m-3 mb-0 border-0 rounded-3" role="alert">
        <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Page Content --}}
    <div class="p-4">
        @yield('content')
    </div>
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>

<script>
    // Dark mode toggle
    const html      = document.documentElement;
    const themeBtn  = document.getElementById('themeToggle');
    const themeIcon = document.getElementById('themeIcon');

    function applyTheme(t) {
        html.setAttribute('data-bs-theme', t);
        themeIcon.className = t === 'dark' ? 'bi bi-sun' : 'bi bi-moon-stars';
        localStorage.setItem('theme', t);
    }

    const saved = localStorage.getItem('theme') || 'light';
    applyTheme(saved);

    themeBtn.addEventListener('click', () => {
        applyTheme(html.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark');
    });
</script>

@stack('scripts')
</body>
</html>