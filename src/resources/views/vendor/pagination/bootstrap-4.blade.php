@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span class="page-link">＜</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}">＜</a></li>
        @endif

        {{-- Numbers --}}
        @foreach ($elements as $element)
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}">＞</a></li>
        @else
            <li class="page-item disabled"><span class="page-link">＞</span></li>
        @endif
    </ul>
@endif
