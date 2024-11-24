<!-- Pagination -->
<div class="flex justify-center mt-4">
    <nav aria-label="Pagination">
        <ul class="inline-flex -space-x-px">
            {{-- Previous Page Link --}}
            @if ($inquiries->onFirstPage())
                <li>
                    <span class="px-3 py-2 text-gray-500 cursor-not-allowed">Previous</span>
                </li>
            @else
                <li>
                    <a href="{{ $inquiries->previousPageUrl() }}" class="px-3 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-l hover:bg-gray-100">Previous</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($inquiries->links()->elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li>
                        <span class="px-3 py-2 text-gray-500 cursor-not-allowed">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $inquiries->currentPage())
                            <li>
                                <span class="px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded">{{ $page }}</span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}" class="px-3 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-300 hover:bg-gray-100">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($inquiries->hasMorePages())
                <li>
                    <a href="{{ $inquiries->nextPageUrl() }}" class="px-3 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-r hover:bg-gray-100">Next</a>
                </li>
            @else
                <li>
                    <span class="px-3 py-2 text-gray-500 cursor-not-allowed">Next</span>
                </li>
            @endif
        </ul>
    </nav>
</div>
