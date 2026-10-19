@extends('layouts.app')
@section('title', 'Audit Log')
@section('page-title', 'Audit Log')
@section('page-subtitle', 'Riwayat aktivitas sistem')
 
@section('content')
 
@php
    $aksiMap = [
        'LOGIN'       => ['color'=>'#00D4AA','bg'=>'rgba(0,212,170,.12)',  'border'=>'rgba(0,212,170,.2)',  'icon'=>'🔐','label'=>'LOGIN'],
        'LOGOUT'      => ['color'=>'#FFB830','bg'=>'rgba(255,184,48,.12)', 'border'=>'rgba(255,184,48,.2)', 'icon'=>'🚪','label'=>'LOGOUT'],
        'LOGIN_GAGAL' => ['color'=>'#FF4B6E','bg'=>'rgba(255,75,110,.12)', 'border'=>'rgba(255,75,110,.2)', 'icon'=>'❌','label'=>'LOGIN GAGAL'],
        'CREATE'      => ['color'=>'#00D4AA','bg'=>'rgba(0,212,170,.12)',  'border'=>'rgba(0,212,170,.2)',  'icon'=>'➕','label'=>'CREATE'],
        'UPDATE'      => ['color'=>'#4B9EFF','bg'=>'rgba(75,158,255,.12)', 'border'=>'rgba(75,158,255,.2)', 'icon'=>'✏️','label'=>'UPDATE'],
        'DELETE'      => ['color'=>'#FF4B6E','bg'=>'rgba(255,75,110,.12)', 'border'=>'rgba(255,75,110,.2)', 'icon'=>'🗑️','label'=>'DELETE'],
        'EXPORT'      => ['color'=>'#FF6B35','bg'=>'rgba(255,107,53,.12)', 'border'=>'rgba(255,107,53,.2)', 'icon'=>'📤','label'=>'EXPORT'],
        'BACKUP'      => ['color'=>'#A78BFA','bg'=>'rgba(167,139,250,.12)','border'=>'rgba(167,139,250,.2)','icon'=>'💾','label'=>'BACKUP'],
    ];
 
    
    
    
    
@endphp
 
<style>
/* ── AUDIT LOG STYLES ── */
.al-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 12px;
    margin-bottom: 20px;
}
.al-stat-card {
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.12);
    backdrop-filter: blur(14px);
    border-radius: 16px;
    padding: 16px 18px;
    position: relative;
    overflow: hidden;
    transition: transform .2s;
}
.al-stat-card:hover { transform: translateY(-2px); }
.al-stat-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 2px;
}
.al-stat-card.c1::before { background: linear-gradient(90deg,#00D4AA,#00ffcc); }
.al-stat-card.c2::before { background: linear-gradient(90deg,#4B9EFF,#a78bfa); }
.al-stat-card.c3::before { background: linear-gradient(90deg,#FF4B6E,#ff8fa3); }
.al-stat-card.c4::before { background: linear-gradient(90deg,#FF6B35,#ffb830); }
.al-stat-icon  { font-size: 20px; margin-bottom: 8px; }
.al-stat-val   { font-family: 'Rajdhani', sans-serif; font-size: 28px; font-weight: 700; color: #F0F0F0; line-height: 1; }
.al-stat-label { font-size: 11px; color: rgba(255,255,255,.5); text-transform: uppercase; letter-spacing: .8px; margin-top: 4px; }
 
/* Filter bar */
.al-filter {
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.12);
    backdrop-filter: blur(14px);
    border-radius: 18px;
    padding: 16px 20px;
    display: flex; flex-wrap: wrap; gap: 10px; align-items: flex-end;
    margin-bottom: 20px;
}
.al-filter-group { display: flex; flex-direction: column; gap: 5px; }
.al-filter-label { font-size: 10px; font-weight: 700; color: rgba(255,255,255,.4); text-transform: uppercase; letter-spacing: 1px; }
.al-filter-input, .al-filter-select {
    background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.1);
    border-radius: 10px; padding: 7px 12px; color: #F0F0F0;
    font-size: 13px; outline: none; height: 34px;
    transition: border-color .2s; font-family: inherit;
}
.al-filter-input::placeholder { color: rgba(255,255,255,.25); }
.al-filter-input:focus, .al-filter-select:focus { border-color: rgba(255,107,53,.45); }
.al-filter-select option { background: #1a1f35; }
.al-btn-filter {
    height: 34px; padding: 0 16px; border-radius: 10px; border: none;
    background: linear-gradient(135deg,#FF6B35,#ff9a00); color: #fff;
    font-size: 13px; font-weight: 700; cursor: pointer; transition: all .2s;
    font-family: inherit; box-shadow: 0 4px 14px rgba(255,107,53,.3);
}
.al-btn-filter:hover { transform: translateY(-1px); }
.al-btn-reset {
    height: 34px; padding: 0 12px; border-radius: 10px;
    background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.12);
    color: rgba(255,255,255,.5); font-size: 13px; cursor: pointer;
    font-family: inherit; transition: all .2s;
}
.al-btn-reset:hover { background: rgba(255,255,255,.1); color: #F0F0F0; }
 
/* Panel / Table */
.al-panel {
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.12);
    backdrop-filter: blur(14px);
    border-radius: 18px;
    overflow: hidden;
}
.al-panel-head {
    display: flex; align-items: center; justify-content: space-between;
    padding: 16px 22px 12px;
    border-bottom: 1px solid rgba(255,255,255,.07);
    flex-wrap: wrap; gap: 10px;
}
.al-panel-title { font-family: 'Rajdhani', sans-serif; font-size: 16px; font-weight: 600; color: #F0F0F0; }
.al-panel-meta  { font-size: 12px; color: rgba(255,255,255,.4); }
.al-export-btn {
    display: flex; align-items: center; gap: 6px;
    padding: 6px 14px; border-radius: 9px;
    background: rgba(0,212,170,.1); border: 1px solid rgba(0,212,170,.2);
    color: #00D4AA; font-size: 12px; font-weight: 600;
    cursor: pointer; transition: all .2s; text-decoration: none;
}
.al-export-btn:hover { background: rgba(0,212,170,.18); color: #00D4AA; }
 
/* Log item */
.al-item {
    display: flex; align-items: flex-start; gap: 14px;
    padding: 14px 22px;
    border-bottom: 1px solid rgba(255,255,255,.05);
    transition: background .15s; cursor: pointer;
    position: relative;
}
.al-item:last-child { border-bottom: none; }
.al-item:hover { background: rgba(255,255,255,.03); }
 
.al-accent {
    width: 3px; border-radius: 3px; flex-shrink: 0;
    align-self: stretch; min-height: 40px;
}
 
.al-avatar {
    width: 38px; height: 38px; border-radius: 11px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 14px;
}
 
.al-body { flex: 1; min-width: 0; }
 
.al-top { display: flex; align-items: center; flex-wrap: wrap; gap: 8px; margin-bottom: 5px; }
.al-name { font-weight: 700; font-size: 14px; color: #F0F0F0; }
 
.al-badge {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 3px 9px; border-radius: 8px;
    font-size: 11px; font-weight: 700;
}
 
.al-module-badge {
    display: inline-block; padding: 2px 8px; border-radius: 6px;
    font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px;
    background: rgba(255,255,255,.07); color: rgba(255,255,255,.5);
    border: 1px solid rgba(255,255,255,.1);
}
 
.al-meta-row {
    display: flex; flex-wrap: wrap; gap: 14px;
    font-size: 12px; color: rgba(255,255,255,.45);
    margin-top: 5px;
}
.al-meta-item { display: flex; align-items: center; gap: 4px; }
 
/* Diff preview */
.al-diff {
    display: flex; flex-wrap: wrap; gap: 4px;
    margin-top: 6px;
}
.diff-old { background: rgba(255,75,110,.1);  color: #ff8fa3; border: 1px solid rgba(255,75,110,.2);  border-radius: 5px; padding: 1px 7px; font-size: 10px; font-family: 'JetBrains Mono', monospace; }
.diff-new { background: rgba(0,212,170,.1);   color: #6ee7c0; border: 1px solid rgba(0,212,170,.2);  border-radius: 5px; padding: 1px 7px; font-size: 10px; font-family: 'JetBrains Mono', monospace; }
.diff-arrow { color: rgba(255,255,255,.3); font-size: 11px; align-self: center; }
 
.al-time { text-align: right; flex-shrink: 0; }
.al-time-main { font-size: 13px; font-weight: 600; color: #F0F0F0; }
.al-time-date { font-size: 11px; color: rgba(255,255,255,.4); margin-top: 1px; }
.al-time-rel  { font-size: 10px; color: rgba(255,255,255,.3); margin-top: 1px; }
 
/* Detail btn */
.al-detail-btn {
    margin-top: 8px; padding: 4px 10px; border-radius: 8px;
    background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.1);
    color: rgba(255,255,255,.4); font-size: 11px; font-weight: 600;
    cursor: pointer; transition: all .2s; display: inline-block;
    font-family: inherit;
}
.al-detail-btn:hover { background: rgba(75,158,255,.12); color: #4B9EFF; border-color: rgba(75,158,255,.25); }
 
/* Empty state */
.al-empty {
    padding: 3rem; text-align: center;
    color: rgba(255,255,255,.3); font-size: 14px;
}
 
/* Modal */
.al-modal-overlay {
    display: none; position: fixed; inset: 0; z-index: 1000;
    background: rgba(0,0,0,.65); backdrop-filter: blur(8px);
    align-items: center; justify-content: center; padding: 20px;
}
.al-modal-overlay.show { display: flex; }
.al-modal {
    background: rgba(15,20,40,.97); border: 1px solid rgba(255,255,255,.13);
    border-radius: 22px; width: 100%; max-width: 560px; max-height: 85vh;
    overflow-y: auto; box-shadow: 0 30px 80px rgba(0,0,0,.5);
    animation: alModalIn .25s cubic-bezier(.34,1.56,.64,1);
}
@keyframes alModalIn { from { opacity:0; transform:translateY(20px) scale(.96); } to { opacity:1; transform:none; } }
.al-modal-head {
    display: flex; align-items: center; justify-content: space-between;
    padding: 18px 22px 14px; border-bottom: 1px solid rgba(255,255,255,.08);
    position: sticky; top: 0; background: rgba(15,20,40,.97); z-index: 1;
}
.al-modal-title { font-family: 'Rajdhani', sans-serif; font-size: 18px; font-weight: 700; color: #F0F0F0; }
.al-modal-close {
    width: 30px; height: 30px; border-radius: 8px;
    background: rgba(255,255,255,.07); border: 1px solid rgba(255,255,255,.1);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; font-size: 15px; color: #F0F0F0; transition: all .2s;
}
.al-modal-close:hover { background: rgba(255,75,110,.15); color: #FF4B6E; }
.al-modal-body { padding: 18px 22px 22px; display: flex; flex-direction: column; gap: 16px; }
.al-modal-section { display: flex; flex-direction: column; gap: 9px; }
.al-modal-section-title {
    font-size: 10px; font-weight: 700; text-transform: uppercase;
    letter-spacing: 1.2px; color: rgba(255,255,255,.4);
    padding-bottom: 6px; border-bottom: 1px solid rgba(255,255,255,.07);
}
.al-modal-row { display: flex; gap: 10px; align-items: flex-start; }
.al-modal-key { font-size: 12px; color: rgba(255,255,255,.4); min-width: 110px; flex-shrink: 0; padding-top: 1px; }
.al-modal-val { font-size: 13px; font-weight: 600; color: #F0F0F0; flex: 1; }
 
/* Diff table in modal */
.al-diff-table { width: 100%; border-collapse: collapse; font-size: 12px; }
.al-diff-table th {
    padding: 7px 10px; background: rgba(255,255,255,.05);
    font-size: 10px; font-weight: 700; text-transform: uppercase;
    letter-spacing: 1px; color: rgba(255,255,255,.4); text-align: left;
}
.al-diff-table td { padding: 8px 10px; border-bottom: 1px solid rgba(255,255,255,.05); vertical-align: top; }
.al-diff-table tr:last-child td { border-bottom: none; }
.al-diff-field { font-family: 'JetBrains Mono', monospace; color: rgba(255,255,255,.4); font-size: 11px; }
 
/* Pagination */
.al-pagination {
    display: flex; align-items: center; justify-content: space-between;
    padding: 12px 22px; border-top: 1px solid rgba(255,255,255,.07);
    flex-wrap: wrap; gap: 8px;
}
.al-pagination-info { font-size: 12px; color: rgba(255,255,255,.4); }
.al-page-link {
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 32px; height: 32px; padding: 0 6px;
    border-radius: 9px; font-size: 12px; font-weight: 600;
    background: rgba(255,255,255,.05); border: 1px solid rgba(255,255,255,.1);
    color: rgba(255,255,255,.4); transition: all .2s; text-decoration: none;
}
.al-page-link:hover { background: rgba(255,255,255,.1); color: #F0F0F0; }
.al-page-link.active { background: rgba(255,107,53,.2); border-color: rgba(255,107,53,.35); color: #FF6B35; }
.al-page-link.disabled { opacity: .3; pointer-events: none; }
 
/* Success alert */
.al-alert-success {
    background: rgba(0,212,170,.1); border: 1px solid rgba(0,212,170,.25);
    color: #00D4AA; border-radius: 14px; padding: .85rem 1.1rem;
    margin-bottom: 1.25rem; display: flex; align-items: center;
    gap: .6rem; font-size: .84rem;
}
 
@media (max-width: 640px) {
    .al-stats { grid-template-columns: repeat(2, 1fr); }
    .al-item  { padding: 12px 14px; gap: 10px; }
    .al-meta-row { gap: 8px; }
    .al-filter-group { width: 100%; }
    .al-filter-input, .al-filter-select { width: 100%; }
}
</style>
 
@if(session('success'))
    <div class="al-alert-success">
        ✅ {{ session('success') }}
    </div>
@endif
 
{{-- ── STAT CARDS ── --}}
<div class="al-stats">
    <div class="al-stat-card c1">
        <div class="al-stat-icon">🔐</div>
        <div class="al-stat-val">{{ $totalLogin }}</div>
        <div class="al-stat-label">Total Login</div>
    </div>
    <div class="al-stat-card c2">
        <div class="al-stat-icon">🚪</div>
        <div class="al-stat-val">{{ $totalLogout }}</div>
        <div class="al-stat-label">Total Logout</div>
    </div>
    <div class="al-stat-card c3">
        <div class="al-stat-icon">❌</div>
        <div class="al-stat-val">{{ $totalGagal }}</div>
        <div class="al-stat-label">Login Gagal</div>
    </div>
    <div class="al-stat-card c4">
        <div class="al-stat-icon">📋</div>
        <div class="al-stat-val">{{ $totalHariIni }}</div>
        <div class="al-stat-label">Hari Ini</div>
    </div>
</div>
 
{{-- ── FILTER ── --}}
<form method="GET" action="{{ route('owner.audit-log.index') }}" class="al-filter">
    <div class="al-filter-group" style="flex:1;min-width:180px;">
        <label class="al-filter-label">🔍 Cari</label>
        <input type="text" name="search" class="al-filter-input"
               placeholder="Cari nama, email, IP, keterangan..."
               value="{{ request('search') }}">
    </div>
    <div class="al-filter-group">
        <label class="al-filter-label">⚡ Aksi</label>
        <select name="aksi" class="al-filter-select">
            <option value="">Semua Aksi</option>
            @foreach(array_keys($aksiMap) as $key)
                <option value="{{ $key }}" {{ request('aksi') == $key ? 'selected' : '' }}>
                    {{ $aksiMap[$key]['icon'] }} {{ $aksiMap[$key]['label'] }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="al-filter-group">
        <label class="al-filter-label">📅 Dari</label>
        <input type="date" name="dari" class="al-filter-input"
               value="{{ request('dari') }}" style="width:140px;">
    </div>
    <div class="al-filter-group">
        <label class="al-filter-label">📅 Sampai</label>
        <input type="date" name="sampai" class="al-filter-input"
               value="{{ request('sampai') }}" style="width:140px;">
    </div>
    <div style="display:flex;gap:8px;align-items:flex-end;">
        <button type="submit" class="al-btn-filter">Terapkan</button>
        <a href="{{ route('owner.audit-log.index') }}" class="al-btn-reset" style="display:flex;align-items:center;height:34px;padding:0 12px;text-decoration:none;">Reset</a>
    </div>
</form>
 
{{-- ── LOG LIST ── --}}
<div class="al-panel">
    <div class="al-panel-head">
        <div>
            <div class="al-panel-title">🛡️ Riwayat Aktivitas</div>
            <div class="al-panel-meta">{{ $logs->total() }} log ditemukan</div>
        </div>
        <a href="{{ route('owner.audit-log.export', request()->query()) }}" class="al-export-btn">
            ⬇️ Export CSV
        </a>
    </div>
 
    @forelse($logs as $log)
        @php
            $aksi = $aksiMap[$log->aksi] ?? [
                'color'  => '#94a3b8',
                'bg'     => 'rgba(148,163,184,.12)',
                'border' => 'rgba(148,163,184,.2)',
                'icon'   => '📌',
                'label'  => $log->aksi,
            ];
 
            $oldData = $log->old_data ? json_decode($log->old_data, true) : null;
            $newData = $log->new_data ? json_decode($log->new_data, true) : null;
            $allKeys = array_unique(array_merge(
                array_keys($oldData ?? []),
                array_keys($newData ?? [])
            ));
        @endphp
 
        <div class="al-item" onclick="openAuditModal({{ $log->id }})">
 
            {{-- Accent kiri --}}
            <div class="al-accent" style="background:{{ $aksi['color'] }}"></div>
 
            {{-- Avatar --}}
            <div class="al-avatar" style="background:{{ $aksi['bg'] }};color:{{ $aksi['color'] }};border:1px solid {{ $aksi['border'] }}">
                {{ strtoupper(substr($log->nama ?? 'U', 0, 2)) }}
            </div>
 
            {{-- Body --}}
            <div class="al-body">
                {{-- Baris 1: nama + badge aksi + modul --}}
                <div class="al-top">
                    <span class="al-name">{{ $log->nama ?? 'Unknown' }}</span>
                    <span class="al-badge" style="background:{{ $aksi['bg'] }};color:{{ $aksi['color'] }};border:1px solid {{ $aksi['border'] }}">
                        {{ $aksi['icon'] }} {{ $aksi['label'] }}
                    </span>
                    @if($log->modul)
                        <span class="al-module-badge">{{ $log->modul }}</span>
                    @endif
                </div>
 
                {{-- Keterangan --}}
                @if($log->keterangan)
                    <div style="font-size:12px;color:rgba(255,255,255,.45);margin-bottom:4px;">
                        {{ $log->keterangan }}
                    </div>
                @endif
 
                {{-- Meta: IP + Lokasi + Browser ── DARI MANA ── --}}
                <div class="al-meta-row">
                    @if($log->ip_address)
                        <span class="al-meta-item">
                            🌐 <span style="font-family:'JetBrains Mono',monospace;font-size:11px;">{{ $log->ip_address }}</span>
                        </span>
                    @endif
                    @if($log->lokasi)
                        <span class="al-meta-item">📍 {{ $log->lokasi }}</span>
                    @endif
                    @if($log->browser)
                        <span class="al-meta-item">🖥️ {{ $log->browser }}</span>
                    @endif
                    @if($log->email)
                        <span class="al-meta-item">✉️ {{ $log->email }}</span>
                    @endif
                </div>
 
                {{-- Diff preview ── DATA APA YANG BERUBAH ── --}}
                @if($oldData || $newData)
                    <div class="al-diff">
                        @if($log->aksi === 'CREATE' && $newData)
                            @foreach(array_slice($newData, 0, 3) as $key => $val)
                                <span class="diff-new">{{ $key }}: {{ $val }}</span>
                            @endforeach
                            @if(count($newData) > 3)
                                <span style="font-size:10px;color:rgba(255,255,255,.3);">+{{ count($newData) - 3 }} lagi</span>
                            @endif
                        @elseif($log->aksi === 'DELETE' && $oldData)
                            <span style="font-size:11px;color:#FF4B6E;">🗑️ Data dihapus permanen</span>
                        @elseif($oldData && $newData)
                            @foreach(array_slice($allKeys, 0, 2) as $key)
                                @if(isset($oldData[$key]) || isset($newData[$key]))
                                    <span style="font-size:10px;color:rgba(255,255,255,.35);">{{ $key }}:</span>
                                    @if(isset($oldData[$key]))
                                        <span class="diff-old">{{ $oldData[$key] }}</span>
                                    @endif
                                    <span class="diff-arrow">→</span>
                                    @if(isset($newData[$key]))
                                        <span class="diff-new">{{ $newData[$key] }}</span>
                                    @endif
                                @endif
                            @endforeach
                            @if(count($allKeys) > 2)
                                <span style="font-size:10px;color:rgba(255,255,255,.3);">+{{ count($allKeys) - 2 }} field lain</span>
                            @endif
                        @endif
                    </div>
                @endif
 
                <button class="al-detail-btn" onclick="event.stopPropagation();openAuditModal({{ $log->id }})">
                    Detail →
                </button>
            </div>
 
            {{-- Waktu ── KAPAN ── --}}
            <div class="al-time">
                <div class="al-time-main">{{ $log->waktu->format('H:i') }}</div>
                <div class="al-time-date">{{ $log->waktu->format('d M Y') }}</div>
                <div class="al-time-rel">{{ $log->waktu->diffForHumans() }}</div>
            </div>
 
        </div>
 
    @empty
        <div class="al-empty">
            🔍 Tidak ada log yang ditemukan
        </div>
    @endforelse
 
    {{-- Pagination --}}
    @if($logs->hasPages())
        <div class="al-pagination">
            <div class="al-pagination-info">
                Menampilkan {{ $logs->firstItem() }}–{{ $logs->lastItem() }} dari {{ $logs->total() }} log
            </div>
            <div style="display:flex;gap:6px;flex-wrap:wrap;">
                {{-- Prev --}}
                <a href="{{ $logs->previousPageUrl() }}"
                   class="al-page-link {{ $logs->onFirstPage() ? 'disabled' : '' }}">‹</a>
 
                {{-- Page numbers --}}
                @for($i = 1; $i <= $logs->lastPage(); $i++)
                    <a href="{{ $logs->url($i) }}"
                       class="al-page-link {{ $logs->currentPage() === $i ? 'active' : '' }}">
                        {{ $i }}
                    </a>
                @endfor
 
                {{-- Next --}}
                <a href="{{ $logs->nextPageUrl() }}"
                   class="al-page-link {{ !$logs->hasMorePages() ? 'disabled' : '' }}">›</a>
            </div>
        </div>
    @endif
</div>
 
{{-- ── MODAL DETAIL ── --}}
<div class="al-modal-overlay" id="auditModalOverlay" onclick="closeAuditModal(event)">
    <div class="al-modal" id="auditModalBox">
        <div class="al-modal-head">
            <div class="al-modal-title" id="auditModalTitle">Detail Log</div>
            <div class="al-modal-close" onclick="closeAuditModalDirect()">✕</div>
        </div>
        <div class="al-modal-body" id="auditModalBody">
            <div style="text-align:center;padding:2rem;color:rgba(255,255,255,.3);">Memuat...</div>
        </div>
    </div>
</div>
 
{{-- Data untuk modal (JSON dari server) --}}
<script>
const AUDIT_DATA = @json($logs->items());
const AKSI_MAP   = @json($aksiMap);
 
function openAuditModal(id) {
    const log = AUDIT_DATA.find(l => l.id === id);
    if (!log) return;
 
    const aksi = AKSI_MAP[log.aksi] ?? { color:'#94a3b8', bg:'rgba(148,163,184,.12)', border:'rgba(148,163,184,.2)', icon:'📌', label: log.aksi };
    const oldData = log.old_data ? JSON.parse(log.old_data) : null;
    const newData = log.new_data ? JSON.parse(log.new_data) : null;
    const allKeys = [...new Set([...Object.keys(oldData||{}), ...Object.keys(newData||{})])];
 
    document.getElementById('auditModalTitle').textContent = `Detail Log #${String(id).padStart(5,'0')}`;
 
    let diffHTML = '';
    if (allKeys.length > 0) {
        diffHTML = `
        <div class="al-modal-section">
            <div class="al-modal-section-title">🔄 Perubahan Data</div>
            <table class="al-diff-table">
                <thead><tr><th>Field</th><th>Data Lama</th><th>Data Baru</th></tr></thead>
                <tbody>
                    ${allKeys.map(k => `
                    <tr>
                        <td class="al-diff-field">${k}</td>
                        <td>${oldData && oldData[k] !== undefined
                            ? `<span class="diff-old">${oldData[k]}</span>`
                            : '<span style="color:rgba(255,255,255,.25);font-size:11px;">–</span>'}</td>
                        <td>${newData && newData[k] !== undefined
                            ? `<span class="diff-new">${newData[k]}</span>`
                            : '<span style="color:rgba(255,255,255,.25);font-size:11px;">–</span>'}</td>
                    </tr>`).join('')}
                </tbody>
            </table>
        </div>`;
    } else {
        diffHTML = `
        <div class="al-modal-section">
            <div class="al-modal-section-title">🔄 Perubahan Data</div>
            <div style="font-size:13px;color:rgba(255,255,255,.35);padding:6px 0;">Tidak ada perubahan data.</div>
        </div>`;
    }
 
    document.getElementById('auditModalBody').innerHTML = `
        <div class="al-modal-section">
            <div class="al-modal-section-title">👤 Siapa yang Melakukan</div>
            <div class="al-modal-row"><span class="al-modal-key">Nama</span><span class="al-modal-val">${log.nama ?? '–'}</span></div>
            <div class="al-modal-row"><span class="al-modal-key">Email</span><span class="al-modal-val" style="color:rgba(255,255,255,.6)">${log.email ?? '–'}</span></div>
            <div class="al-modal-row"><span class="al-modal-key">Role</span><span class="al-modal-val">${log.role ?? '–'}</span></div>
            <div class="al-modal-row">
                <span class="al-modal-key">Aksi</span>
                <span class="al-modal-val">
                    <span class="al-badge" style="background:${aksi.bg};color:${aksi.color};border:1px solid ${aksi.border}">
                        ${aksi.icon} ${aksi.label}
                    </span>
                </span>
            </div>
        </div>
        <div class="al-modal-section">
            <div class="al-modal-section-title">📦 Apa yang Dilakukan</div>
            <div class="al-modal-row"><span class="al-modal-key">Modul</span><span class="al-modal-val">${log.modul ? `<span class="al-module-badge">${log.modul}</span>` : '–'}</span></div>
            <div class="al-modal-row"><span class="al-modal-key">Keterangan</span><span class="al-modal-val" style="color:rgba(255,255,255,.6)">${log.keterangan ?? '–'}</span></div>
        </div>
        <div class="al-modal-section">
            <div class="al-modal-section-title">🕐 Kapan Dilakukan</div>
            <div class="al-modal-row"><span class="al-modal-key">Waktu</span><span class="al-modal-val">${log.waktu ?? '–'}</span></div>
        </div>
        <div class="al-modal-section">
            <div class="al-modal-section-title">🌐 Dari Mana</div>
            <div class="al-modal-row"><span class="al-modal-key">IP Address</span><span class="al-modal-val" style="font-family:'JetBrains Mono',monospace;font-size:12px;">${log.ip_address ?? '–'}</span></div>
            <div class="al-modal-row"><span class="al-modal-key">Lokasi</span><span class="al-modal-val">${log.lokasi ?? '–'}</span></div>
            <div class="al-modal-row"><span class="al-modal-key">Browser</span><span class="al-modal-val">${log.browser ?? '–'}</span></div>
            <div class="al-modal-row"><span class="al-modal-key">OS</span><span class="al-modal-val">${log.os ?? '–'}</span></div>
        </div>
        ${diffHTML}
    `;
 
    document.getElementById('auditModalOverlay').classList.add('show');
}
 
function closeAuditModal(e) {
    if (e.target === document.getElementById('auditModalOverlay')) closeAuditModalDirect();
}
function closeAuditModalDirect() {
    document.getElementById('auditModalOverlay').classList.remove('show');
}
</script>
 
@endsection