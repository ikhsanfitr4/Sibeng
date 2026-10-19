<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Bengkel ATR') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <link rel="icon" type="image/png" href="{{ asset('LogoATR.png') }}">


    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        html,
        body {
            min-height: 100%;
            background: #020617;
            overflow-x: hidden;
        }

        body {
            color: #fff;
        }

        canvas#aurora {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            background:
                radial-gradient(circle at 20% 20%, rgba(99, 102, 241, .24), transparent 35%),
                radial-gradient(circle at 80% 80%, rgba(14, 165, 233, .18), transparent 35%),
                linear-gradient(135deg, #020617, #0f172a 55%, #020617);
        }

        .glow {
            position: fixed;
            width: 420px;
            height: 420px;
            border-radius: 999px;
            filter: blur(90px);
            opacity: .35;
            z-index: 2;
            pointer-events: none;
        }

        .glow-1 {
            top: -120px;
            left: -100px;
            background: #6366f1;
        }

        .glow-2 {
            right: -120px;
            bottom: -130px;
            background: #0ea5e9;
        }

        .login-page {
            position: relative;
            z-index: 3;
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1.1fr .9fr;
            align-items: center;
            gap: 40px;
            padding: 48px 7%;
        }

        .hero {
            max-width: 620px;
            animation: fadeLeft .8s ease;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 14px;
            margin-bottom: 22px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .08);
            border: 1px solid rgba(255, 255, 255, .14);
            color: #c7d2fe;
            font-size: 13px;
            font-weight: 600;
            backdrop-filter: blur(20px);
        }

        .badge span {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #22c55e;
            box-shadow: 0 0 14px rgba(34, 197, 94, .8);
        }

        .hero h1 {
            font-size: clamp(38px, 6vw, 72px);
            line-height: 1.02;
            letter-spacing: -2.5px;
            font-weight: 900;
            margin-bottom: 22px;
        }

        .hero h1 span {
            background: linear-gradient(135deg, #a5b4fc, #38bdf8, #67e8f9);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero p {
            color: #94a3b8;
            font-size: 16px;
            line-height: 1.8;
            max-width: 520px;
            margin-bottom: 28px;
        }

        .feature-list {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
            max-width: 560px;
        }

        .feature {
            padding: 16px;
            border-radius: 18px;
            background: rgba(255, 255, 255, .07);
            border: 1px solid rgba(255, 255, 255, .12);
            backdrop-filter: blur(18px);
        }

        .feature i {
            display: inline-flex;
            width: 34px;
            height: 34px;
            border-radius: 12px;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            background: rgba(99, 102, 241, .16);
            color: #a5b4fc;
            font-size: 17px;
        }

        .feature strong {
            display: block;
            font-size: 13px;
            margin-bottom: 5px;
            color: #f8fafc;
        }

        .feature small {
            color: #94a3b8;
            line-height: 1.5;
            font-size: 11px;
        }

        .login-wrap {
            display: flex;
            justify-content: center;
            animation: fadeUp .8s ease;
        }

        .card {
            width: 100%;
            max-width: 430px;
            padding: 34px;
            border-radius: 32px;
            background: rgba(15, 23, 42, .72);
            border: 1px solid rgba(255, 255, 255, .16);
            box-shadow:
                0 35px 90px rgba(0, 0, 0, .55),
                inset 0 1px 0 rgba(255, 255, 255, .08);
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
        }

        .top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
        }

        .logo-row {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            width: 56px;
            height: 56px;
            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            overflow: hidden;
            border-radius: 10px;

            background: transparent;
            box-shadow: none;
        }

        .logo-img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
            object-fit: cover;
            transform: none;
            display: block;
        }

        .logo-name {
            font-size: 18px;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.2;
            letter-spacing: .3px;
        }

        .logo-sub {
            font-size: 12px;
            color: #94a3b8;
            margin-top: 2px;
            letter-spacing: .5px;
        }

        .status {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 7px 10px;
            border-radius: 999px;
            background: rgba(34, 197, 94, .10);
            border: 1px solid rgba(34, 197, 94, .18);
            color: #86efac;
            font-size: 11px;
            font-weight: 700;
        }

        .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #22c55e;
            box-shadow: 0 0 12px rgba(34, 197, 94, .8);
            animation: pulse 1.8s infinite;
        }

        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, .15), transparent);
            margin-bottom: 26px;
        }

        .greeting {
            color: #93c5fd;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .heading {
            color: #f8fafc;
            font-size: 27px;
            font-weight: 900;
            letter-spacing: -.8px;
            margin-bottom: 8px;
        }

        .desc {
            color: #94a3b8;
            font-size: 13px;
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 13px 14px;
            margin-bottom: 20px;
            border-radius: 15px;
            background: rgba(239, 68, 68, .13);
            border: 1px solid rgba(248, 113, 113, .32);
            color: #fecaca;
            font-size: 13px;
            line-height: 1.5;
        }

        .field {
            margin-bottom: 17px;
        }

        .field-label {
            display: block;
            margin-bottom: 8px;
            color: #cbd5e1;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .05em;
            text-transform: uppercase;
        }

        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrap .left-icon {
            position: absolute;
            left: 16px;
            color: #64748b;
            font-size: 17px;
            pointer-events: none;
            transition: .25s;
        }

        .inp {
            width: 100%;
            padding: 15px 46px 15px 48px;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, .12);
            background: rgba(2, 6, 23, .56);
            color: #f8fafc;
            outline: none;
            font-size: 14px;
            transition: .25s;
        }

        .inp::placeholder {
            color: #475569;
        }

        .inp:focus {
            border-color: rgba(56, 189, 248, .65);
            background: rgba(2, 6, 23, .82);
            box-shadow: 0 0 0 4px rgba(56, 189, 248, .12);
        }

        .inp:focus+.left-icon,
        .input-wrap:focus-within .left-icon {
            color: #38bdf8;
        }

        .eye-btn {
            position: absolute;
            right: 12px;
            width: 34px;
            height: 34px;
            border-radius: 11px;
            border: none;
            background: transparent;
            color: #64748b;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: .2s;
        }

        .eye-btn:hover {
            background: rgba(255, 255, 255, .06);
            color: #e2e8f0;
        }

        .form-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 4px 0 22px;
            gap: 12px;
        }

        .check-row {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            color: #94a3b8;
            font-size: 13px;
            user-select: none;
        }

        .check-row input {
            width: 15px;
            height: 15px;
            accent-color: #6366f1;
        }

        .role-info {
            color: #64748b;
            font-size: 12px;
        }

        .btn {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 17px;
            cursor: pointer;
            color: white;
            font-size: 15px;
            font-weight: 800;
            background: linear-gradient(135deg, #6366f1, #0ea5e9);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            box-shadow: 0 18px 38px rgba(14, 165, 233, .25);
            transition: .25s;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 24px 50px rgba(14, 165, 233, .35);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn:disabled {
            cursor: not-allowed;
            transform: none;
        }

        .spinner {
            display: none;
            width: 17px;
            height: 17px;
            border: 2px solid rgba(255, 255, 255, .35);
            border-top-color: white;
            border-radius: 50%;
            animation: spin .7s linear infinite;
        }

        .security {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-top: 22px;
        }

        .security-item {
            text-align: center;
            padding: 11px 7px;
            border-radius: 14px;
            background: rgba(255, 255, 255, .045);
            border: 1px solid rgba(255, 255, 255, .08);
            color: #94a3b8;
            font-size: 11px;
        }

        .security-item i {
            display: block;
            margin-bottom: 6px;
            color: #38bdf8;
            font-size: 15px;
        }

        .footer-note {
            text-align: center;
            margin-top: 20px;
            color: #64748b;
            font-size: 12px;
        }

        .footer-note span {
            color: #93c5fd;
            font-weight: 700;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(28px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeLeft {
            from {
                opacity: 0;
                transform: translateX(-28px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: .45;
                transform: scale(.8);
            }
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 992px) {
            .login-page {
                grid-template-columns: 1fr;
                padding: 34px 22px;
            }

            .hero {
                text-align: center;
                margin: 0 auto;
            }

            .hero p {
                margin-left: auto;
                margin-right: auto;
            }

            .feature-list {
                margin: 0 auto;
            }
        }

        @media (max-width: 640px) {
            .login-page {
                padding: 22px 16px;
            }

            .hero {
                display: none;
            }

            .card {
                max-width: 100%;
                padding: 28px 22px;
                border-radius: 26px;
            }

            .top-bar {
                margin-bottom: 22px;
            }

            .logo-icon {

                .logo-icon {
                    width: 56px;
                    height: 56px;
                    flex-shrink: 0;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    overflow: hidden;
                    border-radius: 10px;
                    background: transparent;
                    box-shadow: none;
                }

            }

            .status {
                display: none;
            }

            .heading {
                font-size: 24px;
            }

            .desc {
                font-size: 12px;
            }

            .form-row {
                align-items: flex-start;
                flex-direction: column;
            }

            .security {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 380px) {
            .card {
                padding: 24px 18px;
            }

            .heading {
                font-size: 22px;
            }

            .inp {
                padding-top: 14px;
                padding-bottom: 14px;
            }
        }
    </style>
</head>

<body>

    <canvas id="aurora"></canvas>

    <div class="glow glow-1"></div>
    <div class="glow glow-2"></div>

    <main class="login-page">

        <section class="hero">
            <div class="badge">
                <span></span>
                Sistem Bengkel Online Aktif
            </div>

            <h1>Kelola Bengkel Jadi Lebih <span>Modern</span></h1>

            <p>
                Login ke dashboard untuk mengelola data servis, pelanggan, mekanik,
                transaksi, laporan, dan aktivitas sistem bengkel secara cepat dan rapi.
            </p>

            <div class="feature-list">
                <div class="feature">
                    <i class="bi bi-speedometer2"></i>
                    <strong>Dashboard Cepat</strong>
                    <small>Pantau data utama bengkel secara real-time.</small>
                </div>

                <div class="feature">
                    <i class="bi bi-shield-check"></i>
                    <strong>Akses Aman</strong>
                    <small>Login khusus untuk owner dan admin.</small>
                </div>

                <div class="feature">
                    <i class="bi bi-graph-up-arrow"></i>
                    <strong>Laporan Rapi</strong>
                    <small>Data transaksi dan servis mudah dipantau.</small>
                </div>
            </div>
        </section>

        <section class="login-wrap">
            <div class="card">

                <div class="top-bar">
                    <div class="logo-row">

                        <div class="logo-icon">
                            <img src="{{ asset('LogoATR.png') }}" alt="Logo Bengkel ATR" class="logo-img">
                        </div>


                        <div>
                            <div class="logo-name">Bengkel ATR</div>
                            <div class="logo-sub">Management System</div>
                        </div>
                    </div>

                    <div class="status">
                        <span class="status-dot"></span>
                        Online
                    </div>
                </div>

                <div class="divider"></div>

                <p class="greeting">Selamat datang kembali</p>
                <h2 class="heading">Masuk ke Dashboard</h2>
                <p class="desc">
                    Gunakan akun owner atau admin untuk mengakses sistem.
                </p>

                @if($errors->any())
                    <div class="alert">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" id="loginForm">
                    @csrf

                    <div class="field">
                        <label class="field-label" for="email">Email Address</label>

                        <div class="input-wrap">
                            <input class="inp" id="email" type="email" name="email" value="{{ old('email') }}"
                                placeholder="Masukkan Email" autocomplete="username" required autofocus>
                            <i class="bi bi-envelope left-icon"></i>
                        </div>
                    </div>

                    <div class="field">
                        <label class="field-label" for="password">Password</label>

                        <div class="input-wrap">
                            <input class="inp" id="password" type="password" name="password"
                                placeholder="Masukkan password" autocomplete="current-password" required>
                            <i class="bi bi-lock left-icon"></i>

                            <button class="eye-btn" id="eyeBtn" aria-label="Tampilkan password" type="button">
                                <i class="bi bi-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-row">
                        <label class="check-row">
                            <input type="checkbox" name="remember" id="remember">
                            <span>Ingat saya</span>
                        </label>

                        <div class="role-info">
                            Owner / Admin
                        </div>
                    </div>

                    <button class="btn" type="submit" id="loginBtn">
                        <span id="btnText">Masuk Sekarang</span>
                        <i class="bi bi-arrow-right" id="btnIcon"></i>
                        <div class="spinner" id="spinner"></div>
                    </button>

                </form>

                <div class="security">
                    <div class="security-item">
                        <i class="bi bi-shield-lock"></i>
                        Secure
                    </div>

                    <div class="security-item">
                        <i class="bi bi-lightning-charge"></i>
                        Fast
                    </div>

                    <div class="security-item">
                        <i class="bi bi-cloud-check"></i>
                        Online
                    </div>
                </div>

                <p class="footer-note">
                    © {{ date('Y') }} <span>Bengkel ATR</span>. All rights reserved.
                </p>

            </div>
        </section>

    </main>

    <script>
        (function () {
            const canvas = document.getElementById('aurora');
            const ctx = canvas.getContext('2d');

            let W;
            let H;
            let t = 0;

            function resize() {
                W = canvas.width = window.innerWidth;
                H = canvas.height = window.innerHeight;
            }

            resize();
            window.addEventListener('resize', resize);

            const stars = Array.from({ length: 150 }, () => ({
                x: Math.random(),
                y: Math.random(),
                r: Math.random() * 1.4 + 0.2,
                a: Math.random()
            }));

            function drawStars() {
                stars.forEach(star => {
                    ctx.beginPath();
                    ctx.arc(star.x * W, star.y * H, star.r, 0, Math.PI * 2);

                    const flicker = 0.25 + 0.75 * Math.abs(Math.sin(t * 0.8 + star.a * 10));

                    ctx.fillStyle = `rgba(220,235,255,${flicker * 0.65})`;
                    ctx.fill();
                });
            }

            function wave(x, offset, freq, amp) {
                return H * 0.36
                    + Math.sin(x * freq + t * 0.34 + offset) * amp
                    + Math.sin(x * freq * 1.8 + t * 0.19 + offset) * amp * 0.45;
            }

            function drawAurora() {
                const bands = [
                    {
                        color1: 'rgba(34,211,238,0.18)',
                        color2: 'rgba(34,211,238,0)',
                        offset: 0,
                        freq: 0.006,
                        amp: 60
                    },
                    {
                        color1: 'rgba(99,102,241,0.24)',
                        color2: 'rgba(99,102,241,0)',
                        offset: 2.1,
                        freq: 0.005,
                        amp: 75
                    },
                    {
                        color1: 'rgba(14,165,233,0.17)',
                        color2: 'rgba(14,165,233,0)',
                        offset: 4.3,
                        freq: 0.007,
                        amp: 52
                    },
                    {
                        color1: 'rgba(168,85,247,0.15)',
                        color2: 'rgba(168,85,247,0)',
                        offset: 1.5,
                        freq: 0.004,
                        amp: 88
                    }
                ];

                bands.forEach(band => {
                    ctx.beginPath();
                    ctx.moveTo(0, H);

                    for (let x = 0; x <= W; x += 4) {
                        ctx.lineTo(x, wave(x, band.offset, band.freq, band.amp));
                    }

                    ctx.lineTo(W, H);
                    ctx.closePath();

                    const grad = ctx.createLinearGradient(0, H * 0.05, 0, H * 0.72);
                    grad.addColorStop(0, band.color1);
                    grad.addColorStop(1, band.color2);

                    ctx.fillStyle = grad;
                    ctx.fill();
                });
            }

            function loop() {
                ctx.clearRect(0, 0, W, H);
                drawStars();
                drawAurora();
                t += 0.012;
                requestAnimationFrame(loop);
            }

            loop();

            const eyeBtn = document.getElementById('eyeBtn');
            const eyeIcon = document.getElementById('eyeIcon');
            const passInput = document.getElementById('password');

            eyeBtn.addEventListener('click', function () {
                const show = passInput.type === 'password';

                passInput.type = show ? 'text' : 'password';
                eyeIcon.className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
                eyeBtn.setAttribute(
                    'aria-label',
                    show ? 'Sembunyikan password' : 'Tampilkan password'
                );
            });

            const loginForm = document.getElementById('loginForm');
            const loginBtn = document.getElementById('loginBtn');

            loginForm.addEventListener('submit', function () {
                loginBtn.disabled = true;
                loginBtn.style.opacity = '0.85';

                document.getElementById('btnText').textContent = 'Memverifikasi...';
                document.getElementById('btnIcon').style.display = 'none';
                document.getElementById('spinner').style.display = 'block';
            });
        })();
    </script>

</body>

</html>