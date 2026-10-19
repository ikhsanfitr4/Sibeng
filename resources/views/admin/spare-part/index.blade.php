@extends('layouts.admin')
@section('title', 'Spare Part')
@section('page-title', 'Spare Part')
@section('page-subtitle', 'Kelola stok spare part bengkel')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div></div>
        <a href="{{ route('admin.spare-part.create') }}" class="btn-add">
            <i class="bi bi-plus-lg"></i> Tambah Part
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success-custom mb-3"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
    @endif

    {{-- Search & Filter --}}
    <div class="panel mb-3">
        <div class="panel-body">
            <form method="GET" action="{{ route('admin.spare-part.index') }}" class="row g-2 align-items-end">
                <div class="col-md-6">
                    <label class="form-label-custom">Cari</label>
                    <div style="position:relative">
                        <i class="bi bi-search"
                            style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--muted)"></i>
                        <input type="text" name="search" class="input-custom" style="padding-left:32px"
                            placeholder="Nama, kode, atau kategori..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label-custom">Kondisi Stok</label>
                    <select name="stok" class="input-custom">
                        <option value="">Semua</option>
                        <option value="menipis" {{ request('stok') == 'menipis' ? 'selected' : '' }}>⚠️ Stok Menipis</option>
                        <option value="aman" {{ request('stok') == 'aman' ? 'selected' : '' }}>✅ Stok Aman</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn-add w-100">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    @if(request()->anyFilled(['search', 'stok']))
                        <a href="{{ route('admin.spare-part.index') }}" class="btn-back" title="Reset">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <h5><i class="bi bi-box-seam me-2" style="color:var(--primary)"></i>Daftar Spare Part</h5>
            <span style="font-size:.78rem;color:var(--muted)">{{ $spareParts->total() }} data</span>
        </div>
        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Harga Jual</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($spareParts as $sp)
                        <tr>
                            <td>{{ $spareParts->firstItem() + $loop->index }}</td>
                            <td><code style="color:var(--primary)">{{ $sp->kode }}</code></td>
                            <td><strong>{{ $sp->nama }}</strong></td>
                            <td>{{ $sp->kategori ?? '-' }}</td>
                            <td>
                                <span
                                    class="badge-status {{ $sp->stok <= $sp->stok_minimum ? 'badge-batal' : 'badge-selesai' }}">
                                    {{ $sp->stok }}
                                    @if($sp->stok <= $sp->stok_minimum)
                                        ⚠️
                                    @endif
                                </span>
                            </td>
                            <td>Rp {{ number_format($sp->harga_jual, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('admin.spare-part.edit', $sp) }}" class="btn-icon btn-edit"><i
                                        class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.spare-part.destroy', $sp) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus spare part ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn-icon btn-del"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center" style="color:var(--muted);padding:2rem">
                                @if(request()->anyFilled(['search', 'stok']))
                                    Tidak ada data yang cocok.
                                    <a href="{{ route('admin.spare-part.index') }}" style="color:var(--primary)">Reset filter</a>
                                @else
                                    Belum ada data spare part.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $spareParts->links() }}</div>
    </div>
@endsection