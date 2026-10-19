@extends('layouts.admin')
@section('title', 'Tambah Servis')
@section('page-title', 'Tambah Servis')
@section('page-subtitle', 'Buat work order servis baru')

@section('content')
    <div class="panel" style="max-width:700px">
        <div class="panel-header">
            <h5><i class="bi bi-wrench-adjustable me-2" style="color:var(--primary)"></i>Form Tambah Servis</h5>
        </div>
        <div class="panel-body">
            @if($errors->any())
                <div class="alert-danger-custom mb-3">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('admin.servis.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6 form-group">
                        <label class="form-label-custom">Pelanggan <span class="text-danger">*</span></label>
                        <select name="pelanggan_id" id="pelanggan_id" class="input-custom" required>
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach($pelanggans as $p)
                                <option value="{{ $p->id }}" {{ old('pelanggan_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label-custom">Kendaraan <span class="text-danger">*</span></label>
                        <select name="kendaraan_id" id="kendaraan_id" class="input-custom" required>
                            <option value="">-- Pilih Pelanggan Dulu --</option>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label-custom">Mekanik <span class="text-danger">*</span></label>
                        <select name="mekanik_id" class="input-custom" required>
                            <option value="">-- Pilih Mekanik --</option>
                            @foreach($mekaniks as $m)
                                <option value="{{ $m->id }}" {{ old('mekanik_id') == $m->id ? 'selected' : '' }}>
                                    {{ $m->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label-custom">Tanggal Masuk <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_masuk" class="input-custom"
                            value="{{ old('tanggal_masuk', date('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-12 form-group">
                        <label class="form-label-custom">Keluhan <span class="text-danger">*</span></label>
                        <textarea name="keluhan" class="input-custom" rows="3"
                            placeholder="Deskripsikan keluhan pelanggan..." required>{{ old('keluhan') }}</textarea>
                    </div>
                    <div class="col-md-12 form-group">
                        <label class="form-label-custom">Diagnosa Awal</label>
                        <textarea name="diagnosa" class="input-custom" rows="2"
                            placeholder="Diagnosa awal mekanik (opsional)">{{ old('diagnosa') }}</textarea>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label-custom">Biaya Jasa <span class="text-danger">*</span></label>
                        <input type="number" name="biaya_jasa" class="input-custom" value="{{ old('biaya_jasa', 0) }}"
                            min="0" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label-custom">Status <span class="text-danger">*</span></label>
                        <select name="status" class="input-custom" required>
                            <option value="antrian" {{ old('status') == 'antrian' ? 'selected' : '' }}>Antrian</option>
                            <option value="proses" {{ old('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                            <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="batal" {{ old('status') == 'batal' ? 'selected' : '' }}>Batal</option>
                        </select>
                    </div>
                    <div class="col-md-12 form-group">
                        <label class="form-label-custom">Catatan</label>
                        <textarea name="catatan" class="input-custom" rows="2"
                            placeholder="Catatan tambahan (opsional)">{{ old('catatan') }}</textarea>
                    </div>
                </div>
                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn-add">Simpan</button>
                    <a href="{{ route('admin.servis.index') }}" class="btn-back">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('pelanggan_id').addEventListener('change', function () {
            const pelangganId = this.value;
            const kendaraanSelect = document.getElementById('kendaraan_id');
            kendaraanSelect.innerHTML = '<option value="">Loading...</option>';
            if (!pelangganId) {
                kendaraanSelect.innerHTML = '<option value="">-- Pilih Pelanggan Dulu --</option>';
                return;
            }
            fetch(`/api/kendaraan/${pelangganId}`)
                .then(res => res.json())
                .then(data => {
                    kendaraanSelect.innerHTML = '<option value="">-- Pilih Kendaraan --</option>';
                    data.forEach(k => {
                        kendaraanSelect.innerHTML += `<option value="${k.id}">${k.merk} ${k.model} - ${k.plat_nomor}</option>`;
                    });
                });
        });
    </script>
@endpush