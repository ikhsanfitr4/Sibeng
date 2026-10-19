@extends('layouts.admin')
@section('title', 'Data Pelanggan')
@section('page-title', 'Data Pelanggan')
@section('page-subtitle', 'Daftar semua pelanggan bengkel')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div></div>
        <a href="{{ route('admin.pelanggan.create') }}" class="btn-add">
            <i class="bi bi-plus-lg"></i> Tambah Pelanggan
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success-custom mb-3"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
    @endif

    {{-- Search --}}
    <div class="panel mb-3">
        <div class="panel-body">
            <form method="GET" action="{{ route('admin.pelanggan.index') }}" class="row g-2 align-items-end">
                <div class="col-md-8">
                    <label class="form-label-custom">Cari Pelanggan</label>
                    <div style="position:relative">
                        <i class="bi bi-search"
                            style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--muted)"></i>
                        <input type="text" name="search" class="input-custom" style="padding-left:32px"
                            placeholder="Nama, telepon, atau email..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn-add w-100">
                        <i class="bi bi-search"></i> Cari
                    </button>
                    @if(request()->filled('search'))
                        <a href="{{ route('admin.pelanggan.index') }}" class="btn-back" title="Reset">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <h5><i class="bi bi-people me-2" style="color:var(--primary)"></i>Daftar Pelanggan</h5>
            <span style="font-size:.78rem;color:var(--muted)">{{ $pelanggans->total() }} data</span>
        </div>
        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Telepon</th>
                        <th>Email</th>
                        <th>Kendaraan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggans as $p)
                        <tr>
                            <td>{{ $pelanggans->firstItem() + $loop->index }}</td>
                            <td><strong>{{ $p->nama }}</strong></td>
                            <td>{{ $p->telepon ?? '-' }}</td>
                            <td>{{ $p->email ?? '-' }}</td>
                            <td><span class="badge-status badge-proses">{{ $p->kendaraans_count }} kendaraan</span></td>
                            <td>
                                <a href="{{ route('admin.pelanggan.show', $p) }}" class="btn-icon btn-view"><i
                                        class="bi bi-eye"></i></a>
                                <a href="{{ route('admin.pelanggan.edit', $p) }}" class="btn-icon btn-edit"><i
                                        class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.pelanggan.destroy', $p) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus pelanggan ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn-icon btn-del"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center" style="color:var(--muted);padding:2rem">
                                @if(request()->filled('search'))
                                    Tidak ditemukan pelanggan dengan kata "<strong>{{ request('search') }}</strong>".
                                    <a href="{{ route('admin.pelanggan.index') }}" style="color:var(--primary)">Reset</a>
                                @else
                                    Belum ada data pelanggan.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $pelanggans->links() }}</div>
    </div>
@endsection

