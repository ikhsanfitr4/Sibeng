@if ($paginator->hasPages())
<div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.75rem">

    {{-- Info --}}
    <div style="font-size:.78rem;color:var(--muted)">
        Menampilkan
        <strong style="color:var(--text)">{{ $paginator->firstItem() }}</strong>
        –
        <strong style="color:var(--text)">{{ $paginator->lastItem() }}</strong>
        dari
        <strong style="color:var(--text)">{{ $paginator->total() }}</strong>
        data
    </div>

    {{-- Buttons --}}
    <div style="display:flex;align-items:center;gap:.35rem;flex-wrap:wrap">

        {{-- Previous --}}
        @if ($paginator->onFirstPage())
        <span style="padding:.4rem .85rem;border-radius:8px;font-size:.8rem;font-weight:600;background:rgba(255,255,255,.03);border:1px solid var(--glass-border);color:rgba(255,255,255,.2);cursor:not-allowed;user-select:none">
            ‹ Prev
        </span>
        @else
        <a href="{{ $paginator->previousPageUrl() }}"
            style="padding:.4rem .85rem;border-radius:8px;font-size:.8rem;font-weight:600;background:var(--glass-bg);border:1px solid var(--glass-border);color:var(--muted);text-decoration:none;transition:all .2s;display:inline-block"
            onmouseover="this.style.color='var(--text)';this.style.borderColor='rgba(255,255,255,.2)';this.style.background='var(--glass-hover)'"
            onmouseout="this.style.color='var(--muted)';this.style.borderColor='var(--glass-border)';this.style.background='var(--glass-bg)'">
            ‹ Prev
        </a>
        @endif

        {{-- Page Numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
            <span style="padding:.4rem .5rem;font-size:.8rem;color:var(--muted)">…</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                    <span style="padding:.4rem .75rem;border-radius:8px;font-size:.8rem;font-weight:700;background:linear-gradient(135deg,var(--primary),#FF7A29);color:#fff;border:1px solid transparent;box-shadow:0 2px 8px var(--primary-glow);display:inline-block">
                        {{ $page }}
                    </span>
                    @else
                    <a href="{{ $url }}"
                        style="padding:.4rem .75rem;border-radius:8px;font-size:.8rem;font-weight:600;background:var(--glass-bg);border:1px solid var(--glass-border);color:var(--muted);text-decoration:none;transition:all .2s;display:inline-block"
                        onmouseover="this.style.color='var(--text)';this.style.borderColor='rgba(255,255,255,.2)';this.style.background='var(--glass-hover)'"
                        onmouseout="this.style.color='var(--muted)';this.style.borderColor='var(--glass-border)';this.style.background='var(--glass-bg)'">
                        {{ $page }}
                    </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}"
            style="padding:.4rem .85rem;border-radius:8px;font-size:.8rem;font-weight:600;background:var(--glass-bg);border:1px solid var(--glass-border);color:var(--muted);text-decoration:none;transition:all .2s;display:inline-block"
            onmouseover="this.style.color='var(--text)';this.style.borderColor='rgba(255,255,255,.2)';this.style.background='var(--glass-hover)'"
            onmouseout="this.style.color='var(--muted)';this.style.borderColor='var(--glass-border)';this.style.background='var(--glass-bg)'">
            Next ›
        </a>
        @else
        <span style="padding:.4rem .85rem;border-radius:8px;font-size:.8rem;font-weight:600;background:rgba(255,255,255,.03);border:1px solid var(--glass-border);color:rgba(255,255,255,.2);cursor:not-allowed;user-select:none">
            Next ›
        </span>
        @endif

    </div>
</div>
@endif