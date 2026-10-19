@extends('layouts.admin')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')
@section('page-subtitle', 'Kelola informasi akun dan keamanan')

@section('content')

    @if(session('success'))
        <div class="alert-success-custom mb-4">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="row g-4">

        {{-- Kartu Info User --}}
        <div class="col-12 col-md-4">
            <div class="panel h-100">
                <div class="panel-body text-center" style="padding:2rem 1.5rem">
                    <div style="
                        width:72px;height:72px;border-radius:50%;
                        background:linear-gradient(135deg,var(--primary),#38bdf8);
                        display:flex;align-items:center;justify-content:center;
                        font-size:2rem;font-weight:800;margin:0 auto 1rem;
                    ">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                    <div style="font-size:1.1rem;font-weight:700">{{ $user->name }}</div>
                    <div style="font-size:.8rem;color:var(--muted);margin-top:.25rem">{{ $user->email }}</div>
                    <div style="margin-top:.75rem">
                        <span class="badge-status badge-proses">{{ ucfirst($user->role) }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tab Form --}}
        <div class="col-12 col-md-8">
            <div class="panel">
                <div class="panel-header" style="gap:.5rem">
                    <div style="display:flex;gap:.5rem">
                        <button onclick="switchTab('profil')" id="tab-profil" class="btn-add"
                            style="font-size:.8rem;padding:.4rem .9rem">
                            <i class="bi bi-person"></i> Profil
                        </button>
                        <button onclick="switchTab('password')" id="tab-password"
                            style="font-size:.8rem;padding:.4rem .9rem;background:var(--surface-2);border:1px solid var(--border);color:var(--muted);border-radius:10px;cursor:pointer;font-weight:700;display:inline-flex;align-items:center;gap:.4rem;transition:all .2s">
                            <i class="bi bi-shield-lock"></i> Password
                        </button>
                    </div>
                </div>

                {{-- Form Profil --}}
                <div id="pane-profil" class="panel-body">
                    <form action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label class="form-label-custom">Nama Lengkap</label>
                            <input type="text" name="name" class="input-custom @error('name') is-invalid @enderror"
                                value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div style="font-size:.75rem;color:#ef4444;margin-top:.3rem">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label-custom">Email</label>
                            <input type="email" name="email" class="input-custom @error('email') is-invalid @enderror"
                                value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div style="font-size:.75rem;color:#ef4444;margin-top:.3rem">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label-custom">Role</label>
                            <input type="text" class="input-custom" value="{{ ucfirst($user->role) }}" disabled>
                        </div>

                        <div style="display:flex;justify-content:flex-end;margin-top:1.25rem">
                            <button type="submit" class="btn-add">
                                <i class="bi bi-check-lg"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Form Password --}}
                <div id="pane-password" class="panel-body" style="display:none">
                    <form action="{{ route('admin.profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label class="form-label-custom">Password Saat Ini</label>
                            <input type="password" name="current_password"
                                class="input-custom @error('current_password') is-invalid @enderror" required>
                            @error('current_password')
                                <div style="font-size:.75rem;color:#ef4444;margin-top:.3rem">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label-custom">Password Baru</label>
                            <input type="password" name="password"
                                class="input-custom @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div style="font-size:.75rem;color:#ef4444;margin-top:.3rem">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label-custom">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="input-custom" required>
                        </div>

                        <div style="display:flex;justify-content:flex-end;margin-top:1.25rem">
                            <button type="submit" class="btn-add">
                                <i class="bi bi-shield-check"></i> Ganti Password
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        const activeTab = "{{ session('tab', 'profil') }}";
        document.addEventListener('DOMContentLoaded', () => switchTab(activeTab));

        function switchTab(tab) {
            ['profil', 'password'].forEach(t => {
                document.getElementById('pane-' + t).style.display = t === tab ? 'block' : 'none';
            });

            const btnProfil = document.getElementById('tab-profil');
            const btnPassword = document.getElementById('tab-password');

            if (tab === 'profil') {
                btnProfil.style.cssText = '';
                btnProfil.className = 'btn-add';
                btnPassword.style.cssText = 'font-size:.8rem;padding:.4rem .9rem;background:var(--surface-2);border:1px solid var(--border);color:var(--muted);border-radius:10px;cursor:pointer;font-weight:700;display:inline-flex;align-items:center;gap:.4rem;transition:all .2s';
            } else {
                btnPassword.style.cssText = '';
                btnPassword.className = 'btn-add';
                btnProfil.style.cssText = 'font-size:.8rem;padding:.4rem .9rem;background:var(--surface-2);border:1px solid var(--border);color:var(--muted);border-radius:10px;cursor:pointer;font-weight:700;display:inline-flex;align-items:center;gap:.4rem;transition:all .2s';
                btnProfil.className = '';
            }
        }
    </script>
@endpush