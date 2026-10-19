@extends('layouts.admin')
@section('title', 'Edit Kendaraan')
@section('page-title', 'Edit Kendaraan')
@section('page-subtitle', 'Pelanggan: ' . $pelanggan->nama)

@section('content')
    <div class="panel" style="max-width:580px">
        <div class="panel-header">
            <h5><i class="bi bi-pencil me-2" style="color:var(--primary)"></i>Form Edit Kendaraan</h5>
        </div>
        <div class="panel-body">
            @if($errors->any())
                <div class="alert-danger-custom mb-3">{{ $errors->first() }}</div>
            @endif
            <form action="{{ route('admin.kendaraan.update', [$pelanggan, $kendaraan]) }}" method="POST">
                @csrf @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6 form-group">
                        <label class="form-label-custom">Merk <span class="text-danger">*</span></label>
                        <input type="text" name="merk" class="input-custom" value="{{ old('merk', $kendaraan->merk) }}"
                            list="merk-list" required>
                        <datalist id="merk-list">
                            <option value="Honda">
                            <option value="Yamaha">
                            <option value="Suzuki">
                            <option value="Kawasaki">
                            <option value="Toyota">
                            <option value="Mitsubishi">
                            <option value="Daihatsu">
                            <option value="Nissan">
                            <option value="Isuzu">
                        </datalist>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label-custom">Model <span class="text-danger">*</span></label>
                        <input type="text" name="model" class="input-custom" value="{{ old('model', $kendaraan->model) }}"
                            required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="form-label-custom">Tahun</label>
                        <input type="text" name="tahun" class="input-custom" value="{{ old('tahun', $kendaraan->tahun) }}"
                            maxlength="4">
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="form-label-custom">Warna</label>
                        <input type="text" name="warna" class="input-custom" value="{{ old('warna', $kendaraan->warna) }}">
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="form-label-custom">Plat Nomor <span class="text-danger">*</span></label>
                        <input type="text" name="plat_nomor" class="input-custom"
                            value="{{ old('plat_nomor', $kendaraan->plat_nomor) }}" style="text-transform:uppercase"
                            required>
                    </div>
                </div>
                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn-add"><i class="bi bi-save me-1"></i> Update</button>
                    <a href="{{ route('admin.pelanggan.show', $pelanggan) }}" class="btn-back">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection