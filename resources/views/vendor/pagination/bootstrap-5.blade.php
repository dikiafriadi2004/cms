@if ($paginator->hasPages())
    <div class="paginations text-center mt-30">
        <ul>
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled"><a href="javascript:;"><i class="fa-solid fa-angle-left"></i></a></li>
            @else
            <li><a href="{{ $paginator->previousPageUrl() }}"><i class="fa-solid fa-angle-left"></i></a></li>
            @endif

             {{-- Pagination Elements --}}
             @foreach ($elements as $element)
             {{-- "Three Dots" Separator --}}
             @if (is_string($element))
                 <li class="disabled"><a href="javascript:;">{{ $element }}</a></li>
             @endif

             {{-- Array Of Links --}}
             @if (is_array($element))
                 @foreach ($element as $page => $url)
                     @if ($page == $paginator->currentPage())
                         <li class="active"><a href="javascript:;">{{ $page }}</a></li>
                     @else
                         <li><a href="{{ $url }}">{{ $page }}</a></li>
                     @endif
                 @endforeach
             @endif
         @endforeach


            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li><a href="{{ $paginator->nextPageUrl() }}"><i class="fa-solid fa-angle-right"></i></a></li>
            @else
                <li class="disabled"><a href="javascript:;"><i class="fa-solid fa-angle-right"></i></a></li>
            @endif

            {{-- Next Page Link --}}
        </ul>
    </div>
@endif