@extends('layouts.app')
@section('title', 'Data Transaksi')
@section('page-title', 'Data Transaksi')
@section('page-subtitle', 'Riwayat semua transaksi pembayaran')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div></div>
        <a href="{{ route('owner.transaksi.create') }}" class="btn-add">
            <i class="bi bi-plus-lg"></i> Buat Transaksi
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success-custom mb-3"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
    @endif

    {{-- Search & Filter --}}
    <div class="panel mb-3">
        <div class="panel-body">
            <form method="GET" action="{{ route('owner.transaksi.index') }}" class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="form-label-custom">Cari</label>
                    <div style="position:relative">
                        <i class="bi bi-search"
                            style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--muted)"></i>
                        <input type="text" name="search" class="input-custom" style="padding-left:32px"
                            placeholder="No transaksi, order, pelanggan..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label-custom">Metode</label>
                    <select name="metode" class="input-custom">
                        <option value="">Semua</option>
                        <option value="tunai" {{ request('metode') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                        <option value="transfer" {{ request('metode') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                        <option value="qris" {{ request('metode') == 'qris' ? 'selected' : '' }}>QRIS</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label-custom">Dari</label>
                    <input type="date" name="dari" class="input-custom" value="{{ request('dari') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label-custom">Sampai</label>
                    <input type="date" name="sampai" class="input-custom" value="{{ request('sampai') }}">
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn-add w-100">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    @if(request()->anyFilled(['search', 'metode', 'dari', 'sampai']))
                        <a href="{{ route('owner.transaksi.index') }}" class="btn-back" title="Reset">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <h5><i class="bi bi-receipt me-2" style="color:var(--primary)"></i>Daftar Transaksi</h5>
            <span style="font-size:.78rem;color:var(--muted)">{{ $transaksis->total() }} data</span>
        </div>
        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>No Transaksi</th>
                        <th>No Order</th>
                        <th>Pelanggan</th>
                        <th>Kendaraan</th>
                        <th>Total Bayar</th>
                        <th>Metode</th>
                        <th>Tgl Bayar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $t)
                        <tr>
                            <td><code style="color:var(--primary)">{{ $t->no_transaksi }}</code></td>
                            <td><code style="color:var(--muted)">{{ $t->servis->no_order ?? '-' }}</code></td>
                            <td>{{ $t->servis->pelanggan->nama ?? '-' }}</td>
                            <td>{{ $t->servis->kendaraan->plat_nomor ?? '-' }}</td>
                            <td><strong>Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</strong></td>
                            <td>
                                <span
                                    class="badge-status badge-{{ $t->metode_bayar === 'tunai' ? 'antrian' : ($t->metode_bayar === 'transfer' ? 'proses' : 'selesai') }}">
                                    {{ ucfirst($t->metode_bayar) }}
                                </span>
                            </td>
                            <td>{{ $t->tanggal_bayar ? \Carbon\Carbon::parse($t->tanggal_bayar)->format('d/m/Y') : '-' }}</td>
                            <td>
                                <a href="{{ route('owner.transaksi.show', $t) }}" class="btn-icon btn-view"><i
                                        class="bi bi-eye"></i></a>
                                <a href="{{ route('owner.transaksi.print', $t) }}" target="_blank" class="btn-icon"
                                    style="border-color:var(--border)" title="Print">
                                    <i class="bi bi-printer"></i>
                                </a>
                                <form action="{{ route('owner.transaksi.destroy', $t) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus transaksi ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn-icon btn-del"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center" style="color:var(--muted);padding:2rem">
                                @if(request()->anyFilled(['search', 'metode', 'dari', 'sampai']))
                                    Tidak ada data yang cocok.
                                    <a href="{{ route('owner.transaksi.index') }}" style="color:var(--primary)">Reset filter</a>
                                @else
                                    Belum ada data transaksi.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $transaksis->links() }}</div>
    </div>
@endsection