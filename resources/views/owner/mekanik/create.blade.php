@extends('layouts.app')
@section('title', 'Tambah Mekanik')
@section('page-title', 'Tambah Mekanik')
@section('page-subtitle', 'Isi form di bawah untuk menambah mekanik baru')

@section('content')
    <div class="panel" style="max-width:600px">
        <div class="panel-header">
            <h5><i class="bi bi-person-plus me-2" style="color:var(--primary)"></i>Form Tambah Mekanik</h5>
        </div>
        <div class="panel-body">
            @if($errors->any())
                <div class="alert-danger-custom mb-3">{{ $errors->first() }}</div>
            @endif
            <form action="{{ route('owner.mekanik.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label-custom">Nama Mekanik <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="input-custom" value="{{ old('nama') }}"
                        placeholder="Nama lengkap mekanik" required>
                </div>
                <div class="form-group">
                    <label class="form-label-custom">Telepon</label>
                    <input type="text" name="telepon" class="input-custom" value="{{ old('telepon') }}"
                        placeholder="08xxxxxxxxxx">
                </div>
                <div class="form-group">
                    <label class="form-label-custom">Alamat</label>
                    <textarea name="alamat" class="input-custom" rows="3"
                        placeholder="Alamat lengkap">{{ old('alamat') }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label-custom">Status <span class="text-danger">*</span></label>
                    <select name="status" class="input-custom" required>
                        <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Non Aktif</option>
                    </select>
                </div>
                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn-add">Simpan</button>
                    <a href="{{ route('owner.mekanik.index') }}" class="btn-back">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection