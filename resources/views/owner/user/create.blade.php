@extends('layouts.app')
@section('title', 'Tambah Admin')
@section('page-title', 'Tambah Admin')
@section('page-subtitle', 'Buat akun admin baru')

@section('content')
    <div class="panel" style="max-width:560px">
        <div class="panel-header">
            <h5><i class="bi bi-person-plus me-2" style="color:var(--primary)"></i>Form Tambah Akun Admin</h5>
        </div>
        <div class="panel-body">
            @if($errors->any())
                <div class="alert-danger-custom mb-3">
                    <i class="bi bi-exclamation-circle me-2"></i>{{ $errors->first() }}
                </div>
            @endif

            {{-- Info --}}
            <div style="
                background:rgba(14,165,233,.08);
                border:1px solid rgba(14,165,233,.2);
                border-radius:10px;
                padding:.75rem 1rem;
                margin-bottom:1.25rem;
                font-size:.82rem;color:var(--muted);
                display:flex;align-items:center;gap:.6rem;
            ">
                <i class="bi bi-info-circle" style="color:#0ea5e9"></i>
                Akun yang dibuat akan memiliki role <strong style="color:#0ea5e9">Admin</strong> dan bisa login ke panel
                admin.
            </div>

            <form action="{{ route('owner.user.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label-custom">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="input-custom" value="{{ old('name') }}"
                        placeholder="Nama lengkap admin" required>
                </div>

                <div class="form-group">
                    <label class="form-label-custom">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="input-custom" value="{{ old('email') }}"
                        placeholder="email@bengkel.com" required>
                </div>

                <div class="form-group">
                    <label class="form-label-custom">Password <span class="text-danger">*</span></label>
                    <div style="position:relative">
                        <input type="password" name="password" id="password" class="input-custom"
                            placeholder="Minimal 6 karakter" style="padding-right:40px" required>
                        <button type="button" onclick="togglePw('password','iconPw1')"
                            style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--muted);cursor:pointer">
                            <i class="bi bi-eye" id="iconPw1"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label-custom">Konfirmasi Password <span class="text-danger">*</span></label>
                    <div style="position:relative">
                        <input type="password" name="password_confirmation" id="password2" class="input-custom"
                            placeholder="Ulangi password" style="padding-right:40px" required>
                        <button type="button" onclick="togglePw('password2','iconPw2')"
                            style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--muted);cursor:pointer">
                            <i class="bi bi-eye" id="iconPw2"></i>
                        </button>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn-add">
                        <i class="bi bi-save me-1"></i> Simpan
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