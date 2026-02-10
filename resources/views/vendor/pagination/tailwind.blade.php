@if ($paginator->hasPages())
    <div class="flex flex-col items-center space-y-4">
        {{-- Pagination Buttons --}}
        <div class="flex items-center space-x-2">
            {{-- Previous Button --}}
            @if ($paginator->onFirstPage())
                <span class="px-4 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 rounded-lg cursor-not-allowed">
                    Previous
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Previous
                </a>
            @endif

            {{-- Page Numbers --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-4 py-2 text-sm font-medium text-gray-700">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Button --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Next
                </a>
            @else
                <span class="px-4 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 rounded-lg cursor-not-allowed">
                    Next
                </span>
            @endif
        </div>

        {{-- Results Info --}}
        <div class="text-sm text-gray-600">
            Showing <span class="font-semibold text-gray-900">{{ $paginator->firstItem() }}</span> to <span class="font-semibold text-gray-900">{{ $paginator->lastItem() }}</span> of <span class="font-semibold text-gray-900">{{ $paginator->total() }}</span> results
        </div>
    </div>
@endif
