<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — {{ config('app.name') }} Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --primary: #0ea5e9;
            --primary-dark: #0284c7;
            --primary-glow: rgba(14, 165, 233, .3);
            --sidebar-w: 270px;
            --topbar-h: 64px;
            --body-bg: #080c14;
            --glass-bg: rgba(255, 255, 255, .04);
            --glass-border: rgba(255, 255, 255, .08);
            --glass-hover: rgba(255, 255, 255, .08);
            --surface: rgba(255, 255, 255, .05);
            --surface-2: rgba(255, 255, 255, .08);
            --border: rgba(255, 255, 255, .08);
            --text: #f0f0f0;
            --muted: #888;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--body-bg);
            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(14, 165, 233, .1) 0%, transparent 70%);
            top: -150px;
            right: -150px;
            pointer-events: none;
            z-index: 0;
        }

        body::after {
            content: '';
            position: fixed;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(139, 92, 246, .07) 0%, transparent 70%);
            bottom: -100px;
            left: -100px;
            pointer-events: none;
            z-index: 0;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .6);
            backdrop-filter: blur(4px);
            z-index: 200;
        }

        .sidebar-overlay.show {
            display: block;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-w);
            height: 100vh;
            background: rgba(8, 12, 20, .88);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-right: 1px solid var(--glass-border);
            display: flex;
            flex-direction: column;
            z-index: 300;
            transition: transform .3s cubic-bezier(.4, 0, .2, 1);
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                box-shadow: 4px 0 32px rgba(0, 0, 0, .5);
            }

            .sidebar.open {
                transform: translateX(0);
            }
        }

        .sidebar-brand {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--glass-border);
            display: flex;
            align-items: center;
            gap: .75rem;
        }

        .brand-icon{
    width: 70px;
    height: 70px;
    display:flex;
    align-items:center;
    justify-content:center;
    overflow:hidden;
    background:transparent;
    box-shadow:none;
    flex-shrink:0;
}

.brand-logo{
    width:100%;
    height:100%;
    object-fit:cover;
    transform: scale(1.4);
    display:block;
}
       .brand-text h2 {
            font-size: 1.1rem;
            font-weight: 800;
            margin: 0;
            letter-spacing: -.3px;
            color: var(--text);
        }

        .brand-text h2 span {
            color: var(--primary);
            font-size:1.15rem;
    font-weight:800;
        }

        .brand-text small {
            display: block;
            font-size: .68rem;
            color: var(--muted);
            font-weight: 500;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .btn-close-sidebar {
            display: none;
            margin-left: auto;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            color: var(--muted);
            width: 32px;
            height: 32px;
            border-radius: 8px;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: .9rem;
            transition: all .2s;
        }

        @media (max-width: 768px) {
            .btn-close-sidebar {
                display: flex;
            }
        }

        .btn-close-sidebar:hover {
            color: var(--text);
        }

        .sidebar-nav {
            flex: 1;
            padding: 1rem 0;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, .1) transparent;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, .1);
            border-radius: 4px;
        }

        .nav-section-label {
            padding: .6rem 1.5rem .3rem;
            font-size: .62rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .25);
        }

        .nav-item a {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .6rem 1.25rem;
            margin: 1px .75rem;
            color: var(--muted);
            text-decoration: none;
            font-size: .855rem;
            font-weight: 500;
            border-radius: 10px;
            transition: all .2s;
            position: relative;
        }

        .nav-item a i {
            font-size: .95rem;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }

        .nav-item a:hover {
            color: var(--text);
            background: var(--glass-hover);
        }

        .nav-item a.active {
            color: var(--primary);
            background: rgba(14, 165, 233, .1);
            box-shadow: inset 0 0 0 1px rgba(14, 165, 233, .2);
        }

        .sidebar-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid var(--glass-border);
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: .65rem;
            padding: .65rem .75rem;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
        }

        .user-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), #38bdf8);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: .82rem;
            flex-shrink: 0;
            box-shadow: 0 2px 8px var(--primary-glow);
        }

        .user-info {
            flex: 1;
            min-width: 0;
        }

        .user-name {
            font-size: .82rem;
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role {
            font-size: .68rem;
            color: var(--muted);
            text-transform: capitalize;
        }

        .btn-logout {
            background: none;
            border: 1px solid var(--glass-border);
            color: var(--muted);
            border-radius: 8px;
            padding: .35rem .55rem;
            font-size: .85rem;
            cursor: pointer;
            transition: all .2s;
            flex-shrink: 0;
        }

        .btn-logout:hover {
            border-color: #ef4444;
            color: #ef4444;
        }

        .main {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            z-index: 1;
        }

        @media (max-width: 768px) {
            .main {
                margin-left: 0;
            }
        }

        .topbar {
            height: var(--topbar-h);
            background: rgba(8, 12, 20, .75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--glass-border);
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: .85rem;
        }

        .btn-hamburger {
            display: none;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            color: var(--text);
            width: 36px;
            height: 36px;
            border-radius: 10px;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1rem;
            transition: all .2s;
            flex-shrink: 0;
        }

        @media (max-width: 768px) {
            .btn-hamburger {
                display: flex;
            }
        }

        .btn-hamburger:hover {
            background: var(--glass-hover);
        }

        .topbar-title h3 {
            font-size: .95rem;
            font-weight: 700;
            margin: 0;
        }

        .topbar-title p {
            font-size: .72rem;
            color: var(--muted);
            margin: 0;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: .6rem;
        }

        .topbar-btn {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            color: var(--muted);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all .2s;
            text-decoration: none;
            font-size: .9rem;
        }

        .topbar-btn:hover {
            color: var(--text);
            border-color: rgba(255, 255, 255, .15);
            background: var(--glass-hover);
        }

        .content {
            flex: 1;
            padding: 1.5rem;
        }

        @media (max-width: 576px) {
            .content {
                padding: 1rem;
            }

            .topbar {
                padding: 0 1rem;
            }
        }

        /* Global Components — sama dengan owner */
        .btn-add {
            background: linear-gradient(135deg, var(--primary), #38bdf8);
            border: none;
            color: #fff;
            font-weight: 700;
            font-size: .84rem;
            border-radius: 10px;
            padding: .55rem 1.1rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            transition: opacity .2s, transform .15s;
            cursor: pointer;
            box-shadow: 0 4px 16px var(--primary-glow);
            white-space: nowrap;
        }

        .btn-add:hover {
            opacity: .88;
            color: #fff;
            transform: translateY(-1px);
        }

        .btn-back {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            color: var(--muted);
            font-weight: 600;
            font-size: .84rem;
            border-radius: 10px;
            padding: .55rem 1.1rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all .2s;
            white-space: nowrap;
        }

        .btn-back:hover {
            color: var(--text);
            border-color: rgba(255, 255, 255, .18);
        }

        .panel {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            overflow: hidden;
            backdrop-filter: blur(12px);
        }

        .panel-header {
            padding: 1rem 1.4rem;
            border-bottom: 1px solid var(--glass-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: .5rem;
        }

        .panel-header h5 {
            font-size: .9rem;
            font-weight: 700;
            margin: 0;
        }

        .panel-body {
            padding: 1.25rem;
        }

        .table-custom {
            width: 100%;
            border-collapse: collapse;
            font-size: .84rem;
            color: var(--text);
        }

        .table-custom thead th {
            background: rgba(255, 255, 255, .04);
            color: var(--muted);
            font-size: .7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            padding: .75rem 1rem;
            border-bottom: 1px solid var(--glass-border);
            white-space: nowrap;
        }

        .table-custom tbody td {
            padding: .8rem 1rem;
            border-bottom: 1px solid var(--glass-border);
            vertical-align: middle;
        }

        .table-custom tbody tr:last-child td {
            border-bottom: none;
        }

        .table-custom tbody tr:hover td {
            background: rgba(255, 255, 255, .02);
        }

        .badge-status {
            padding: .28rem .65rem;
            border-radius: 20px;
            font-size: .7rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .badge-selesai {
            background: rgba(34, 197, 94, .15);
            color: #22c55e;
        }

        .badge-proses {
            background: rgba(14, 165, 233, .15);
            color: #0ea5e9;
        }

        .badge-antrian {
            background: rgba(234, 179, 8, .15);
            color: #eab308;
        }

        .badge-batal {
            background: rgba(239, 68, 68, .15);
            color: #ef4444;
        }

        .badge-lunas {
            background: rgba(34, 197, 94, .15);
            color: #22c55e;
        }

        .btn-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1px solid var(--glass-border);
            background: var(--glass-bg);
            color: var(--muted);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all .2s;
            text-decoration: none;
            font-size: .84rem;
        }

        .btn-edit:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: rgba(14, 165, 233, .1);
        }

        .btn-del:hover {
            border-color: #ef4444;
            color: #ef4444;
            background: rgba(239, 68, 68, .1);
        }

        .btn-view:hover {
            border-color: #22c55e;
            color: #22c55e;
            background: rgba(34, 197, 94, .1);
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label-custom {
            display: block;
            font-size: .72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--muted);
            margin-bottom: .4rem;
        }

        .input-custom {
            width: 100%;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            color: var(--text);
            border-radius: 10px;
            padding: .65rem .9rem;
            font-size: .875rem;
            font-family: inherit;
            transition: border-color .2s, box-shadow .2s;
        }

        .input-custom:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(14, 165, 233, .15);
        }

        .input-custom::placeholder {
            color: rgba(255, 255, 255, .2);
        }

        select.input-custom option {
            background: #0d1117;
            color: var(--text);
        }

        .alert-success-custom {
            background: rgba(34, 197, 94, .1);
            border: 1px solid rgba(34, 197, 94, .25);
            color: #22c55e;
            border-radius: 12px;
            padding: .8rem 1rem;
            font-size: .84rem;
        }

        .alert-danger-custom {
            background: rgba(239, 68, 68, .1);
            border: 1px solid rgba(239, 68, 68, .25);
            color: #ef4444;
            border-radius: 12px;
            padding: .8rem 1rem;
            font-size: .84rem;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: .65rem 0;
            border-bottom: 1px solid var(--glass-border);
            font-size: .84rem;
            color: var(--muted);
            gap: 1rem;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-row strong {
            color: var(--text);
            text-align: right;
        }

        .stat-card {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            padding: 1.4rem;
            transition: transform .2s, border-color .2s;
            backdrop-filter: blur(12px);
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            border-color: rgba(255, 255, 255, .14);
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }

        .stat-icon.blue {
            background: rgba(14, 165, 233, .15);
            color: #0ea5e9;
        }

        .stat-icon.green {
            background: rgba(34, 197, 94, .15);
            color: #22c55e;
        }

        .stat-icon.yellow {
            background: rgba(234, 179, 8, .15);
            color: #eab308;
        }

        .stat-icon.red {
            background: rgba(239, 68, 68, .15);
            color: #ef4444;
        }

        .stat-icon.purple {
            background: rgba(168, 85, 247, .15);
            color: #a855f7;
        }

        .stat-value {
            font-size: 1.65rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: .3rem;
            word-break: break-all;
        }

        .stat-label {
            font-size: .78rem;
            color: var(--muted);
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        @media (max-width: 576px) {
            .stat-value {
                font-size: 1.3rem;
            }

            .panel-header {
                padding: .85rem 1rem;
            }

            .panel-body {
                padding: 1rem;
            }

            .table-custom thead th,
            .table-custom tbody td {
                padding: .65rem .75rem;
                font-size: .78rem;
            }
        }
    </style>
    @stack('styles')
</head>

<body>

    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <aside class="sidebar" id="sidebar">
       <div class="sidebar-brand">
    <div class="brand-icon">
        <img src="{{ asset('LogoATR.png') }}" alt="Logo Bengkel ATR" class="brand-logo">
    </div>

    <div class="brand-text">
        <h2>Bengkel <span>ATR</span></h2>
        <small>Admin Panel</small>
    </div>

    <button class="btn-close-sidebar" onclick="closeSidebar()">
        <i class="bi bi-x-lg"></i>
    </button>
</div>

        <nav class="sidebar-nav">
            <p class="nav-section-label">Utama</p>
            <div class="nav-item">
                <a href="{{ route('admin.dashboard') }}"
                    class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.mekanik.index') }}"
                    class="{{ request()->routeIs('admin.mekanik.*') ? 'active' : '' }}">
                    <i class="bi bi-person-badge"></i> Data Mekanik
                </a>
            </div>

            <p class="nav-section-label mt-2">Operasional</p>
            <div class="nav-item">
                <a href="{{ route('admin.servis.index') }}"
                    class="{{ request()->routeIs('admin.servis.*') ? 'active' : '' }}">
                    <i class="bi bi-wrench-adjustable"></i> Servis
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.spare-part.index') }}"
                    class="{{ request()->routeIs('admin.spare-part.*') ? 'active' : '' }}">
                    <i class="bi bi-box-seam"></i> Spare Part
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.transaksi.index') }}"
                    class="{{ request()->routeIs('admin.transaksi.*') ? 'active' : '' }}">
                    <i class="bi bi-receipt"></i> Transaksi
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.pelanggan.index') }}"
                    class="{{ request()->routeIs('admin.pelanggan.*') ? 'active' : '' }}">
                    <i class="bi bi-person-lines-fill"></i> Pelanggan
                </a>
            </div>
        </nav>

        <div class="sidebar-footer">
            <div class="user-card">
                <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <div class="user-info">
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-role">{{ Auth::user()->role }}</div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-logout" title="Logout">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <div class="main">
        <header class="topbar">
            <div class="topbar-left">
                <button class="btn-hamburger" onclick="openSidebar()">
                    <i class="bi bi-list"></i>
                </button>
                <div class="topbar-title">
                    <h3>@yield('page-title', 'Dashboard')</h3>
                    <p class="d-none d-sm-block">@yield('page-subtitle', date('l, d F Y'))</p>
                </div>
            </div>
            <div class="topbar-right">
                @php
                    $stokMenipisNotif = \App\Models\SparePart::whereColumn('stok', '<=', 'stok_minimum')->get();
                @endphp
                <div style="position:relative">
                    <button onclick="toggleNotif(event)" class="topbar-btn" style="position:relative">
                        <i class="bi bi-bell"></i>
                        @if($stokMenipisNotif->count() > 0)
                            <span
                                style="position:absolute;top:-3px;right:-3px;background:#ef4444;color:#fff;font-size:.55rem;font-weight:700;width:15px;height:15px;border-radius:50%;display:flex;align-items:center;justify-content:center;border:2px solid var(--body-bg)">
                                {{ $stokMenipisNotif->count() }}
                            </span>
                        @endif
                    </button>
                    <div id="notif-dropdown"
                        style="display:none;position:absolute;top:44px;right:0;width:290px;background:rgba(8,12,20,.95);backdrop-filter:blur(24px);border:1px solid var(--glass-border);border-radius:14px;box-shadow:0 16px 48px rgba(0,0,0,.5);z-index:999;overflow:hidden">
                        <div
                            style="padding:.85rem 1rem;border-bottom:1px solid var(--glass-border);display:flex;align-items:center;justify-content:space-between">
                            <span style="font-size:.85rem;font-weight:700">Notifikasi</span>
                            @if($stokMenipisNotif->count() > 0)
                                <span
                                    style="background:rgba(239,68,68,.15);color:#ef4444;font-size:.68rem;font-weight:700;padding:.2rem .6rem;border-radius:20px">{{ $stokMenipisNotif->count() }}
                                    stok menipis</span>
                            @endif
                        </div>
                        <div style="max-height:260px;overflow-y:auto">
                            @forelse($stokMenipisNotif as $sp)
                                <div
                                    style="padding:.7rem 1rem;border-bottom:1px solid var(--glass-border);display:flex;align-items:center;gap:.7rem">
                                    <div
                                        style="width:30px;height:30px;border-radius:8px;background:rgba(239,68,68,.12);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                                        ⚠️</div>
                                    <div>
                                        <div style="font-size:.78rem;font-weight:600">{{ $sp->nama }}</div>
                                        <div style="font-size:.68rem;color:var(--muted)">Stok: <strong
                                                style="color:#ef4444">{{ $sp->stok }}</strong> / min {{ $sp->stok_minimum }}
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div style="padding:1.5rem;text-align:center;color:var(--muted);font-size:.8rem">
                                    <i class="bi bi-check-circle"
                                        style="color:#22c55e;display:block;font-size:1.3rem;margin-bottom:.4rem"></i>
                                    Semua stok aman
                                </div>
                            @endforelse
                        </div>
                        @if($stokMenipisNotif->count() > 0)
                            <div style="padding:.7rem 1rem;border-top:1px solid var(--glass-border);text-align:center">
                                <a href="{{ route('admin.spare-part.index') }}?stok=menipis"
                                    style="font-size:.78rem;color:var(--primary);text-decoration:none;font-weight:600">Lihat
                                    semua →</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <main class="content">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openSidebar() {
            document.getElementById('sidebar').classList.add('open');
            document.getElementById('sidebarOverlay').classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('sidebarOverlay').classList.remove('show');
            document.body.style.overflow = '';
        }

        function toggleNotif(e) {
            e.stopPropagation();
            const d = document.getElementById('notif-dropdown');
            d.style.display = d.style.display === 'none' ? 'block' : 'none';
        }

        document.addEventListener('click', function (e) {
            const d = document.getElementById('notif-dropdown');
            if (d && !d.contains(e.target)) d.style.display = 'none';
        });

        document.querySelectorAll('.nav-item a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 768) closeSidebar();
            });
        });
    </script>
    @stack('scripts')
</body>

</html>