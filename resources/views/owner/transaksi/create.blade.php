@extends('layouts.app')
@section('title', 'Buat Transaksi')
@section('page-title', 'Buat Transaksi')
@section('page-subtitle', 'Form pembayaran servis')

@section('content')
    <div class="panel" style="max-width:750px">
        <div class="panel-header">
            <h5><i class="bi bi-receipt me-2" style="color:var(--primary)"></i>Form Transaksi Baru</h5>
        </div>
        <div class="panel-body">
            @if($errors->any())
                <div class="alert-danger-custom mb-3">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('owner.transaksi.store') }}" method="POST" id="formTransaksi">
                @csrf
                <div class="form-group">
                    <label class="form-label-custom">Pilih Servis (Status Selesai) <span
                            class="text-danger">*</span></label>
                    <select name="servis_id" id="servis_id" class="input-custom" required>
                        <option value="">-- Pilih Servis --</option>
                        @foreach($servisList as $s)
                            <option value="{{ $s->id }}" data-jasa="{{ $s->biaya_jasa }}" {{ old('servis_id') == $s->id ? 'selected' : '' }}>
                                {{ $s->no_order }} — {{ $s->pelanggan->nama }} |
                                {{ $s->kendaraan->plat_nomor }} |
                                Jasa: Rp {{ number_format($s->biaya_jasa, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Spare Parts --}}
                <div class="form-group">
                    <label class="form-label-custom">Spare Part Digunakan</label>
                    <div id="parts-container"></div>
                    <button type="button" class="btn-back mt-2" onclick="addPart()">
                        <i class="bi bi-plus me-1"></i> Tambah Part
                    </button>
                </div>

                <div class="form-group">
                    <label class="form-label-custom">Metode Pembayaran <span class="text-danger">*</span></label>
                    <select name="metode_bayar" class="input-custom" required>
                        <option value="tunai">Tunai</option>
                        <option value="transfer">Transfer Bank</option>
                        <option value="qris">QRIS</option>
                    </select>
                </div>

                {{-- Summary --}}
                <div class="panel mb-3" style="background:var(--surface-2)">
                    <div class="panel-body">
                        <div class="info-row"><span>Biaya Jasa</span><strong id="show-jasa">Rp 0</strong></div>
                        <div class="info-row"><span>Total Parts</span><strong id="show-parts">Rp 0</strong></div>
                        <div class="info-row">
                            <span style="color:var(--primary); font-weight:700">Total Bayar</span>
                            <strong id="show-total" style="color:var(--primary); font-size:1.1rem">Rp 0</strong>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label-custom">Jumlah Bayar <span class="text-danger">*</span></label>
                    <input type="number" name="bayar" id="bayar" class="input-custom" value="{{ old('bayar', 0) }}" min="0"
                        required oninput="hitungKembalian()">
                </div>

                <div class="form-group">
                    <label class="form-label-custom">Kembalian</label>
                    <input type="text" id="kembalian" class="input-custom" readonly
                        style="color:var(--primary); font-weight:700" value="Rp 0">
                </div>

                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn-add">Simpan Transaksi</button>
                    <a href="{{ route('owner.transaksi.index') }}" class="btn-back">Batal</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Data spare parts untuk JS --}}
    <script>
        const spareParts = @json($spareParts);
        let partIndex = 0;
        let totalJasa = 0;

        // Saat servis dipilih
        document.getElementById('servis_id').addEventListener('change', function () {
            const opt = this.options[this.selectedIndex];
            totalJasa = parseFloat(opt.dataset.jasa) || 0;
            document.getElementById('show-jasa').textContent = formatRp(totalJasa);
            hitungTotal();
        });

        function addPart() {
            const container = document.getElementById('parts-container');
            const div = document.createElement('div');
            div.className = 'd-flex gap-2 mb-2 align-items-center';
            div.id = `part-${partIndex}`;

            let options = '<option value="">-- Pilih Part --</option>';
            spareParts.forEach(p => {
                options += `<option value="${p.id}" data-harga="${p.harga_jual}">
                ${p.nama} (Stok: ${p.stok}) — Rp ${formatRp(p.harga_jual)}
            </option>`;
            });

            div.innerHTML = `
            <select name="parts[${partIndex}][spare_part_id]" class="input-custom" style="flex:2"
                onchange="hitungTotal()">
                ${options}
            </select>
            <input type="number" name="parts[${partIndex}][qty]" class="input-custom"
                style="flex:0.5; width:80px" value="1" min="1" oninput="hitungTotal()">
            <button type="button" class="btn-icon btn-del" onclick="removePart(${partIndex})">
                <i class="bi bi-trash"></i>
            </button>
        `;
            container.appendChild(div);
            partIndex++;
        }

        function removePart(idx) {
            document.getElementById(`part-${idx}`)?.remove();
            hitungTotal();
        }

        function hitungTotal() {
            let totalParts = 0;
            document.querySelectorAll('[name^="parts["]').forEach(el => {
                if (el.name.includes('spare_part_id')) {
                    const opt = el.options[el.selectedIndex];
                    const harga = parseFloat(opt?.dataset?.harga) || 0;
                    const qtyEl = el.closest('div').querySelector('[name*="[qty]"]');
                    const qty = parseInt(qtyEl?.value) || 0;
                    totalParts += harga * qty;
                }
            });
            document.getElementById('show-parts').textContent = formatRp(totalParts);
            const total = totalJasa + totalParts;
            document.getElementById('show-total').textContent = formatRp(total);
            hitungKembalian();
        }

        function hitungKembalian() {
            const totalText = document.getElementById('show-total').textContent;
            const total = parseFloat(totalText.replace(/[^0-9]/g, '')) || 0;
            const bayar = parseFloat(document.getElementById('bayar').value) || 0;
            const kembalian = bayar - total;
            document.getElementById('kembalian').value = formatRp(Math.max(0, kembalian));
        }

        function formatRp(num) {
            return 'Rp ' + Math.round(num).toLocaleString('id-ID');
        }
    </script>
@endsection