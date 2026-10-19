@extends('layouts.admin')
@section('title', 'Detail Pelanggan')
@section('page-title', 'Detail Pelanggan')
@section('page-subtitle', $pelanggan->nama)

@section('content')

    @if(session('success'))
        <div class="alert-success-custom mb-3"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
    @endif

    <div class="row g-3">
        <div class="col-md-4">
            <div class="panel">
                <div class="panel-header">
                    <h5><i class="bi bi-person me-2" style="color:var(--primary)"></i>Info Pelanggan</h5>
                    <a href="{{ route('admin.pelanggan.edit', $pelanggan) }}" class="btn-icon btn-edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                </div>
                <div class="panel-body">
                    <div class="info-row"><span>Nama</span><strong>{{ $pelanggan->nama }}</strong></div>
                    <div class="info-row"><span>Telepon</span><strong>{{ $pelanggan->telepon ?? '-' }}</strong></div>
                    <div class="info-row"><span>Email</span><strong>{{ $pelanggan->email ?? '-' }}</strong></div>
                    <div class="info-row"><span>Alamat</span><strong>{{ $pelanggan->alamat ?? '-' }}</strong></div>
                    <div class="info-row"><span>Total Kendaraan</span><strong
                            style="color:var(--primary)">{{ $kendaraans->count() }}</strong></div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="panel mb-3">
                <div class="panel-header">
                    <h5><i class="bi bi-car-front me-2" style="color:var(--primary)"></i>Kendaraan</h5>
                    <a href="{{ route('admin.kendaraan.create', $pelanggan) }}" class="btn-add"
                        style="font-size:.78rem;padding:.4rem .8rem">
                        <i class="bi bi-plus-lg"></i> Tambah
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th>Merk & Model</th>
                                <th>Plat Nomor</th>
                                <th>Tahun</th>
                                <th>Warna</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kendaraans as $k)
                                <tr>
                                    <td><strong>{{ $k->merk }} {{ $k->model }}</strong></td>
                                    <td><code style="color:var(--primary)">{{ $k->plat_nomor }}</code></td>
                                    <td>{{ $k->tahun ?? '-' }}</td>
                                    <td>{{ $k->warna ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('admin.kendaraan.edit', [$pelanggan, $k]) }}"
                                            class="btn-icon btn-edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.kendaraan.destroy', [$pelanggan, $k]) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Hapus kendaraan ini?')">
                                            @csrf @method('DELETE')
                                            <button class="btn-icon btn-del"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center" style="color:var(--muted);padding:1.5rem">
                                        Belum ada kendaraan.
                                        <a href="{{ route('admin.kendaraan.create', $pelanggan) }}"
                                            style="color:var(--primary)">Tambah sekarang</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="panel">
                <div class="panel-header">
                    <h5><i class="bi bi-wrench me-2" style="color:var(--primary)"></i>Riwayat Servis</h5>
                </div>
                <div class="table-responsive">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th>No Order</th>
                                <th>Kendaraan</th>
                                <th>Mekanik</th>
                                <th>Tgl Masuk</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($servisHistory as $s)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.servis.show', $s) }}"
                                            style="color:var(--primary);text-decoration:none;font-weight:600">
                                            {{ $s->no_order }}
                                        </a>
                                    </td>
                                    <td>{{ $s->kendaraan->plat_nomor ?? '-' }}</td>
                                    <td>{{ $s->mekanik->nama ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($s->tanggal_masuk)->format('d/m/Y') }}</td>
                                    <td><span class="badge-status badge-{{ $s->status }}">{{ ucfirst($s->status) }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center" style="color:var(--muted);padding:1.5rem">Belum ada
                                        riwayat servis.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('admin.pelanggan.index') }}" class="btn-back">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
@endsection