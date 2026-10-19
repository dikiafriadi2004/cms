{{--
    Pagination view — hanya render tombol navigasi halaman.
    Info "Menampilkan X-Y dari Z" ditampilkan oleh per-page-selector partial.
    Dipakai bersama container: flex justify-between, selector di kiri, nav di kanan.
--}}
@if ($paginator->hasPages())
<div class="flex items-center gap-1">

    {{-- Prev --}}
    @if ($paginator->onFirstPage())
        <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-gray-200 bg-gray-100 text-gray-300 cursor-not-allowed select-none" aria-disabled="true">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Sebelumnya"
           class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-gray-200 bg-white text-gray-600 hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
    @endif

    {{-- Nomor halaman --}}
    @foreach ($elements as $element)
        @if (is_string($element))
            <span class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 select-none">&hellip;</span>
        @endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span aria-current="page" class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-blue-500 bg-blue-600 text-white text-sm font-semibold shadow-sm select-none">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" aria-label="Halaman {{ $page }}"
                       class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-gray-200 bg-white text-gray-600 text-sm font-medium hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600 transition-colors">
                        {{ $page }}
                    </a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Berikutnya"
           class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-gray-200 bg-white text-gray-600 hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    @else
        <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-gray-200 bg-gray-100 text-gray-300 cursor-not-allowed select-none" aria-disabled="true">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </span>
    @endif

</div>
@endif
