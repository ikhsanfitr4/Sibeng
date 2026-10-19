@extends('layouts.app')
@section('title', 'Laporan')
@section('page-title', 'Laporan Bengkel')
@section('page-subtitle', 'Ringkasan data keuangan dan operasional')

@push('styles')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
    {{-- Filter --}}
    <div class="panel mb-4">
        <div class="panel-body">
            <form method="GET" action="{{ route('owner.laporan.index') }}" class="d-flex gap-3 align-items-end flex-wrap">
                <div class="form-group mb-0">
                    <label class="form-label-custom">Bulan</label>
                    <select name="bulan" class="input-custom" style="width:150px">
                        @foreach($namaBulans as $num => $nama)
                            <option value="{{ $num }}" {{ $bulan == $num ? 'selected' : '' }}>
                                {{ $nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-0">
                    <label class="form-label-custom">Tahun</label>
                    <select name="tahun" class="input-custom" style="width:120px">
                        @foreach(range(date('Y'), date('Y') - 3) as $y)
                            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn-add">
                    <i class="bi bi-funnel"></i> Filter
                </button>
                <a href="{{ route('owner.laporan.export-pdf') }}?bulan={{ $bulan }}&tahun={{ $tahun }}" class="btn-add"
                    style="background:linear-gradient(135deg,#dc2626,#ef4444)">
                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                </a>
            </form>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="stat-card"
                style="background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:1.4rem">
                <div
                    style="width:40px;height:40px;border-radius:10px;background:rgba(232,93,4,.15);color:#E85D04;display:flex;align-items:center;justify-content:center;font-size:1.1rem;margin-bottom:.9rem">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <div style="font-size:1.5rem;font-weight:800;line-height:1;margin-bottom:.3rem">
                    Rp {{ number_format($pendapatan, 0, ',', '.') }}
                </div>
                <div style="font-size:.8rem;color:var(--muted)">Total Pendapatan</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card"
                style="background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:1.4rem">
                <div
                    style="width:40px;height:40px;border-radius:10px;background:rgba(14,165,233,.15);color:#0ea5e9;display:flex;align-items:center;justify-content:center;font-size:1.1rem;margin-bottom:.9rem">
                    <i class="bi bi-wrench-adjustable"></i>
                </div>
                <div style="font-size:1.5rem;font-weight:800;line-height:1;margin-bottom:.3rem">{{ $totalServis }}</div>
                <div style="font-size:.8rem;color:var(--muted)">Total Servis</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card"
                style="background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:1.4rem">
                <div
                    style="width:40px;height:40px;border-radius:10px;background:rgba(34,197,94,.15);color:#22c55e;display:flex;align-items:center;justify-content:center;font-size:1.1rem;margin-bottom:.9rem">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div style="font-size:1.5rem;font-weight:800;line-height:1;margin-bottom:.3rem">{{ $servisSelesai }}</div>
                <div style="font-size:.8rem;color:var(--muted)">Servis Selesai</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card"
                style="background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:1.4rem">
                <div
                    style="width:40px;height:40px;border-radius:10px;background:rgba(239,68,68,.15);color:#ef4444;display:flex;align-items:center;justify-content:center;font-size:1.1rem;margin-bottom:.9rem">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div style="font-size:1.5rem;font-weight:800;line-height:1;margin-bottom:.3rem">{{ $stokMenipis }}</div>
                <div style="font-size:.8rem;color:var(--muted)">Stok Menipis</div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        {{-- Chart --}}
        <div class="col-lg-8">
            <div class="panel">
                <div class="panel-header">
                    <h5><i class="bi bi-bar-chart me-2" style="color:var(--primary)"></i>Pendapatan Per Bulan {{ $tahun }}
                    </h5>
                </div>
                <div class="panel-body">
                    <canvas id="chartPendapatan" height="100"></canvas>
                </div>
            </div>
        </div>

        {{-- Transaksi Terbaru --}}
        <div class="col-lg-4">
            <div class="panel">
                <div class="panel-header">
                    <h5>Transaksi Terbaru</h5>
                </div>
                <div style="overflow-y:auto; max-height:300px">
                    @forelse($transaksiTerbaru as $t)
                        <div style="padding:.75rem 1.25rem; border-bottom:1px solid var(--border); font-size:.82rem">
                            <div style="display:flex; justify-content:space-between; margin-bottom:.2rem">
                                <code style="color:var(--primary)">{{ $t->no_transaksi }}</code>
                                <span style="color:#22c55e; font-weight:700">Rp
                                    {{ number_format($t->total_bayar, 0, ',', '.') }}</span>
                            </div>
                            <div style="color:var(--muted)">{{ $t->servis->pelanggan->nama ?? '-' }} —
                                {{ $t->servis->kendaraan->plat_nomor ?? '-' }}
                            </div>
                        </div>
                    @empty
                        <div style="padding:2rem; text-align:center; color:var(--muted)">Belum ada transaksi bulan ini.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const ctx = document.getElementById('chartPendapatan').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
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
                plugins: {
                    legend: { labels: { color: '#888' } }
                },
                scales: {
                    x: { ticks: { color: '#888' }, grid: { color: '#2a2a2a' } },
                    y: { ticks: { color: '#888' }, grid: { color: '#2a2a2a' } }
                }
            }
        });
    </script>
@endpush