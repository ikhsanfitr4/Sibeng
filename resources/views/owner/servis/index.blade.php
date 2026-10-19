@extends('layouts.app')
@section('title', 'Data Servis')
@section('page-title', 'Data Servis')
@section('page-subtitle', 'Kelola semua data servis bengkel')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div></div>
        <a href="{{ route('owner.servis.create') }}" class="btn-add">
            <i class="bi bi-plus-lg"></i> Tambah Servis
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success-custom mb-3">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    {{-- Search & Filter --}}
    <div class="panel mb-3">
        <div class="panel-body">
            <form method="GET" action="{{ route('owner.servis.index') }}" class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="form-label-custom">Cari</label>
                    <div style="position:relative">
                        <i class="bi bi-search"
                            style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--muted)"></i>
                        <input type="text" name="search" class="input-custom" style="padding-left:32px"
                            placeholder="No order, pelanggan, plat, mekanik..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label-custom">Status</label>
                    <select name="status" class="input-custom">
                        <option value="">Semua</option>
                        <option value="antrian" {{ request('status') == 'antrian' ? 'selected' : '' }}>Antrian</option>
                        <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="batal" {{ request('status') == 'batal' ? 'selected' : '' }}>Batal</option>
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
                    @if(request()->anyFilled(['search', 'status', 'dari', 'sampai']))
                        <a href="{{ route('owner.servis.index') }}" class="btn-back" title="Reset">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <h5><i class="bi bi-wrench-adjustable me-2" style="color:var(--primary)"></i>Daftar Servis</h5>
            <span style="font-size:.78rem;color:var(--muted)">
                {{ $servis->total() }} data ditemukan
            </span>
        </div>
        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>No Order</th>
                        <th>Pelanggan</th>
                        <th>Kendaraan</th>
                        <th>Mekanik</th>
                        <th>Tgl Masuk</th>
                        <th>Biaya Jasa</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($servis as $s)
                        <tr>
                            <td><code style="color:var(--primary)">{{ $s->no_order }}</code></td>
                            <td>{{ $s->pelanggan->nama ?? '-' }}</td>
                            <td>{{ $s->kendaraan->plat_nomor ?? '-' }}</td>
                            <td>{{ $s->mekanik->nama ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($s->tanggal_masuk)->format('d/m/Y') }}</td>
                            <td>Rp {{ number_format($s->biaya_jasa, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge-status badge-{{ $s->status }}">
                                    {{ ucfirst($s->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('owner.servis.show', $s) }}" class="btn-icon btn-view"><i
                                        class="bi bi-eye"></i></a>
                                <a href="{{ route('owner.servis.edit', $s) }}" class="btn-icon btn-edit"><i
                                        class="bi bi-pencil"></i></a>
                                <form action="{{ route('owner.servis.destroy', $s) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus data servis ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn-icon btn-del"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center" style="color:var(--muted);padding:2rem">
                                @if(request()->anyFilled(['search', 'status', 'dari', 'sampai']))
                                    Tidak ada data yang cocok dengan filter.
                                    <a href="{{ route('owner.servis.index') }}" style="color:var(--primary)">Reset filter</a>
                                @else
                                    Belum ada data servis.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $servis->links() }}</div>
    </div>
@endsection