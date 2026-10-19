@extends('layouts.app')

@section('title', 'Dashboard Owner')
@section('page-title', 'Dashboard')@section('page-subtitle', 'Selamat datang, ' . Auth::user()->name . ' 👋')@push('styles')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

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
            <a href="{{ route('owner.spare-part.index') }}?stok=menipis" style="
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

    {{-- ── Stat Cards ── --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon orange"><i class="bi bi-currency-dollar"></i></div>
                <div class="stat-value">
                    Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}
                </div>
                <div class="stat-label">Pendapatan Bulan Ini</div>
                <div class="stat-trend {{ $persenPendapatan >= 0 ? 'up' : 'down' }}">
                    <i class="bi bi-arrow-{{ $persenPendapatan >= 0 ? 'up' : 'down' }}-short"></i>
                    {{ abs($persenPendapatan) }}% vs bulan lalu
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon blue"><i class="bi bi-wrench-adjustable"></i></div>
                <div class="stat-value">{{ $totalServis }}</div>
                <div class="stat-label">Total Servis</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon green"><i class="bi bi-people"></i></div>
                <div class="stat-value">{{ $totalPelanggan }}</div>
                <div class="stat-label">Total Pelanggan</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon purple"><i class="bi bi-hourglass-split"></i></div>
                <div class="stat-value">{{ $antrianHariIni }}</div>
                <div class="stat-label">Antrian Hari Ini</div>
            </div>
        </div>
    </div>

    {{-- ── Row 2: Chart + Antrian ── --}}
    <div class="row g-3 mb-3">
        {{-- Chart --}}
        <div class="col-lg-8">
            <div class="panel h-100">
                <div class="panel-header">
                    <h5><i class="bi bi-bar-chart me-2" style="color:var(--primary)"></i>Pendapatan 6 Bulan Terakhir</h5>
                </div>
                <div class="panel-body">
                    <canvas id="chartPendapatan" height="110"></canvas>
                </div>
            </div>
        </div>

        {{-- Antrian Hari Ini --}}
        <div class="col-lg-4">
            <div class="panel h-100">
                <div class="panel-header">
                    <h5><i class="bi bi-list-ol me-2" style="color:var(--primary)"></i>Antrian Hari Ini</h5>
                    <span style="font-size:.75rem; color:var(--muted)">{{ today()->format('d/m/Y') }}</span>
                </div>
                <div style="overflow-y:auto; max-height:280px">
                    @forelse($antrianAktif as $i => $a)
                        <div
                            style="display:flex; align-items:center; gap:.75rem; padding:.75rem 1.25rem; border-bottom:1px solid var(--border)">
                            <div
                                style="width:28px;height:28px;border-radius:50%;background:rgba(232,93,4,.12);color:var(--primary);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.78rem;flex-shrink:0">
                                {{ $i + 1 }}
                            </div>
                            <div style="flex:1; min-width:0">
                                <div
                                    style="font-size:.83rem;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                                    {{ $a->pelanggan->nama ?? '-' }}
                                </div>
                                <div style="font-size:.72rem;color:var(--muted)">
                                    {{ $a->kendaraan->plat_nomor ?? '-' }} · {{ $a->mekanik->nama ?? '-' }}
                                </div>
                            </div>
                            <span class="badge-status badge-{{ $a->status }}">{{ ucfirst($a->status) }}</span>
                        </div>
                    @empty
                        <div style="padding:2rem;text-align:center;color:var(--muted);font-size:.85rem">
                            <i class="bi bi-check-circle"
                                style="font-size:1.5rem;display:block;margin-bottom:.5rem;color:#22c55e"></i>
                            Tidak ada antrian hari ini
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- ── Row 3: Servis Terbaru + Stok Menipis ── --}}
    <div class="row g-3">
        {{-- Servis Terbaru --}}
        <div class="col-lg-8">
            <div class="panel">
                <div class="panel-header">
                    <h5><i class="bi bi-clock-history me-2" style="color:var(--primary)"></i>Servis Terbaru</h5>
                    <a href="{{ route('owner.servis.index') }}"
                        style="font-size:.8rem;color:var(--primary);text-decoration:none">
                        Lihat semua →
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th>No Order</th>
                                <th>Pelanggan</th>
                                <th>Kendaraan</th>
                                <th>Mekanik</th>
                                <th>Biaya Jasa</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($servisTerbaru as $s)
                                <tr>
                                    <td>
                                        <a href="{{ route('owner.servis.show', $s) }}"
                                            style="color:var(--primary);text-decoration:none;font-weight:600;font-size:.82rem">
                                            {{ $s->no_order }}
                                        </a>
                                    </td>
                                    <td>{{ $s->pelanggan->nama ?? '-' }}</td>
                                    <td style="color:var(--muted)">{{ $s->kendaraan->plat_nomor ?? '-' }}</td>
                                    <td>{{ $s->mekanik->nama ?? '-' }}</td>
                                    <td>Rp {{ number_format($s->biaya_jasa, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge-status badge-{{ $s->status }}">
                                            {{ ucfirst($s->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align:center;color:var(--muted);padding:2rem">
                                        Belum ada data servis.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Stok Menipis + Transaksi Terbaru --}}
        <div class="col-lg-4">
            {{-- Stok Menipis --}}
            <div class="panel mb-3">
                <div class="panel-header">
                    <h5><i class="bi bi-exclamation-triangle me-2" style="color:#ef4444"></i>Stok Menipis</h5>
                    <a href="{{ route('owner.spare-part.index') }}"
                        style="font-size:.8rem;color:var(--primary);text-decoration:none">
                        Kelola →
                    </a>
                </div>
                @forelse($stokMenipis as $sp)
                    <div
                        style="display:flex;align-items:center;justify-content:space-between;padding:.7rem 1.25rem;border-bottom:1px solid var(--border);font-size:.82rem">
                        <div>
                            <div style="font-weight:600">{{ $sp->nama }}</div>
                            <div style="color:var(--muted);font-size:.72rem">{{ $sp->kode }}</div>
                        </div>
                        <span class="badge-status badge-batal">Stok: {{ $sp->stok }}</span>
                    </div>
                @empty
                    <div style="padding:1.5rem;text-align:center;color:var(--muted);font-size:.82rem">
                        <i class="bi bi-check-circle" style="color:#22c55e"></i> Semua stok aman
                    </div>
                @endforelse
            </div>

            {{-- Transaksi Terbaru --}}
            <div class="panel">
                <div class="panel-header">
                    <h5><i class="bi bi-receipt me-2" style="color:var(--primary)"></i>Transaksi Terbaru</h5>
                    <a href="{{ route('owner.transaksi.index') }}"
                        style="font-size:.8rem;color:var(--primary);text-decoration:none">
                        Semua →
                    </a>
                </div>
                @forelse($transaksiTerbaru as $t)
                    <div style="padding:.7rem 1.25rem;border-bottom:1px solid var(--border);font-size:.82rem">
                        <div style="display:flex;justify-content:space-between;margin-bottom:.2rem">
                            <code style="color:var(--primary)">{{ $t->no_transaksi }}</code>
                            <strong style="color:#22c55e">Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</strong>
                        </div>
                        <div style="color:var(--muted)">
                            {{ $t->servis->pelanggan->nama ?? '-' }} ·
                            {{ $t->servis->kendaraan->plat_nomor ?? '-' }}
                        </div>
                    </div>
                @empty
                    <div style="padding:1.5rem;text-align:center;color:var(--muted);font-size:.82rem">
                        Belum ada transaksi.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        new Chart(document.getElementById('chartPendapatan').getContext('2d'), {
            type: 'bar',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: @json($chartData),
                    backgroundColor: 'rgba(232,93,4,.7)',
                    borderColor: '#E85D04',
                    borderWidth: 1,
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { labels: { color: '#888' } } },
                scales: {
                    x: { ticks: { color: '#888' }, grid: { color: '#2a2a2a' } },
                    y: {
                        ticks: {
                            color: '#888',
                            callback: val => 'Rp ' + val.toLocaleString('id-ID')
                        },
                        grid: { color: '#2a2a2a' }
                    }
                }
            }
        });
    </script>
@endpush