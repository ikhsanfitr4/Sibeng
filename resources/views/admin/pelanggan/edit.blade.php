@extends('layouts.admin')
@section('title', 'Edit Pelanggan')
@section('page-title', 'Edit Pelanggan')

@section('content')
    <div class="panel" style="max-width:600px">
        <div class="panel-header">
            <h5><i class="bi bi-pencil me-2" style="color:var(--primary)"></i>Form Edit Pelanggan</h5>
        </div>
        <div class="panel-body">
            <form action="{{ route('admin.pelanggan.update',  $pelanggan) }}" method="POST">
                @csrf 
                @method('PUT')
                <div class="form-group">
                    <label class="form-label-custom">Nama <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="input-custom" value="{{ old('nama', $pelanggan->nama) }}"
                        required>
                </div>
                <div class="form-group">
                    <label class="form-label-custom">Telepon</label>
                    <input type="text" name="telepon" class="input-custom"
                        value="{{ old('telepon', $pelanggan->telepon) }}">
                </div>
                <div class="form-group">
                    <label class="form-label-custom">Email</label>
                    <input type="email" name="email" class="input-custom" value="{{ old('email', $pelanggan->email) }}">
                </div>
                <div class="form-group">
                    <label class="form-label-custom">Alamat</label>
                    <textarea name="alamat" class="input-custom" rows="3">{{ old('alamat', $pelanggan->alamat) }}</textarea>
                </div>
                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn-add">Update</button>
                    <a href="{{ route('admin.pelanggan.index') }}" class="btn-back">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection