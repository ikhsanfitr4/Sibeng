@extends('layouts.app')
@section('title', 'Edit Servis')
@section('page-title', 'Edit Servis')
@section('page-subtitle', 'Update data work order servis')

@section('content')
    <div class="panel" style="max-width:700px">
        <div class="panel-header">
            <h5><i class="bi bi-pencil me-2" style="color:var(--primary)"></i>Edit Servis — {{ $servis->no_order }}</h5>
        </div>
        <div class="panel-body">
            @if($errors->any())
                <div class="alert-danger-custom mb-3">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('owner.servis.update', $servis) }}" method="POST">
                @csrf @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6 form-group">
                        <label class="form-label-custom">Pelanggan</label>
                        <input type="text" class="input-custom" value="{{ $servis->pelanggan->nama }}" disabled>
                        <input type="hidden" name="pelanggan_id" value="{{ $servis->pelanggan_id }}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label-custom">Kendaraan</label>
                        <select name="kendaraan_id" class="input-custom" required>
                            @foreach($kendaraans as $k)
                                <option value="{{ $k->id }}" {{ $servis->kendaraan_id == $k->id ? 'selected' : '' }}>
                                    {{ $k->merk }} {{ $k->model }} - {{ $k->plat_nomor }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label-custom">Mekanik <span class="text-danger">*</span></label>
                        <select name="mekanik_id" class="input-custom" required>
                            @foreach($mekaniks as $m)
                                <option value="{{ $m->id }}" {{ $servis->mekanik_id == $m->id ? 'selected' : '' }}>
                                    {{ $m->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label-custom">Tanggal Masuk <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_masuk" class="input-custom"
                            value="{{ old('tanggal_masuk', $servis->tanggal_masuk) }}" required>
                    </div>
                    <div class="col-md-12 form-group">
                        <label class="form-label-custom">Keluhan <span class="text-danger">*</span></label>
                        <textarea name="keluhan" class="input-custom" rows="3"
                            required>{{ old('keluhan', $servis->keluhan) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group">
                        <label class="form-label-custom">Diagnosa</label>
                        <textarea name="diagnosa" class="input-custom"
                            rows="2">{{ old('diagnosa', $servis->diagnosa) }}</textarea>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label-custom">Biaya Jasa <span class="text-danger">*</span></label>
                        <input type="number" name="biaya_jasa" class="input-custom"
                            value="{{ old('biaya_jasa', $servis->biaya_jasa) }}" min="0" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label-custom">Status <span class="text-danger">*</span></label>
                        <select name="status" class="input-custom" required>
                            @foreach(['antrian', 'proses', 'selesai', 'batal'] as $st)
                                <option value="{{ $st }}" {{ $servis->status == $st ? 'selected' : '' }}>
                                    {{ ucfirst($st) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 form-group">
                        <label class="form-label-custom">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="input-custom"
                            value="{{ old('tanggal_selesai', $servis->tanggal_selesai) }}">
                    </div>
                    <div class="col-md-12 form-group">
                        <label class="form-label-custom">Catatan</label>
                        <textarea name="catatan" class="input-custom"
                            rows="2">{{ old('catatan', $servis->catatan) }}</textarea>
                    </div>
                </div>
                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn-add">Update</button>
                    <a href="{{ route('owner.servis.index') }}" class="btn-back">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection