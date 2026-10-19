@extends('layouts.app')
@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan Akun')
@section('page-subtitle', 'Kelola informasi akun Anda')

@section('content')
    <div class="panel" style="max-width:550px">
        <div class="panel-header">
            <h5><i class="bi bi-gear me-2" style="color:var(--primary)"></i>Edit Profil</h5>
        </div>
        <div class="panel-body">
            @if(session('success'))
                <div class="alert-success-custom mb-3"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert-danger-custom mb-3">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('owner.pengaturan.update') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label-custom">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="input-custom" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label-custom">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="input-custom" value="{{ old('email', $user->email) }}" required>
                </div>

                <hr style="border-color:var(--border); margin:1.5rem 0">
                <p style="font-size:.8rem; color:var(--muted); margin-bottom:1rem">
                    Kosongkan field password jika tidak ingin mengubah password.
                </p>

                <div class="form-group">
                    <label class="form-label-custom">Password Baru</label>
                    <input type="password" name="password" class="input-custom" placeholder="Minimal 6 karakter">
                </div>

                <div class="form-group">
                    <label class="form-label-custom">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="input-custom"
                        placeholder="Ulangi password baru">
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn-add">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection