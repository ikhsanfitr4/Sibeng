@extends('layouts.admin')
@section('title', 'Edit Spare Part')
@section('page-title', 'Edit Spare Part')

@section('content')
    <div class="panel" style="max-width:600px">
        <div class="panel-header">
            <h5><i class="bi bi-pencil me-2" style="color:var(--primary)"></i>Form Edit Spare Part</h5>
        </div>
        <div class="panel-body">
            <form action="{{ route('admin.spare-part.update', $sparePart) }}" method="POST">
                @csrf @method('PUT')
                <div class="row g-3">
                    <div class="col-md-8 form-group">
                        <label class="form-label-custom">Nama Part <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="input-custom" value="{{ old('nama', $sparePart->nama) }}"
                            required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="form-label-custom">Kode <span class="text-danger">*</span></label>
                        <input type="text" name="kode" class="input-custom" value="{{ old('kode', $sparePart->kode) }}"
                            required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label-custom">Kategori</label>
                        <input type="text" name="kategori" class="input-custom"
                            value="{{ old('kategori', $sparePart->kategori) }}">
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="form-label-custom">Stok</label>
                        <input type="number" name="stok" class="input-custom" value="{{ old('stok', $sparePart->stok) }}"
                            min="0">
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="form-label-custom">Stok Min</label>
                        <input type="number" name="stok_minimum" class="input-custom"
                            value="{{ old('stok_minimum', $sparePart->stok_minimum) }}" min="0">
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label-custom">Harga Beli</label>
                        <input type="number" name="harga_beli" class="input-custom"
                            value="{{ old('harga_beli', $sparePart->harga_beli) }}" min="0">
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label-custom">Harga Jual</label>
                        <input type="number" name="harga_jual" class="input-custom"
                            value="{{ old('harga_jual', $sparePart->harga_jual) }}" min="0">
                    </div>
                </div>
                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn-add">Update</button>
                    <a href="{{ route('admin.spare-part.index') }}" class="btn-back">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection