@extends('layouts.admin')
@section('title', 'Data Mekanik')
@section('page-title', 'Data Mekanik')
@section('page-subtitle', 'Daftar mekanik bengkel')

@section('content')

    {{-- Search & Filter --}}
    <div class="panel mb-3">
        <div class="panel-body">
            <form method="GET" action="{{ route('admin.mekanik.index') }}" class="row g-2 align-items-end">
                <div class="col-md-6">
                    <label class="form-label-custom">Cari Mekanik</label>
                    <div style="position:relative">
                        <i class="bi bi-search"
                            style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--muted)"></i>
                        <input type="text" name="search" class="input-custom" style="padding-left:32px"
                            placeholder="Nama atau telepon..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label-custom">Status</label>
                    <select name="status" class="input-custom">
                        <option value="">Semua</option>
                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Non Aktif</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn-add w-100">
                        <i class="bi bi-search"></i> Cari
                    </button>
                    @if(request()->anyFilled(['search', 'status']))
                        <a href="{{ route('admin.mekanik.index') }}" class="btn-back" title="Reset">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Info View Only --}}
    <div style="
        background:rgba(14,165,233,.08);
        border:1px solid rgba(14,165,233,.2);
        border-radius:10px;
        padding:.75rem 1rem;
        margin-bottom:1rem;
        display:flex;align-items:center;gap:.75rem;
        font-size:.82rem;color:var(--muted);
    ">
        <i class="bi bi-info-circle" style="color:#0ea5e9;font-size:1rem;flex-shrink:0"></i>
        Halaman ini hanya untuk melihat data mekanik. Untuk mengelola mekanik, hubungi Owner.
    </div>

    <div class="panel">
        <div class="panel-header">
            <h5><i class="bi bi-people me-2" style="color:var(--primary)"></i>Daftar Mekanik</h5>
            <span style="font-size:.78rem;color:var(--muted)">{{ $mekaniks->total() }} data</span>
        </div>
        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th>Total Servis</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mekaniks as $m)
                        <tr>
                            <td>{{ $mekaniks->firstItem() + $loop->index }}</td>
                            <td>
                                <div style="display:flex;align-items:center;gap:.6rem">
                                    <div style="
                                        width:32px;height:32px;border-radius:50%;
                                        background:linear-gradient(135deg,var(--primary),#FF8C42);
                                        display:flex;align-items:center;justify-content:center;
                                        font-weight:700;font-size:.8rem;color:#fff;flex-shrink:0;
                                    ">
                                        {{ strtoupper(substr($m->nama, 0, 1)) }}
                                    </div>
                                    <strong>{{ $m->nama }}</strong>
                                </div>
                            </td>
                            <td>{{ $m->telepon ?? '-' }}</td>
                            <td style="color:var(--muted);max-width:200px">
                                {{ $m->alamat ?? '-' }}
                            </td>
                            <td>
                                <span class="badge-status badge-proses">
                                    {{ $m->servis->count() }} servis
                                </span>
                            </td>
                            <td>
                                <span class="badge-status {{ $m->status === 'aktif' ? 'badge-selesai' : 'badge-batal' }}">
                                    {{ ucfirst($m->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center" style="color:var(--muted);padding:2rem">
                                @if(request()->anyFilled(['search', 'status']))
                                    Tidak ditemukan mekanik yang cocok.
                                    <a href="{{ route('admin.mekanik.index') }}" style="color:var(--primary)">Reset</a>
                                @else
                                    Belum ada data mekanik.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $mekaniks->links() }}</div>
    </div>
@endsection