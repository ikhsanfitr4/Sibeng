<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk — {{ $transaksi->no_transaksi }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', monospace;
            background: #fff;
            color: #000;
            font-size: 12px;
        }

        .struk {
            width: 300px;
            margin: 0 auto;
            padding: 16px 12px;
        }

        /* Header */
        .header {
            text-align: center;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .header h1 {
            font-size: 18px;
            font-weight: 900;
            letter-spacing: 2px;
        }

        .header h1 span {
            font-style: italic;
        }

        .header p {
            font-size: 10px;
            color: #444;
            margin-top: 2px;
        }

        /* Info baris */
        .info-section {
            border-bottom: 1px dashed #000;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
            font-size: 11px;
        }

        .info-row .label {
            color: #555;
        }

        .info-row .value {
            font-weight: 600;
            text-align: right;
            max-width: 60%;
        }

        /* Title section */
        .section-title {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #555;
            margin-bottom: 5px;
        }

        /* Tabel items */
        .items {
            width: 100%;
            border-bottom: 1px dashed #000;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }

        .item-row {
            margin-bottom: 4px;
        }

        .item-name {
            font-weight: 600;
        }

        .item-detail {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: #333;
        }

        /* Total */
        .total-section {
            border-bottom: 1px dashed #000;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
            font-size: 11px;
        }

        .total-row.grand {
            font-size: 14px;
            font-weight: 900;
            margin-top: 5px;
        }

        .total-row.grand .label {
            font-weight: 900;
        }

        /* Bayar */
        .bayar-section {
            border-bottom: 1px dashed #000;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }

        .bayar-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
            font-size: 11px;
        }

        .kembalian-row {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            font-weight: 900;
        }

        /* Footer */
        .footer {
            text-align: center;
            font-size: 10px;
            color: #555;
            line-height: 1.6;
        }

        .footer .thanks {
            font-size: 13px;
            font-weight: 900;
            color: #000;
            margin-bottom: 4px;
        }

        /* Barcode simulasi */
        .barcode {
            text-align: center;
            margin: 8px 0;
            font-size: 9px;
            letter-spacing: 3px;
            color: #555;
        }

        /* Print button - tidak ikut tercetak */
        .print-actions {
            width: 300px;
            margin: 20px auto;
            display: flex;
            gap: 8px;
        }

        .btn-print {
            flex: 1;
            background: #000;
            color: #fff;
            border: none;
            padding: 10px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            border-radius: 6px;
        }

        .btn-close {
            flex: 1;
            background: #eee;
            color: #000;
            border: none;
            padding: 10px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            border-radius: 6px;
            text-decoration: none;
            text-align: center;
        }

        @media print {
            .print-actions {
                display: none;
            }

            body {
                background: #fff;
            }

            .struk {
                margin: 0;
                padding: 8px;
            }
        }
    </style>
</head>

<body>

    {{-- Tombol aksi (tidak ikut print) --}}
    <div class="print-actions">
        <button class="btn-print" onclick="window.print()">
            🖨️ Cetak Struk
        </button>
        <button class="btn-close" onclick="window.close()">
            ✕ Tutup
        </button>
    </div>

    {{-- Struk --}}
    <div class="struk">

        {{-- Header Bengkel --}}
        <div class="header">
            <h1>BENGKEL <span>ATR</span></h1>
            <p>Jl. Sei Mintan , Pekanbaru</p>
            <p>Telp: (+62) 228-413-7341 </p>
            <p>{{ \Carbon\Carbon::parse($transaksi->tanggal_bayar)->format('d/m/Y H:i') }}</p>
        </div>

        {{-- No Transaksi --}}
        <div class="info-section">
            <div class="info-row">
                <span class="label">No. Transaksi</span>
                <span class="value">{{ $transaksi->no_transaksi }}</span>
            </div>
            <div class="info-row">
                <span class="label">No. Order</span>
                <span class="value">{{ $transaksi->servis->no_order }}</span>
            </div>
            <div class="info-row">
                <span class="label">Metode Bayar</span>
                <span class="value">{{ strtoupper($transaksi->metode_bayar) }}</span>
            </div>
        </div>

        {{-- Info Pelanggan --}}
        <div class="info-section">
            <div class="section-title">Info Pelanggan</div>
            <div class="info-row">
                <span class="label">Nama</span>
                <span class="value">{{ $transaksi->servis->pelanggan->nama ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="label">Telepon</span>
                <span class="value">{{ $transaksi->servis->pelanggan->telepon ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="label">Kendaraan</span>
                <span class="value">{{ $transaksi->servis->kendaraan->merk ?? '' }}
                    {{ $transaksi->servis->kendaraan->model ?? '' }}</span>
            </div>
            <div class="info-row">
                <span class="label">Plat Nomor</span>
                <span class="value">{{ $transaksi->servis->kendaraan->plat_nomor ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="label">Mekanik</span>
                <span class="value">{{ $transaksi->servis->mekanik->nama ?? '-' }}</span>
            </div>
        </div>

        {{-- Keluhan --}}
        <div class="info-section">
            <div class="section-title">Keluhan</div>
            <div style="font-size:11px; line-height:1.5">
                {{ $transaksi->servis->keluhan }}
            </div>
        </div>

        {{-- Biaya Jasa --}}
        <div class="items">
            <div class="section-title">Rincian Biaya</div>

            <div class="item-row">
                <div class="item-name">Biaya Jasa Servis</div>
                <div class="item-detail">
                    <span>1 x layanan</span>
                    <span>Rp {{ number_format($transaksi->total_jasa, 0, ',', '.') }}</span>
                </div>
            </div>

            {{-- Spare Parts --}}
            @foreach($transaksi->details as $d)
                <div class="item-row" style="margin-top:4px">
                    <div class="item-name">{{ $d->sparePart->nama ?? '-' }}</div>
                    <div class="item-detail">
                        <span>{{ $d->qty }} x Rp {{ number_format($d->harga_satuan, 0, ',', '.') }}</span>
                        <span>Rp {{ number_format($d->subtotal, 0, ',', '.') }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Total --}}
        <div class="total-section">
            <div class="total-row">
                <span class="label">Subtotal Jasa</span>
                <span>Rp {{ number_format($transaksi->total_jasa, 0, ',', '.') }}</span>
            </div>
            <div class="total-row">
                <span class="label">Subtotal Parts</span>
                <span>Rp {{ number_format($transaksi->total_parts, 0, ',', '.') }}</span>
            </div>
            <div class="total-row grand">
                <span class="label">TOTAL</span>
                <span>Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- Pembayaran --}}
        <div class="bayar-section">
            <div class="bayar-row">
                <span>Dibayar</span>
                <span>Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</span>
            </div>
            <div class="kembalian-row">
                <span>Kembalian</span>
                <span>Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- Barcode simulasi --}}
        <div class="barcode">
            ||||| {{ $transaksi->no_transaksi }} |||||
        </div>

        {{-- Footer --}}
        <div class="footer">
            <div class="thanks">Terima Kasih!</div>
            <p>Simpan struk ini sebagai bukti servis</p>
            <p>Garansi servis 7 hari setelah pengerjaan</p>
            <p style="margin-top:6px">— Bengkel ATR —</p>
        </div>

    </div>

</body>

</html>