<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --primary: #0ea5e9;
            --body-bg: #111;
            --surface: #1A1A1A;
            --border: #2A2A2A;
            --text: #F0F0F0;
            --muted: #777;
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
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .error-wrap {
            text-align: center;
            padding: 2rem;
            max-width: 480px;
        }

        .error-code {
            font-size: 8rem;
            font-weight: 800;
            line-height: 1;
            background: linear-gradient(135deg, #ef4444, #f97316);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .error-icon {
            font-size: 3rem;
            margin: 1rem 0 .5rem;
        }

        .error-title {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: .6rem;
        }

        .error-desc {
            font-size: .9rem;
            color: var(--muted);
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .btn-home {
            background: linear-gradient(135deg, var(--primary), #38bdf8);
            border: none;
            color: #fff;
            font-weight: 700;
            font-size: .9rem;
            border-radius: 12px;
            padding: .7rem 1.5rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            transition: opacity .2s;
        }

        .btn-home:hover {
            opacity: .85;
            color: #fff;
        }

        .btn-back-link {
            display: block;
            margin-top: 1rem;
            font-size: .82rem;
            color: var(--muted);
            text-decoration: none;
            transition: color .2s;
        }

        .btn-back-link:hover {
            color: var(--text);
        }

        .divider {
            width: 60px;
            height: 3px;
            background: linear-gradient(135deg, #ef4444, #f97316);
            border-radius: 4px;
            margin: 1.5rem auto;
        }

        .badge-403 {
            display: inline-block;
            background: rgba(239, 68, 68, .12);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, .25);
            font-size: .75rem;
            font-weight: 700;
            padding: .3rem .8rem;
            border-radius: 20px;
            margin-bottom: 1rem;
            letter-spacing: .05em;
        }
    </style>
</head>

<body>
    <div class="error-wrap">
        <div class="error-code">403</div>
        <div class="error-icon">🚫</div>
        <div class="divider"></div>
        <div class="badge-403">AKSES DITOLAK</div>
        <div class="error-title">Kamu Tidak Punya Izin</div>
        <div class="error-desc">
            Halaman ini hanya bisa diakses oleh pengguna dengan hak akses tertentu.<br>
            Hubungi owner jika kamu merasa ini adalah kesalahan.
        </div>
        @auth
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="btn-home">
                    <i class="bi bi-speedometer2"></i> Kembali ke Dashboard
                </a>
            @else
                <a href="{{ route('owner.dashboard') }}" class="btn-home">
                    <i class="bi bi-speedometer2"></i> Kembali ke Dashboard
                </a>
            @endif
        @else
            <a href="{{ route('login') }}" class="btn-home">
                <i class="bi bi-box-arrow-in-right"></i> Ke Halaman Login
            </a>
        @endauth
        <a href="javascript:history.back()" class="btn-back-link">
            ← Kembali ke halaman sebelumnya
        </a>
    </div>
</body>

</html>