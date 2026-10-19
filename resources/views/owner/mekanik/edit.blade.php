@extends('layouts.app')
@section('title', 'Edit Mekanik')
@section('page-title', 'Edit Mekanik')
@section('page-subtitle', 'Update data mekanik')

@section('content')
    <div class="panel" style="max-width:600px">
        <div class="panel-header">
            <h5><i class="bi bi-pencil me-2" style="color:var(--primary)"></i>Form Edit Mekanik</h5>
        </div>
        <div class="panel-body">
            @if($errors->any())
                <div class="alert-danger-custom mb-3">{{ $errors->first() }}</div>
            @endif
            <form action="{{ route('owner.mekanik.update', $mekanik) }}" method="POST">
                @csrf @method('PUT')
                <div class="form-group">
                    <label class="form-label-custom">Nama Mekanik <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="input-custom" value="{{ old('nama', $mekanik->nama) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label-custom">Telepon</label>
                    <input type="text" name="telepon" class="input-custom" value="{{ old('telepon', $mekanik->telepon) }}">
                </div>
                <div class="form-group">
                    <label class="form-label-custom">Alamat</label>
                    <textarea name="alamat" class="input-custom" rows="3">{{ old('alamat', $mekanik->alamat) }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label-custom">Status <span class="text-danger">*</span></label>
                    <select name="status" class="input-custom" required>
                        <option value="aktif" {{ old('status', $mekanik->status) == 'aktif' ? 'selected' : '' }}>Aktif
                        </option>
                        <option value="nonaktif" {{ old('status', $mekanik->status) == 'nonaktif' ? 'selected' : '' }}>Non
                            Aktif</option>
                    </select>
                </div>
                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn-add">Update</button>
                    <a href="{{ route('owner.mekanik.index') }}" class="btn-back">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection