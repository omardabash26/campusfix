<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CampusFix')</title>

    <!-- Bootstrap 5 RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, sans-serif; }

        /* Sidebar */
        #sidebar {
            width: 240px;
            min-height: 100vh;
            background-color: #1e3a5f;
            position: fixed;
            top: 0;
            right: 0;
            z-index: 100;
            transition: transform 0.25s ease;
        }
        #sidebar .sidebar-brand {
            padding: 20px 16px;
            color: white;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        #sidebar .nav-link {
            color: rgba(255,255,255,0.75);
            padding: 10px 20px;
            border-radius: 6px;
            margin: 2px 8px;
            font-size: 0.92rem;
        }
        #sidebar .nav-link:hover,
        #sidebar .nav-link.active {
            background-color: rgba(255,255,255,0.15);
            color: white;
        }
        #sidebar .nav-link i { margin-left: 8px; }
        #sidebar .nav-section {
            font-size: 0.72rem;
            color: rgba(255,255,255,0.4);
            padding: 12px 20px 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Main content */
        #main {
            margin-right: 240px;
            min-height: 100vh;
        }
        #topbar {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .page-content { padding: 24px; }

        /* Cards */
        .stat-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 1px 6px rgba(0,0,0,0.07);
        }

        #menuToggle { display: none; }
        #sidebarBackdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            z-index: 99;
        }

        @media (max-width: 768px) {
            #sidebar { transform: translateX(100%); }
            #sidebar.open { transform: translateX(0); }
            #main { margin-right: 0; }
            #menuToggle { display: inline-flex; }
            #sidebarBackdrop.show { display: block; }
            .page-content { padding: 16px; }
            #topbar { padding: 10px 16px; }
        }
    </style>

    @yield('styles')
</head>
<body>

{{-- ═══ SIDEBAR ═══ --}}
<div id="sidebar">
    <div class="sidebar-brand">
        <div class="fw-bold fs-5"><i class="bi bi-tools me-2"></i>CampusFix</div>
        <small class="opacity-50" style="font-size:0.75rem;">מערכת ניהול תקלות</small>
    </div>

    <nav class="mt-2">
        @if(auth()->user()->isAdmin())
            <div class="nav-section">ראשי</div>
            <a href="{{ route('admin.dashboard') }}"
               class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> לוח בקרה
            </a>

            <div class="nav-section">ניהול</div>
            <a href="{{ route('admin.tickets.index') }}"
               class="nav-link {{ request()->routeIs('admin.tickets.*') ? 'active' : '' }}">
                <i class="bi bi-ticket-detailed"></i> כל הקריאות
            </a>
            <a href="{{ route('admin.users.index') }}"
               class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> משתמשים
            </a>
            <a href="{{ route('admin.locations.index') }}"
               class="nav-link {{ request()->routeIs('admin.locations.*') ? 'active' : '' }}">
                <i class="bi bi-geo-alt"></i> מיקומים
            </a>
            <a href="{{ route('admin.categories.index') }}"
               class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="bi bi-tags"></i> קטגוריות
            </a>

        @elseif(auth()->user()->isTechnician())
            <div class="nav-section">ראשי</div>
            <a href="{{ route('technician.dashboard') }}"
               class="nav-link {{ request()->routeIs('technician.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> הקריאות שלי
            </a>

        @else
            <div class="nav-section">ראשי</div>
            <a href="{{ route('tickets.create') }}"
               class="nav-link {{ request()->routeIs('tickets.*') ? 'active' : '' }}">
                <i class="bi bi-plus-circle"></i> פתיחת קריאה
            </a>
        @endif
    </nav>
</div>

<div id="sidebarBackdrop"></div>

{{-- ═══ MAIN CONTENT ═══ --}}
<div id="main">

    {{-- Topbar --}}
    <div id="topbar">
        <div class="d-flex align-items-center gap-2">
            <button id="menuToggle" class="btn btn-sm btn-outline-secondary" type="button">
                <i class="bi bi-list"></i>
            </button>
            <div class="fw-semibold text-muted">@yield('page-title', 'CampusFix')</div>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="text-muted small">
                <i class="bi bi-person-circle me-1"></i>
                <span class="d-none d-sm-inline">{{ auth()->user()->name }}</span>
                <span class="badge bg-secondary ms-1">
                    {{ match(auth()->user()->role) {
                        'admin' => 'מנהל',
                        'technician' => 'טכנאי',
                        'student' => 'סטודנט',
                        'lecturer' => 'מרצה',
                        default => auth()->user()->role
                    } }}
                </span>
            </span>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-box-arrow-left"></i> יציאה
                </button>
            </form>
        </div>
    </div>

    {{-- Page Content --}}
    <div class="page-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const sidebar = document.getElementById('sidebar');
    const backdrop = document.getElementById('sidebarBackdrop');
    const toggle = document.getElementById('menuToggle');

    function openSidebar() {
        sidebar.classList.add('open');
        backdrop.classList.add('show');
    }
    function closeSidebar() {
        sidebar.classList.remove('open');
        backdrop.classList.remove('show');
    }

    toggle.addEventListener('click', openSidebar);
    backdrop.addEventListener('click', closeSidebar);
    sidebar.querySelectorAll('.nav-link').forEach(link => link.addEventListener('click', closeSidebar));
</script>
@yield('scripts')
</body>
</html>