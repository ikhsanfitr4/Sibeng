@extends('layouts.app')
@section('title', 'Detail Transaksi')
@section('page-title', 'Detail Transaksi')

@section('content')
    <div class="row g-3" style="max-width:800px">
        <div class="col-12">
            <div class="panel">
                <div class="panel-header">
                    <h5><i class="bi bi-receipt me-2" style="color:var(--primary)"></i>{{ $transaksi->no_transaksi }}</h5>
                    <span class="badge-status badge-lunas">{{ ucfirst($transaksi->status) }}</span>
                </div>
                <div class="panel-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <div class="info-row"><span>No Order
                                    Servis</span><strong>{{ $transaksi->servis->no_order }}</strong></div>
                            <div class="info-row">
                                <span>Pelanggan</span><strong>{{ $transaksi->servis->pelanggan->nama ?? '-' }}</strong>
                            </div>
                            <div class="info-row">
                                <span>Kendaraan</span><strong>{{ $transaksi->servis->kendaraan->plat_nomor ?? '-' }}</strong>
                            </div>
                            <div class="info-row">
                                <span>Mekanik</span><strong>{{ $transaksi->servis->mekanik->nama ?? '-' }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-row"><span>Tanggal
                                    Bayar</span><strong>{{ \Carbon\Carbon::parse($transaksi->tanggal_bayar)->format('d/m/Y H:i') }}</strong>
                            </div>
                            <div class="info-row"><span>Metode
                                    Bayar</span><strong>{{ ucfirst($transaksi->metode_bayar) }}</strong></div>
                            <div class="info-row"><span>Jumlah Bayar</span><strong>Rp
                                    {{ number_format($transaksi->bayar, 0, ',', '.') }}</strong></div>
                            <div class="info-row"><span>Kembalian</span><strong>Rp
                                    {{ number_format($transaksi->kembalian, 0, ',', '.') }}</strong></div>
                        </div>
                    </div>

                    <table class="table-custom mb-3">
                        <thead>
                            <tr>
                                <th>Spare Part</th>
                                <th>Qty</th>
                                <th>Harga Satuan</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksi->details as $d)
                                <tr>
                                    <td>{{ $d->sparePart->nama ?? '-' }}</td>
                                    <td>{{ $d->qty }}</td>
                                    <td>Rp {{ number_format($d->harga_satuan, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center" style="color:var(--muted)">Tidak ada spare part.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="info-row"><span>Biaya Jasa</span><strong>Rp
                            {{ number_format($transaksi->total_jasa, 0, ',', '.') }}</strong></div>
                    <div class="info-row"><span>Total Parts</span><strong>Rp
                            {{ number_format($transaksi->total_parts, 0, ',', '.') }}</strong></div>
                    <div class="info-row">
                        <span style="color:var(--primary); font-weight:700; font-size:1rem">Total Bayar</span>
                        <strong style="color:var(--primary); font-size:1.2rem">Rp
                            {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</strong>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <a href="{{ route('owner.transaksi.print', $transaksi) }}" target="_blank" class="btn-add">
                <i class="bi bi-printer"></i> Print Struk
            </a>
            <a href="{{ route('owner.transaksi.index') }}" class="btn-back ms-2">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
@endsection