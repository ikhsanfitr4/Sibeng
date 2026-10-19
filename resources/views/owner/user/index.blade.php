@extends('layouts.app')
@section('title', 'Kelola Admin')
@section('page-title', 'Kelola Admin')
@section('page-subtitle', 'Manajemen akun admin bengkel')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div></div>
        <a href="{{ route('owner.user.create') }}" class="btn-add">
            <i class="bi bi-plus-lg"></i> Tambah Admin
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success-custom mb-3">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    {{-- Search --}}
    <div class="panel mb-3">
        <div class="panel-body">
            <form method="GET" action="{{ route('owner.user.index') }}" class="row g-2 align-items-end">
                <div class="col-md-8">
                    <label class="form-label-custom">Cari Admin</label>
                    <div style="position:relative">
                        <i class="bi bi-search"
                            style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--muted)"></i>
                        <input type="text" name="search" class="input-custom" style="padding-left:32px"
                            placeholder="Nama atau email admin..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn-add w-100">
                        <i class="bi bi-search"></i> Cari
                    </button>
                    @if(request()->filled('search'))
                        <a href="{{ route('owner.user.index') }}" class="btn-back" title="Reset">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <h5><i class="bi bi-people me-2" style="color:var(--primary)"></i>Daftar Akun Admin</h5>
            <span style="font-size:.78rem;color:var(--muted)">{{ $users->total() }} akun</span>
        </div>
        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $u)
                        <tr>
                            <td>{{ $users->firstItem() + $loop->index }}</td>
                            <td>
                                <div style="display:flex;align-items:center;gap:.6rem">
                                    <div style="
                                        width:34px;height:34px;border-radius:50%;
                                        background:linear-gradient(135deg,#0ea5e9,#38bdf8);
                                        display:flex;align-items:center;justify-content:center;
                                        font-weight:700;font-size:.85rem;color:#fff;flex-shrink:0;
                                    ">
                                        {{ strtoupper(substr($u->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight:600;font-size:.875rem">{{ $u->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="color:var(--muted)">{{ $u->email }}</td>
                            <td>
                                <span class="badge-status badge-proses">
                                    <i class="bi bi-person-badge me-1"></i>Admin
                                </span>
                            </td>
                            <td style="color:var(--muted);font-size:.8rem">
                                {{ \Carbon\Carbon::parse($u->created_at)->format('d/m/Y') }}
                            </td>
                            <td>
                                <a href="{{ route('owner.user.edit', $u) }}" class="btn-icon btn-edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('owner.user.destroy', $u) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus akun admin {{ $u->name }}?')">
                                    @csrf @method('DELETE')
                                    <button class="btn-icon btn-del"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center" style="color:var(--muted);padding:2rem">
                                @if(request()->filled('search'))
                                    Tidak ditemukan admin dengan kata "<strong>{{ request('search') }}</strong>".
                                    <a href="{{ route('owner.user.index') }}" style="color:var(--primary)">Reset</a>
                                @else
                                    Belum ada akun admin. <a href="{{ route('owner.user.create') }}"
                                        style="color:var(--primary)">Tambah sekarang</a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $users->links() }}</div>
    </div>
@endsection