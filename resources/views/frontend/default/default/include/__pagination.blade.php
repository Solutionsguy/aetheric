@if ($paginator->hasPages())
<div class="table-pagination">
    <div class="content">
        <p>Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} entries</p>
    </div>
    <div class="basic-pagination">
        <nav>
            <ul>
                @if ($paginator->onFirstPage())
                <li>
                    <a href="#">
                        <i class="fa-regular fa-chevron-left"></i>
                    </a>
                </li>
                @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}">
                        <i class="fa-regular fa-chevron-left"></i>
                    </a>
                </li>
                @endif

                @foreach ($elements as $element)
                    @if (is_string($element))
                    <li>
                        <a class="current" href="#">{{ $element }}</a>
                    </li>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                            <li>
                                <a class="current" href="#">{{ $page }}</a>
                            </li>            
                            @else
                            <li>
                                <a href="{{ $url }}">{{ $page }}</a>
                            </li>           
                            @endif
                        @endforeach
                    @endif
                @endforeach


                @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}">
                        <i class="fa-regular fa-chevron-right"></i>
                    </a>
                </li>
                @else
                <li>
                    <a href="#">
                        <i class="fa-regular fa-chevron-right"></i>
                    </a>
                </li>
                @endif
            </ul>
        </nav>
    </div>
</div>
@endif