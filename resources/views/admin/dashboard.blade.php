@extends('layouts.admin')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang, ' . Auth::user()->name . ' 👋')

@section('content')

    @if(\App\Models\SparePart::whereColumn('stok', '<=', 'stok_minimum')->exists())
        <div style="
            background:rgba(239,68,68,.1);
            border:1px solid rgba(239,68,68,.3);
            border-radius:12px;
            padding:.85rem 1.1rem;
            margin-bottom:1.25rem;
            display:flex;align-items:center;gap:.75rem;
            font-size:.85rem;
        ">
            <i class="bi bi-exclamation-triangle-fill" style="color:#ef4444;font-size:1.1rem;flex-shrink:0"></i>
            <div style="flex:1">
                <strong style="color:#ef4444">Perhatian!</strong>
                <span style="color:var(--muted);margin-left:.5rem">
                    Terdapat <strong
                        style="color:#ef4444">{{ \App\Models\SparePart::whereColumn('stok', '<=', 'stok_minimum')->count() }}</strong>
                    spare part dengan stok menipis.
                </span>
            </div>
            <a href="{{ route('admin.spare-part.index') }}?stok=menipis" style="
                    background:#ef4444;color:#fff;
                    font-size:.75rem;font-weight:700;
                    padding:.35rem .85rem;border-radius:8px;
                    text-decoration:none;white-space:nowrap;
                    flex-shrink:0;
                ">
                Lihat Sekarang
            </a>
        </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon yellow"><i class="bi bi-hourglass-split"></i></div>
                <div class="stat-value">{{ $antrianHariIni }}</div>
                <div class="stat-label">Antrian Hari Ini</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon green"><i class="bi bi-check-circle"></i></div>
                <div class="stat-value">{{ $servisSelesai }}</div>
                <div class="stat-label">Selesai Bulan Ini</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon blue"><i class="bi bi-box-seam"></i></div>
                <div class="stat-value">{{ $totalSparePart }}</div>
                <div class="stat-label">Item Spare Part</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon blue"><i class="bi bi-wrench-adjustable"></i></div>
                <div class="stat-value">{{ $totalServis }}</div>
                <div class="stat-label">Total Servis Bulan Ini</div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        {{-- Antrian Aktif --}}
        <div class="col-lg-5">
            <div class="panel">
                <div class="panel-header">
                    <h5><i class="bi bi-list-ol me-2" style="color:var(--primary)"></i>Antrian & Proses</h5>
                    <a href="{{ route('admin.servis.index') }}"
                        style="font-size:.8rem;color:var(--primary);text-decoration:none">Semua →</a>
                </div>
                @forelse($antrianAktif as $i => $a)
                    <div
                        style="display:flex;align-items:center;gap:.75rem;padding:.75rem 1.25rem;border-bottom:1px solid var(--border)">
                        <div
                            style="width:28px;height:28px;border-radius:50%;background:rgba(14,165,233,.12);color:var(--primary);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.78rem;flex-shrink:0">
                            {{ $i + 1 }}
                        </div>
                        <div style="flex:1;min-width:0">
                            <div style="font-size:.83rem;font-weight:600">{{ $a->pelanggan->nama ?? '-' }}</div>
                            <div style="font-size:.72rem;color:var(--muted)">{{ $a->kendaraan->plat_nomor ?? '-' }} ·
                                {{ $a->mekanik->nama ?? '-' }}
                            </div>
                        </div>
                        <span class="badge-status badge-{{ $a->status }}">{{ ucfirst($a->status) }}</span>
                    </div>
                @empty
                    <div style="padding:2rem;text-align:center;color:var(--muted);font-size:.85rem">
                        Tidak ada antrian aktif
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Servis Terbaru --}}
        <div class="col-lg-7">
            <div class="panel mb-3">
                <div class="panel-header">
                    <h5><i class="bi bi-clock-history me-2" style="color:var(--primary)"></i>Servis Terbaru</h5>
                </div>
                <div class="table-responsive">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th>No Order</th>
                                <th>Pelanggan</th>
                                <th>Kendaraan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($servisTerbaru as $s)
                                <tr>
                                    <td><a href="{{ route('admin.servis.show', $s) }}"
                                            style="color:var(--primary);text-decoration:none;font-weight:600;font-size:.82rem">{{ $s->no_order }}</a>
                                    </td>
                                    <td>{{ $s->pelanggan->nama ?? '-' }}</td>
                                    <td style="color:var(--muted)">{{ $s->kendaraan->plat_nomor ?? '-' }}</td>
                                    <td><span class="badge-status badge-{{ $s->status }}">{{ ucfirst($s->status) }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="text-align:center;color:var(--muted);padding:2rem">Belum ada servis.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Stok Menipis --}}
            @if($stokMenipis->count() > 0)
                <div class="panel">
                    <div class="panel-header">
                        <h5><i class="bi bi-exclamation-triangle me-2" style="color:#ef4444"></i>Stok Menipis</h5>
                    </div>
                    @foreach($stokMenipis as $sp)
                        <div
                            style="display:flex;align-items:center;justify-content:space-between;padding:.7rem 1.25rem;border-bottom:1px solid var(--border);font-size:.82rem">
                            <div>
                                <div style="font-weight:600">{{ $sp->nama }}</div>
                                <div style="color:var(--muted);font-size:.72rem">{{ $sp->kode }}</div>
                            </div>
                            <span class="badge-status badge-batal">Stok: {{ $sp->stok }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

@endsection