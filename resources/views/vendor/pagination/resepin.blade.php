@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="flex justify-center">
        <ul class="inline-flex items-center gap-2 rounded-2xl bg-white/90 px-3 py-2 shadow-sm ring-1 ring-resepin-tomato/15 backdrop-blur">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="flex h-10 w-10 items-center justify-center rounded-xl text-gray-300 ring-1 ring-gray-200">
                    <span aria-hidden="true">&larr;</span>
                    <span class="sr-only">Previous</span>
                </li>
            @else
                <li>
                    <a
                        href="{{ $paginator->previousPageUrl() }}"
                        rel="prev"
                        class="flex h-10 w-10 items-center justify-center rounded-xl text-resepin-tomato ring-1 ring-resepin-tomato/30 transition hover:bg-resepin-cream/70 hover:ring-resepin-tomato/60 focus:outline-none focus:ring-2 focus:ring-resepin-tomato/50"
                    >
                        <span aria-hidden="true">&larr;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="px-3 py-2 text-sm font-semibold text-gray-400">{{ $element }}</li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span class="flex h-10 min-w-[2.5rem] items-center justify-center rounded-xl bg-resepin-tomato px-3 text-sm font-semibold text-white shadow-sm shadow-resepin-tomato/30">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li>
                                <a
                                    href="{{ $url }}"
                                    class="flex h-10 min-w-[2.5rem] items-center justify-center rounded-xl px-3 text-sm font-semibold text-gray-700 transition hover:bg-resepin-cream/70 hover:text-resepin-tomato focus:outline-none focus:ring-2 focus:ring-resepin-tomato/40"
                                >
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a
                        href="{{ $paginator->nextPageUrl() }}"
                        rel="next"
                        class="flex h-10 w-10 items-center justify-center rounded-xl text-resepin-tomato ring-1 ring-resepin-tomato/30 transition hover:bg-resepin-cream/70 hover:ring-resepin-tomato/60 focus:outline-none focus:ring-2 focus:ring-resepin-tomato/50"
                    >
                        <span aria-hidden="true">&rarr;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            @else
                <li class="flex h-10 w-10 items-center justify-center rounded-xl text-gray-300 ring-1 ring-gray-200">
                    <span aria-hidden="true">&rarr;</span>
                    <span class="sr-only">Next</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
