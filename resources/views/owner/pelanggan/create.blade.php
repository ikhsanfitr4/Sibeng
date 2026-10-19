@extends('layouts.app')
@section('title', 'Tambah Pelanggan')
@section('page-title', 'Tambah Pelanggan')

@section('content')
    <div class="panel" style="max-width:600px">
        <div class="panel-header">
            <h5><i class="bi bi-person-plus me-2" style="color:var(--primary)"></i>Form Tambah Pelanggan</h5>
        </div>
        <div class="panel-body">
            @if($errors->any())
                <div class="alert-danger-custom mb-3">{{ $errors->first() }}</div>
            @endif
            <form action="{{ route('owner.pelanggan.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label-custom">Nama <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="input-custom" value="{{ old('nama') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label-custom">Telepon</label>
                    <input type="text" name="telepon" class="input-custom" value="{{ old('telepon') }}">
                </div>
                <div class="form-group">
                    <label class="form-label-custom">Email</label>
                    <input type="email" name="email" class="input-custom" value="{{ old('email') }}">
                </div>
                <div class="form-group">
                    <label class="form-label-custom">Alamat</label>
                    <textarea name="alamat" class="input-custom" rows="3">{{ old('alamat') }}</textarea>
                </div>
                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn-add">Simpan</button>
                    <a href="{{ route('owner.pelanggan.index') }}" class="btn-back">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection