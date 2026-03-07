@if ($paginator->hasPages())
    <div class="flex justify-center items-center gap-3">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="w-12 h-12 flex items-center justify-center rounded-2xl bg-white border border-slate-200 text-slate-300 font-bold cursor-not-allowed">&larr;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="w-12 h-12 flex items-center justify-center rounded-2xl bg-white border border-slate-200 text-slate-400 hover:border-brand-600 hover:text-brand-600 transition font-bold">&larr;</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="w-12 h-12 flex items-center justify-center text-slate-400">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="w-12 h-12 flex items-center justify-center rounded-2xl bg-brand-600 text-white font-bold shadow-lg shadow-brand-600/30">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="w-12 h-12 flex items-center justify-center rounded-2xl bg-white border border-slate-200 text-slate-600 hover:border-brand-600 hover:text-brand-600 transition font-bold">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="w-12 h-12 flex items-center justify-center rounded-2xl bg-white border border-slate-200 text-slate-400 hover:border-brand-600 hover:text-brand-600 transition font-bold">&rarr;</a>
        @else
            <span class="w-12 h-12 flex items-center justify-center rounded-2xl bg-white border border-slate-200 text-slate-300 font-bold cursor-not-allowed">&rarr;</span>
        @endif
    </div>
@endif
