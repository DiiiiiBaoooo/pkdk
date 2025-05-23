@if ($paginator->hasPages())
    <nav class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="page-item disabled">
                <span class="page-link">Trước</span>
            </span>
        @else
            <span class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">Trước</a>
            </span>
        @endif

        {{-- Current Page Number --}}
        <span class="page-item">
            <span class="page-link">
                Trang {{ $paginator->currentPage() }}
            </span>
        </span>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <span class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Sau</a>
            </span>
        @else
            <span class="page-item disabled">
                <span class="page-link">Sau</span>
            </span>
        @endif
    </nav>
@endif 