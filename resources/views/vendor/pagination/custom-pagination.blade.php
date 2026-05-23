@if ($paginator->hasPages())
    <div class="ul-pagination mt-0 border-top-0">
        <ul>
            <!-- Previous Page Link -->
            @if ($paginator->onFirstPage())
                <li class="disabled"><span><i class="flaticon-left-arrow"></i></span></li>
            @else
                <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="flaticon-left-arrow"></i></a></li>
            @endif

            <!-- Pagination Elements -->
            <li class="pages">
                @foreach ($elements as $element)
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <a href="#" class="active">{{ $page }}</a>
                            @else
                                <a href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </li>

            <!-- Next Page Link -->
            @if ($paginator->hasMorePages())
                <li><a href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="flaticon-next-1"></i></a></li>
            @else
                <li class="disabled"><span><i class="flaticon-next-1"></i></span></li>
            @endif
        </ul>
    </div>
@endif