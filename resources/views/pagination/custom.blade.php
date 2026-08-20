@if ($paginator->hasPages())
<div class="pagination">
    @if ($paginator->onFirstPage())
        <button class="arrow" disabled>‹</button>
    @else
        <a href="{{ $paginator->previousPageUrl() }}"><button class="arrow">‹</button></a>
    @endif

    @foreach ($elements as $element)
        @if (is_string($element))
            <button disabled>{{ $element }}</button>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
                <a href="{{ $url }}"><button class="{{ $page == $paginator->currentPage() ? 'active' : '' }}">{{ $page }}</button></a>
            @endforeach
        @endif
    @endforeach

    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}"><button class="arrow">›</button></a>
    @else
        <button class="arrow" disabled>›</button>
    @endif
</div>
@endif