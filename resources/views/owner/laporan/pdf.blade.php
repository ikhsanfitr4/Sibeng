<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan {{ $namaBulan }} {{ $tahun }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #1a1a1a;
            background: #fff;
        }

        /* ── HEADER ── */
        .header {
            position: relative;
            background: #1a1a1a;
            color: #fff;
            padding: 0;
            margin-bottom: 24px;
            overflow: hidden;
        }

        .header-top {
            background: #E85D04;
            padding: 18px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand-name {
            font-size: 26px;
            font-weight: 900;
            letter-spacing: 3px;
            color: #fff;
        }

        .brand-name span {
            color: #1a1a1a;
            font-style: italic;
        }

        .brand-tagline {
            font-size: 9px;
            color: rgba(255, 255, 255, .8);
            letter-spacing: 1px;
            margin-top: 3px;
            text-transform: uppercase;
        }

        .header-right {
            text-align: right;
            font-size: 9px;
            color: rgba(255, 255, 255, .85);
            line-height: 1.8;
        }

        .header-bottom {
            background: #1a1a1a;
            padding: 12px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .laporan-title {
            font-size: 13px;
            font-weight: 700;
            color: #fff;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .laporan-period {
            font-size: 11px;
            color: #E85D04;
            font-weight: 700;
        }

        .header-badge {
            background: #E85D04;
            color: #fff;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* ── STAT CARDS ── */
        .stats-grid {
            display: flex;
            gap: 10px;
            margin-bottom: 22px;
        }

        .stat-card {
            flex: 1;
            border-radius: 10px;
            padding: 14px 12px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .stat-card.orange {
            background: #fff7ed;
            border: 1.5px solid #fed7aa;
        }

        .stat-card.blue {
            background: #eff6ff;
            border: 1.5px solid #bfdbfe;
        }

        .stat-card.green {
            background: #f0fdf4;
            border: 1.5px solid #bbf7d0;
        }

        .stat-card.gray {
            background: #f9fafb;
            border: 1.5px solid #e5e7eb;
        }

        .stat-icon {
            font-size: 18px;
            margin-bottom: 6px;
            display: block;
        }

        .stat-val {
            font-size: 15px;
            font-weight: 900;
            display: block;
            margin-bottom: 4px;
            line-height: 1.2;
        }

        .stat-card.orange .stat-val {
            color: #E85D04;
        }

        .stat-card.blue .stat-val {
            color: #1d4ed8;
        }

        .stat-card.green .stat-val {
            color: #16a34a;
        }

        .stat-card.gray .stat-val {
            color: #374151;
        }

        .stat-lbl {
            font-size: 8.5px;
            color: #888;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        /* ── SECTION TITLE ── */
        .section-header {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            gap: 8px;
        }

        .section-line {
            height: 18px;
            width: 4px;
            background: #E85D04;
            border-radius: 2px;
            display: inline-block;
        }

        .section-title {
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #1a1a1a;
        }

        .section-count {
            margin-left: auto;
            background: #1a1a1a;
            color: #fff;
            padding: 2px 10px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: 700;
        }

        /* ── TABLE ── */
        .table-wrap {
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            margin-bottom: 22px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            background: #1a1a1a;
        }

        thead th {
            color: #fff;
            padding: 9px 10px;
            font-size: 8.5px;
            text-transform: uppercase;
            letter-spacing: .8px;
            font-weight: 700;
            text-align: left;
        }

        tbody td {
            padding: 8px 10px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 10px;
            vertical-align: middle;
        }

        tbody tr:nth-child(even) td {
            background: #fafafa;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .td-no {
            color: #999;
            font-size: 9px;
            text-align: center;
            width: 24px;
        }

        .td-code {
            font-family: 'DejaVu Sans Mono', monospace;
            font-size: 9px;
            color: #E85D04;
            font-weight: 700;
        }

        .td-bold {
            font-weight: 700;
        }

        .td-amount {
            font-weight: 900;
            color: #16a34a;
            text-align: right;
        }

        /* Badge */
        .badge {
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 8.5px;
            font-weight: 700;
            display: inline-block;
        }

        .badge-tunai {
            background: #fef9c3;
            color: #a16207;
        }

        .badge-transfer {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .badge-qris {
            background: #f3e8ff;
            color: #7c3aed;
        }

        /* ── SUMMARY BOX ── */
        .summary-box {
            background: #1a1a1a;
            border-radius: 10px;
            padding: 16px 20px;
            margin-bottom: 24px;
            color: #fff;
        }

        .summary-title {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #888;
            margin-bottom: 12px;
            font-weight: 700;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px solid #2a2a2a;
            font-size: 10px;
            color: #ccc;
        }

        .summary-row:last-child {
            border-bottom: none;
        }

        .summary-row .s-val {
            color: #fff;
            font-weight: 700;
        }

        .summary-grand {
            display: flex;
            justify-content: space-between;
            padding: 10px 0 0;
            margin-top: 8px;
            border-top: 1px solid #E85D04;
        }

        .summary-grand .g-label {
            font-size: 12px;
            font-weight: 900;
            color: #E85D04;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .summary-grand .g-val {
            font-size: 16px;
            font-weight: 900;
            color: #E85D04;
        }

        /* ── TTD ── */
        .ttd-section {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 24px;
        }

        .ttd-box {
            text-align: center;
            width: 160px;
        }

        .ttd-city {
            font-size: 10px;
            color: #555;
            margin-bottom: 50px;
        }

        .ttd-line {
            border-top: 1px solid #1a1a1a;
            margin-bottom: 4px;
        }

        .ttd-name {
            font-size: 10px;
            font-weight: 700;
            color: #1a1a1a;
        }

        .ttd-jabatan {
            font-size: 9px;
            color: #888;
        }

        /* ── FOOTER ── */
        .footer {
            border-top: 2px solid #E85D04;
            padding-top: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-left {
            font-size: 8.5px;
            color: #aaa;
            line-height: 1.7;
        }

        .footer-right {
            font-size: 8.5px;
            color: #aaa;
            text-align: right;
        }

        .footer-brand {
            font-size: 11px;
            font-weight: 900;
            color: #E85D04;
            letter-spacing: 1px;
        }

        /* No data */
        .no-data {
            text-align: center;
            padding: 30px;
            color: #bbb;
            font-style: italic;
            font-size: 11px;
        }

        /* Divider */
        .divider {
            border: none;
            border-top: 1px dashed #e5e7eb;
            margin: 20px 0;
        }
    </style>
</head>

<body>

    {{-- ── HEADER ── --}}
    <div class="header">
        <div class="header-top">
            <div>
                <div class="brand-name">BENGKEL <span>ATR</span></div>
                <div class="brand-tagline">Jl. Sei Mintan, Pekanbaru &nbsp;·&nbsp; Telp: (+62) 822-8413-7341 </div>
            </div>
            <div class="header-right">
                <div>Dicetak: {{ now()->format('d/m/Y H:i') }}</div>
                <div>Oleh: Owner / Pimpinan</div>
                <div>Bengkel ATR System v1.0</div>
            </div>
        </div>
        <div class="header-bottom">
            <div>
                <div class="laporan-title">Laporan Keuangan Bulanan</div>
                <div class="laporan-period">{{ $namaBulan }} {{ $tahun }}</div>
            </div>
            <div class="header-badge">Konfidensial</div>
        </div>
    </div>

    {{-- ── STAT CARDS ── --}}
    <div class="stats-grid">
        <div class="stat-card orange">
            <span class="stat-icon">💰</span>
            <span class="stat-val">Rp {{ number_format($pendapatan, 0, ',', '.') }}</span>
            <span class="stat-lbl">Total Pendapatan</span>
        </div>
        <div class="stat-card blue">
            <span class="stat-icon">🔧</span>
            <span class="stat-val">{{ $totalServis }}</span>
            <span class="stat-lbl">Total Servis</span>
        </div>
        <div class="stat-card green">
            <span class="stat-icon">✅</span>
            <span class="stat-val">{{ $servisSelesai }}</span>
            <span class="stat-lbl">Servis Selesai</span>
        </div>
        <div class="stat-card gray">
            <span class="stat-icon">🧾</span>
            <span class="stat-val">{{ $transaksiList->count() }}</span>
            <span class="stat-lbl">Total Transaksi</span>
        </div>
    </div>

    {{-- ── TABEL TRANSAKSI ── --}}
    <div class="section-header">
        <span class="section-line"></span>
        <span class="section-title">Rincian Transaksi</span>
        <span class="section-count">{{ $transaksiList->count() }} Data</span>
    </div>

    @if($transaksiList->count() > 0)
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="text-align:center">#</th>
                        <th>No. Transaksi</th>
                        <th>No. Order</th>
                        <th>Pelanggan</th>
                        <th>Kendaraan</th>
                        <th>Mekanik</th>
                        <th>Metode</th>
                        <th>Tgl Bayar</th>
                        <th style="text-align:right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksiList as $i => $t)
                        <tr>
                            <td class="td-no">{{ $i + 1 }}</td>
                            <td class="td-code">{{ $t->no_transaksi }}</td>
                            <td class="td-code">{{ $t->servis->no_order ?? '-' }}</td>
                            <td class="td-bold">{{ $t->servis->pelanggan->nama ?? '-' }}</td>
                            <td>{{ $t->servis->kendaraan->plat_nomor ?? '-' }}</td>
                            <td>{{ $t->servis->mekanik->nama ?? '-' }}</td>
                            <td>
                                <span class="badge badge-{{ $t->metode_bayar }}">
                                    {{ strtoupper($t->metode_bayar) }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($t->tanggal_bayar)->format('d/m/Y') }}</td>
                            <td class="td-amount">Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="table-wrap">
            <div class="no-data">Tidak ada transaksi pada {{ $namaBulan }} {{ $tahun }}</div>
        </div>
    @endif

    {{-- ── SUMMARY ── --}}
    <div class="summary-box">
        <div class="summary-title">Ringkasan Laporan</div>
        <div class="summary-row">
            <span>Periode Laporan</span>
            <span class="s-val">{{ $namaBulan }} {{ $tahun }}</span>
        </div>
        <div class="summary-row">
            <span>Total Servis Masuk</span>
            <span class="s-val">{{ $totalServis }} servis</span>
        </div>
        <div class="summary-row">
            <span>Servis Selesai</span>
            <span class="s-val">{{ $servisSelesai }} servis</span>
        </div>
        <div class="summary-row">
            <span>Jumlah Transaksi Lunas</span>
            <span class="s-val">{{ $transaksiList->count() }} transaksi</span>
        </div>
        <div class="summary-grand">
            <span class="g-label">Total Pendapatan</span>
            <span class="g-val">Rp {{ number_format($pendapatan, 0, ',', '.') }}</span>
        </div>
    </div>

    {{-- ── TTD ── --}}
    <div class="ttd-section">
        <div class="ttd-box">
            <div class="ttd-city">Surabaya, {{ now()->format('d') }} {{ $namaBulan }} {{ $tahun }}</div>
            <div class="ttd-line"></div>
            <div class="ttd-name">( ________________ )</div>
            <div class="ttd-jabatan">Owner / Pimpinan</div>
        </div>
    </div>

    {{-- ── FOOTER ── --}}
    <div class="footer">
        <div class="footer-left">
            <div>Dokumen ini digenerate otomatis oleh sistem Bengkel ATR</div>
            <div>{{ now()->format('d F Y \p\u\k\u\l H:i:s') }}</div>
            <div>Laporan ini bersifat rahasia dan hanya untuk internal perusahaan</div>
        </div>
        <div class="footer-right">
            <div class="footer-brand">BENGKEL ATR</div>
            <div>Laporan {{ $namaBulan }} {{ $tahun }}</div>
        </div>
    </div>

</body>

</html>