@if ($paginator->hasPages())
<nav class="flex justify-center items-center space-x-3 mt-6 text-gray-600 text-2xl">
    {{-- Previous --}}
    @if ($paginator->onFirstPage())
        <span class="cursor-not-allowed select-none px-3 py-1 rounded">&laquo;</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 px-3 py-1 rounded">&laquo;</a>
    @endif

    {{-- Pages --}}
    @foreach ($elements as $element)
        @if (is_string($element))
            <span class="px-2 select-none">…</span>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="px-4 py-2 font-bold text-white bg-info rounded shadow select-none">{{ $page }}</span> {{-- Active page: bigger padding, bg, rounded, shadow --}}
                @else
                    <a href="{{ $url }}" class="px-3 py-1 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 px-3 py-1 rounded">&raquo;</a>
    @else
        <span class="cursor-not-allowed select-none px-3 py-1 rounded">&raquo;</span>
    @endif
</nav>
@endif
