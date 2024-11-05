@if ($paginator->hasPages())
<div class="flex flex-wrap justify-between items-center text-left">
    <div>
        <p class="text-sm text-gray-700 leading-5 dark:text-gray-400">
            {!! __('Showing') !!}
            @if ($paginator->firstItem())
                <span class="font-medium">{{ $paginator->firstItem() }}</span>
                {!! __('to') !!}
                <span class="font-medium">{{ $paginator->lastItem() }}</span>
            @else
                {{ $paginator->count() }}
            @endif
            {!! __('of') !!}
            <span class="font-medium">{{ $paginator->total() }}</span>
            {!! __('results') !!}
        </p>
    </div>
</div>
    <nav class="w-full sm:w-auto sm:ml-auto">
        <ul class="pagination">
            @if ($paginator->onFirstPage())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}"> <i class="w-4 h-4"
                            data-lucide="chevrons-left"></i> </a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}"> <i class="w-4 h-4"
                            data-lucide="chevron-left"></i> </a>
                </li>
            @endif
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span aria-disabled="true">
                        <span
                            class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5 dark:bg-gray-800 dark:border-gray-600">{{ $element }}</span>
                    </span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active"> <a class="page-link"
                                    href="{{ $url }}">{{ $page }}</a> </li>
                        @else
                            <li class="page-item"> <a class="page-link"
                                    href="{{ $url }}">{{ $page }}</a> </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}"> <i class="w-4 h-4"
                            data-lucide="chevron-right"></i> </a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}"> <i class="w-4 h-4"
                            data-lucide="chevrons-right"></i> </a>
                </li>
            @endif
    </nav>
@endif