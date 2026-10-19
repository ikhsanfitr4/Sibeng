@extends('layouts.app')
@section('title', 'Backup Database')
@section('page-title', 'Backup Database')
@section('page-subtitle', 'Kelola backup database bengkel')

@section('content')

    @if(session('success'))
        <div class="alert-success-custom mb-3">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert-danger-custom mb-3">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
        </div>
    @endif

    {{-- Info Card --}}
    <div class="row g-3 mb-4">
        <div class="col-md-8">
            <div class="panel h-100">
                <div class="panel-header">
                    <h5><i class="bi bi-shield-check me-2" style="color:var(--primary)"></i>Backup Database</h5>
                </div>
                <div class="panel-body">
                    <p style="color:var(--muted);font-size:.875rem;margin-bottom:1.25rem;line-height:1.7">
                        Fitur backup akan membuat salinan database bengkel dalam format <strong
                            style="color:var(--text)">.zip</strong>.
                        File backup disimpan di server dan bisa didownload kapan saja.
                        Lakukan backup secara rutin untuk menghindari kehilangan data.
                    </p>

                    <div style="display:flex;gap:1rem;flex-wrap:wrap;margin-bottom:1.25rem">
                        <div
                            style="background:var(--surface-2);border:1px solid var(--border);border-radius:10px;padding:.75rem 1rem;font-size:.82rem;flex:1">
                            <div style="color:var(--muted);margin-bottom:.25rem">Total Backup</div>
                            <div style="font-size:1.4rem;font-weight:800;color:var(--primary)">{{ count($backups) }}</div>
                        </div>
                        <div
                            style="background:var(--surface-2);border:1px solid var(--border);border-radius:10px;padding:.75rem 1rem;font-size:.82rem;flex:1">
                            <div style="color:var(--muted);margin-bottom:.25rem">Backup Terakhir</div>
                            <div style="font-size:.9rem;font-weight:700;color:var(--text)">
                                {{ count($backups) > 0 ? $backups[0]['tanggal'] : 'Belum ada backup' }}
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('owner.backup.create') }}" method="POST" onsubmit="return konfirmasiBackup()">
                        @csrf
                        <button type="submit" class="btn-add" id="btnBackup">
                            <i class="bi bi-cloud-arrow-up me-1"></i> Buat Backup Sekarang
                        </button>
                    </form>

                    <div style="margin-top:.75rem;font-size:.78rem;color:var(--muted)">
                        <i class="bi bi-info-circle me-1"></i>
                        Proses backup mungkin membutuhkan beberapa detik. Harap tunggu hingga selesai.
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel h-100" style="background:rgba(232,93,4,.06);border-color:rgba(232,93,4,.2)">
                <div class="panel-header">
                    <h5><i class="bi bi-lightbulb me-2" style="color:var(--primary)"></i>Tips Backup</h5>
                </div>
                <div class="panel-body" style="font-size:.82rem;color:var(--muted);line-height:2">
                    <div>✅ Lakukan backup setiap hari</div>
                    <div>✅ Simpan backup di tempat aman</div>
                    <div>✅ Test restore backup secara berkala</div>
                    <div>⚠️ Jangan hapus backup terlalu lama</div>
                    <div>⚠️ Backup sebelum update sistem</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Daftar Backup --}}
    <div class="panel">
        <div class="panel-header">
            <h5><i class="bi bi-archive me-2" style="color:var(--primary)"></i>Riwayat Backup</h5>
            <span style="font-size:.78rem;color:var(--muted)">{{ count($backups) }} file</span>
        </div>

        @if(count($backups) > 0)
            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama File</th>
                            <th>Ukuran</th>
                            <th>Tanggal Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($backups as $i => $backup)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    <div style="display:flex;align-items:center;gap:.6rem">
                                        <div style="
                                            width:32px;height:32px;border-radius:8px;
                                            background:rgba(232,93,4,.12);
                                            display:flex;align-items:center;justify-content:center;
                                            font-size:1rem;flex-shrink:0;
                                        ">🗄️</div>
                                        <div>
                                            <div style="font-size:.82rem;font-weight:600;word-break:break-all">
                                                {{ $backup['nama'] }}
                                            </div>
                                            @if($i === 0)
                                                <span style="
                                                    background:rgba(34,197,94,.15);color:#22c55e;
                                                    font-size:.65rem;font-weight:700;
                                                    padding:.1rem .5rem;border-radius:10px;
                                                ">Terbaru</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge-status badge-antrian">{{ $backup['ukuran'] }}</span>
                                </td>
                                <td style="font-size:.82rem;color:var(--muted)">{{ $backup['tanggal'] }}</td>
                                <td>
                                    {{-- Download --}}
                                    <a href="{{ route('owner.backup.download') }}?file={{ $backup['nama'] }}"
                                        class="btn-icon btn-view" title="Download">
                                        <i class="bi bi-download"></i>
                                    </a>

                                    {{-- Hapus --}}
                                    <form action="{{ route('owner.backup.destroy') }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Hapus file backup ini?')">
                                        @csrf @method('DELETE')
                                        <input type="hidden" name="file" value="{{ $backup['nama'] }}">
                                        <button class="btn-icon btn-del" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="padding:3rem;text-align:center;color:var(--muted)">
                <i class="bi bi-archive" style="font-size:2.5rem;display:block;margin-bottom:1rem;opacity:.3"></i>
                <div style="font-size:.9rem;margin-bottom:.5rem">Belum ada file backup</div>
                <div style="font-size:.8rem">Klik tombol <strong>Buat Backup Sekarang</strong> untuk membuat backup pertama
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            function konfirmasiBackup() {
                const btn = document.getElementById('btnBackup');
                btn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Sedang membuat backup...';
                btn.disabled = true;
                return true;
            }
        </script>
    @endpush
@endsection