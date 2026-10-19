@extends('layouts.app')
@section('title', 'Tambah Spare Part')
@section('page-title', 'Tambah Spare Part')

@section('content')
    <div class="panel" style="max-width:600px">
        <div class="panel-header">
            <h5><i class="bi bi-box-seam me-2" style="color:var(--primary)"></i>Form Tambah Spare Part</h5>
        </div>
        <div class="panel-body">
            @if($errors->any())
                <div class="alert-danger-custom mb-3">{{ $errors->first() }}</div>
            @endif
            <form action="{{ route('owner.spare-part.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-8 form-group">
                        <label class="form-label-custom">Nama Part <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="input-custom" value="{{ old('nama') }}" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="form-label-custom">Kode <span class="text-danger">*</span></label>
                        <input type="text" name="kode" class="input-custom" value="{{ old('kode') }}" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label-custom">Kategori</label>
                        <input type="text" name="kategori" class="input-custom" value="{{ old('kategori') }}">
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="form-label-custom">Stok <span class="text-danger">*</span></label>
                        <input type="number" name="stok" class="input-custom" value="{{ old('stok', 0) }}" min="0" required>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="form-label-custom">Stok Min <span class="text-danger">*</span></label>
                        <input type="number" name="stok_minimum" class="input-custom" value="{{ old('stok_minimum', 5) }}"
                            min="0" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label-custom">Harga Beli <span class="text-danger">*</span></label>
                        <input type="number" name="harga_beli" class="input-custom" value="{{ old('harga_beli', 0) }}"
                            min="0" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label-custom">Harga Jual <span class="text-danger">*</span></label>
                        <input type="number" name="harga_jual" class="input-custom" value="{{ old('harga_jual', 0) }}"
                            min="0" required>
                    </div>
                </div>
                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn-add">Simpan</button>
                    <a href="{{ route('owner.spare-part.index') }}" class="btn-back">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection