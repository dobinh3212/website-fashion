@if ($paginator->hasPages())
    <nav>
        <ul class="list-unstyled list-inline pages">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
{{--                    <span class="page-link" aria-hidden="true">&lsaquo;</span>--}}
                         <a href="" aria-hidden="true"><i class="fa fa-caret-left"></i></a>
                </li>
            @else
                <li class="page-item">
                    <a  href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"><i class="fa fa-caret-left"></i></a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="" aria-disabled="true">
{{--                        <span class="page-link">{{ $element }}</span>--}}
                        <a href="">{{ $element }}</a>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
{{--                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>--}}
                            <li class="active" aria-current="page" ><a href=""> {{ $page }}</a> </li>
                        @else
                            <li class=""><a href="{{ $url }}"> {{ $page }}</a> </li>
{{--                            <li class="page-item"> <a class="page-link" href="{{ $url }}">{{ $page }}</a></li>--}}
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')"><i class="fa fa-caret-right"></i></a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
{{--                    <span class="page-link" aria-hidden="true"><i class="fa fa-caret-left"></i></span>--}}
                    <a href="" aria-hidden="true"><i class="fa fa-caret-right"></i></a>
                </li>
            @endif
        </ul>
    </nav>
@endif
