@extends('layouts.admin')
@section('title', 'Detail Servis')
@section('page-title', 'Detail Servis')

@section('content')
    <div class="row g-3">
        <div class="col-md-5">
            <div class="panel mb-3">
                <div class="panel-header">
                    <h5><i class="bi bi-file-text me-2" style="color:var(--primary)"></i>Info Work Order</h5>
                    <span class="badge-status badge-{{ $servis->status }}">{{ ucfirst($servis->status) }}</span>
                </div>
                <div class="panel-body">
                    <div class="info-row"><span>No Order</span><strong>{{ $servis->no_order }}</strong></div>
                    <div class="info-row"><span>Tgl
                            Masuk</span><strong>{{ \Carbon\Carbon::parse($servis->tanggal_masuk)->format('d/m/Y') }}</strong>
                    </div>
                    <div class="info-row"><span>Tgl
                            Selesai</span><strong>{{ $servis->tanggal_selesai ? \Carbon\Carbon::parse($servis->tanggal_selesai)->format('d/m/Y') : '-' }}</strong>
                    </div>
                    <div class="info-row"><span>Mekanik</span><strong>{{ $servis->mekanik->nama ?? '-' }}</strong></div>
                    <div class="info-row"><span>Biaya Jasa</span><strong>Rp
                            {{ number_format($servis->biaya_jasa, 0, ',', '.') }}</strong></div>
                </div>
            </div>
            <div class="panel mb-3">
                <div class="panel-header">
                    <h5>Info Pelanggan & Kendaraan</h5>
                </div>
                <div class="panel-body">
                    <div class="info-row"><span>Pelanggan</span><strong>{{ $servis->pelanggan->nama ?? '-' }}</strong></div>
                    <div class="info-row"><span>Telepon</span><strong>{{ $servis->pelanggan->telepon ?? '-' }}</strong>
                    </div>
                    <div class="info-row"><span>Kendaraan</span><strong>{{ $servis->kendaraan->merk ?? '' }}
                            {{ $servis->kendaraan->model ?? '' }}</strong></div>
                    <div class="info-row"><span>Plat</span><strong>{{ $servis->kendaraan->plat_nomor ?? '-' }}</strong>
                    </div>
                </div>
            </div>
            <div class="panel">
                <div class="panel-header">
                    <h5>Keluhan & Diagnosa</h5>
                </div>
                <div class="panel-body" style="font-size:.85rem">
                    <p style="color:var(--muted);margin-bottom:.5rem">Keluhan:</p>
                    <p style="margin-bottom:1rem">{{ $servis->keluhan }}</p>
                    <p style="color:var(--muted);margin-bottom:.5rem">Diagnosa:</p>
                    <p style="margin:0">{{ $servis->diagnosa ?? '-' }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            @if($servis->transaksi)
                <div class="panel mb-3">
                    <div class="panel-header">
                        <h5><i class="bi bi-receipt me-2" style="color:var(--primary)"></i>Detail Transaksi</h5>
                        <span class="badge-status badge-lunas">{{ $servis->transaksi->no_transaksi }}</span>
                    </div>
                    <div class="panel-body">
                        <table class="table-custom mb-3">
                            <thead>
                                <tr>
                                    <th>Spare Part</th>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($servis->transaksi->details as $d)
                                    <tr>
                                        <td>{{ $d->sparePart->nama ?? '-' }}</td>
                                        <td>{{ $d->qty }}</td>
                                        <td>Rp {{ number_format($d->harga_satuan, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" style="text-align:center;color:var(--muted)">Tidak ada spare part.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="info-row"><span>Biaya Jasa</span><strong>Rp
                                {{ number_format($servis->transaksi->total_jasa, 0, ',', '.') }}</strong></div>
                        <div class="info-row"><span>Total Parts</span><strong>Rp
                                {{ number_format($servis->transaksi->total_parts, 0, ',', '.') }}</strong></div>
                        <div class="info-row">
                            <span style="color:var(--primary);font-weight:700">Total Bayar</span>
                            <strong style="color:var(--primary);font-size:1.1rem">Rp
                                {{ number_format($servis->transaksi->total_bayar, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                </div>
            @else
                <div class="panel mb-3">
                    <div class="panel-body text-center" style="padding:2rem;color:var(--muted)">
                        <i class="bi bi-receipt" style="font-size:2rem;display:block;margin-bottom:1rem"></i>
                        Belum ada transaksi untuk servis ini.
                        @if($servis->status === 'selesai')
                            <div class="mt-3">
                                <a href="{{ route('admin.transaksi.create') }}" class="btn-add">
                                    <i class="bi bi-plus-lg"></i> Buat Transaksi
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
            <div class="d-flex gap-2">
                <a href="{{ route('admin.servis.edit', $servis) }}" class="btn-add">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('admin.servis.index') }}" class="btn-back">Kembali</a>
            </div>
        </div>
    </div>
@endsection