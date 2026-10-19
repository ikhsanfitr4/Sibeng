@extends('layouts.app')
@section('title', 'Edit Admin')
@section('page-title', 'Edit Admin')
@section('page-subtitle', 'Update akun admin: ' . $user->name)

@section('content')
    <div class="panel" style="max-width:560px">
        <div class="panel-header">
            <h5><i class="bi bi-pencil me-2" style="color:var(--primary)"></i>Form Edit Akun Admin</h5>
        </div>
        <div class="panel-body">
            @if($errors->any())
                <div class="alert-danger-custom mb-3">
                    <i class="bi bi-exclamation-circle me-2"></i>{{ $errors->first() }}
                </div>
            @endif

            {{-- Info akun --}}
            <div style="
                background:var(--surface-2);
                border:1px solid var(--border);
                border-radius:10px;
                padding:.85rem 1rem;
                margin-bottom:1.25rem;
                display:flex;align-items:center;gap:.75rem;
            ">
                <div style="
                    width:40px;height:40px;border-radius:50%;
                    background:linear-gradient(135deg,#0ea5e9,#38bdf8);
                    display:flex;align-items:center;justify-content:center;
                    font-weight:700;color:#fff;font-size:1rem;flex-shrink:0;
                ">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                <div>
                    <div style="font-weight:600;font-size:.875rem">{{ $user->name }}</div>
                    <div style="font-size:.75rem;color:var(--muted)">{{ $user->email }}</div>
                </div>
                <span class="badge-status badge-proses ms-auto">Admin</span>
            </div>

            <form action="{{ route('owner.user.update', $user) }}" method="POST">
                @csrf @method('PUT')

                <div class="form-group">
                    <label class="form-label-custom">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="input-custom" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label-custom">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="input-custom" value="{{ old('email', $user->email) }}" required>
                </div>

                <hr style="border-color:var(--border);margin:1.25rem 0">
                <p style="font-size:.8rem;color:var(--muted);margin-bottom:1rem">
                    <i class="bi bi-info-circle me-1"></i>
                    Kosongkan field password jika tidak ingin mengubah password.
                </p>

                <div class="form-group">
                    <label class="form-label-custom">Password Baru</label>
                    <div style="position:relative">
                        <input type="password" name="password" id="password" class="input-custom"
                            placeholder="Minimal 6 karakter" style="padding-right:40px">
                        <button type="button" onclick="togglePw('password','iconPw1')"
                            style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--muted);cursor:pointer">
                            <i class="bi bi-eye" id="iconPw1"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label-custom">Konfirmasi Password</label>
                    <div style="position:relative">
                        <input type="password" name="password_confirmation" id="password2" class="input-custom"
                            placeholder="Ulangi password baru" style="padding-right:40px">
                        <button type="button" onclick="togglePw('password2','iconPw2')"
                            style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--muted);cursor:pointer">
                            <i class="bi bi-eye" id="iconPw2"></i>
                        </button>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn-add">
                        <i class="bi bi-save me-1"></i> Update
                    </button>
                    <a href="{{ route('owner.user.index') }}" class="btn-back">Batal</a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function togglePw(inputId, iconId) {
                const input = document.getElementById(inputId);
                const icon = document.getElementById(iconId);
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.className = 'bi bi-eye-slash';
                } else {
                    input.type = 'password';
                    icon.className = 'bi bi-eye';
                }
            }
        </script>
    @endpush
@endsection