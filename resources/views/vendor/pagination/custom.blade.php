{{-- Variasi 4: Card Style dengan Info Tambahan --}}
@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="mt-8">
        <div class="bg-white rounded-xl shadow-sm border border-green-100 p-4">
            <div class="flex items-center justify-end">
                {{-- Pagination Controls --}}
                <div class="flex items-center space-x-2">
                    {{-- Tombol Previous --}}
                    @if ($paginator->onFirstPage())
                        <button disabled class="px-3 py-1.5 text-gray-400 bg-gray-50 rounded-md cursor-not-allowed text-sm">
                            Previous
                        </button>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" 
                           class="px-3 py-1.5 text-green-600 bg-green-50 rounded-md hover:bg-green-100 transition-colors duration-200 text-sm">
                            Previous
                        </a>
                    @endif

                    {{-- Link Halaman --}}
                    @foreach ($elements as $element)
                        {{-- Separator --}}
                        @if (is_string($element))
                            <span class="px-2 text-gray-400">...</span>
                        @endif

                        {{-- Array Halaman --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span class="px-3 py-1.5 bg-gradient-to-r from-green-500 to-emerald-500 text-white rounded-md text-sm font-medium">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" 
                                       class="px-3 py-1.5 text-gray-600 hover:bg-green-50 rounded-md transition-colors duration-200 text-sm">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Tombol Next --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" 
                           class="px-3 py-1.5 text-green-600 bg-green-50 rounded-md hover:bg-green-100 transition-colors duration-200 text-sm">
                            Next
                        </a>
                    @else
                        <button disabled class="px-3 py-1.5 text-gray-400 bg-gray-50 rounded-md cursor-not-allowed text-sm">
                            Next
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </nav>
@endif