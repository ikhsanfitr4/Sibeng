@extends('layouts.app')
@section('title', 'Kelola Mekanik')
@section('page-title', 'Kelola Mekanik')
@section('page-subtitle', 'Daftar semua mekanik bengkel')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div></div>
        <a href="{{ route('owner.mekanik.create') }}" class="btn-add">
            <i class="bi bi-plus-lg"></i> Tambah Mekanik
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success-custom mb-3">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="panel">
        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mekaniks as $m)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $m->nama }}</strong></td>
                            <td>{{ $m->telepon ?? '-' }}</td>
                            <td>{{ $m->alamat ?? '-' }}</td>
                            <td>
                                <span class="badge-status {{ $m->status === 'aktif' ? 'badge-selesai' : 'badge-batal' }}">
                                    {{ ucfirst($m->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('owner.mekanik.edit', $m) }}" class="btn-icon btn-edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('owner.mekanik.destroy', $m) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus mekanik ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn-icon btn-del"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center" style="color:var(--muted)">Belum ada data mekanik.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $mekaniks->links() }}</div>
    </div>
@endsection