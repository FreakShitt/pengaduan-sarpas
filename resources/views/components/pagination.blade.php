@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" style="display: flex; justify-content: space-between; align-items: center; margin-top: 2rem; padding: 1.5rem; background: var(--color-gray-50); border-radius: 12px; border: 2px solid var(--color-gray-200);">
        {{-- Mobile Info --}}
        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
            <div style="font-size: 0.875rem; color: var(--color-gray-600);">
                Menampilkan <strong style="color: var(--color-gray-900);">{{ $paginator->firstItem() }}</strong> - <strong style="color: var(--color-gray-900);">{{ $paginator->lastItem() }}</strong> dari <strong style="color: var(--color-gray-900);">{{ $paginator->total() }}</strong> data
            </div>
            <div style="font-size: 0.8125rem; color: var(--color-gray-500);">
                Halaman {{ $paginator->currentPage() }} dari {{ $paginator->lastPage() }}
            </div>
        </div>

        {{-- Desktop Pagination --}}
        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap; align-items: center;">
            {{-- First Page --}}
            @if ($paginator->onFirstPage())
                <button disabled style="padding: 0.5rem 1rem; border: 2px solid var(--color-gray-300); background: var(--color-gray-100); color: var(--color-gray-400); border-radius: 8px; font-weight: 600; cursor: not-allowed; font-size: 0.875rem;">
                    ⟨⟨ First
                </button>
            @else
                <a href="{{ $paginator->url(1) }}" style="padding: 0.5rem 1rem; border: 2px solid var(--color-gray-300); background: white; color: var(--color-gray-700); border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.2s; font-size: 0.875rem;" 
                   onmouseover="this.style.background='var(--color-gray-900)'; this.style.color='white'; this.style.borderColor='var(--color-gray-900)';"
                   onmouseout="this.style.background='white'; this.style.color='var(--color-gray-700)'; this.style.borderColor='var(--color-gray-300)';">
                    ⟨⟨ First
                </a>
            @endif

            {{-- Previous Page --}}
            @if ($paginator->onFirstPage())
                <button disabled style="padding: 0.5rem 1rem; border: 2px solid var(--color-gray-300); background: var(--color-gray-100); color: var(--color-gray-400); border-radius: 8px; font-weight: 600; cursor: not-allowed; font-size: 0.875rem;">
                    ⟨ Prev
                </button>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" style="padding: 0.5rem 1rem; border: 2px solid var(--color-gray-300); background: white; color: var(--color-gray-700); border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.2s; font-size: 0.875rem;"
                   onmouseover="this.style.background='var(--color-gray-900)'; this.style.color='white'; this.style.borderColor='var(--color-gray-900)';"
                   onmouseout="this.style.background='white'; this.style.color='var(--color-gray-700)'; this.style.borderColor='var(--color-gray-300)';">
                    ⟨ Prev
                </a>
            @endif

            {{-- Page Numbers --}}
            @php
                $currentPage = $paginator->currentPage();
                $lastPage = $paginator->lastPage();
                $start = max(1, $currentPage - 2);
                $end = min($lastPage, $currentPage + 2);
                
                // Adjust if at beginning
                if ($currentPage <= 3) {
                    $end = min(5, $lastPage);
                }
                
                // Adjust if at end
                if ($currentPage >= $lastPage - 2) {
                    $start = max(1, $lastPage - 4);
                }
            @endphp

            {{-- First page ellipsis --}}
            @if($start > 1)
                <a href="{{ $paginator->url(1) }}" style="padding: 0.5rem 0.875rem; border: 2px solid var(--color-gray-300); background: white; color: var(--color-gray-700); border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.2s; min-width: 40px; text-align: center; font-size: 0.875rem;"
                   onmouseover="this.style.background='var(--color-gray-900)'; this.style.color='white'; this.style.borderColor='var(--color-gray-900)';"
                   onmouseout="this.style.background='white'; this.style.color='var(--color-gray-700)'; this.style.borderColor='var(--color-gray-300)';">
                    1
                </a>
                @if($start > 2)
                    <span style="padding: 0.5rem 0.5rem; color: var(--color-gray-500); font-weight: 600;">...</span>
                @endif
            @endif

            {{-- Page Number Links --}}
            @for ($i = $start; $i <= $end; $i++)
                @if ($i == $currentPage)
                    <button style="padding: 0.5rem 0.875rem; border: 2px solid var(--color-gray-900); background: var(--color-gray-900); color: white; border-radius: 8px; font-weight: 600; cursor: default; min-width: 40px; text-align: center; font-size: 0.875rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                        {{ $i }}
                    </button>
                @else
                    <a href="{{ $paginator->url($i) }}" style="padding: 0.5rem 0.875rem; border: 2px solid var(--color-gray-300); background: white; color: var(--color-gray-700); border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.2s; min-width: 40px; text-align: center; font-size: 0.875rem;"
                       onmouseover="this.style.background='var(--color-gray-900)'; this.style.color='white'; this.style.borderColor='var(--color-gray-900)';"
                       onmouseout="this.style.background='white'; this.style.color='var(--color-gray-700)'; this.style.borderColor='var(--color-gray-300)';">
                        {{ $i }}
                    </a>
                @endif
            @endfor

            {{-- Last page ellipsis --}}
            @if($end < $lastPage)
                @if($end < $lastPage - 1)
                    <span style="padding: 0.5rem 0.5rem; color: var(--color-gray-500); font-weight: 600;">...</span>
                @endif
                <a href="{{ $paginator->url($lastPage) }}" style="padding: 0.5rem 0.875rem; border: 2px solid var(--color-gray-300); background: white; color: var(--color-gray-700); border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.2s; min-width: 40px; text-align: center; font-size: 0.875rem;"
                   onmouseover="this.style.background='var(--color-gray-900)'; this.style.color='white'; this.style.borderColor='var(--color-gray-900)';"
                   onmouseout="this.style.background='white'; this.style.color='var(--color-gray-700)'; this.style.borderColor='var(--color-gray-300)';">
                    {{ $lastPage }}
                </a>
            @endif

            {{-- Next Page --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" style="padding: 0.5rem 1rem; border: 2px solid var(--color-gray-300); background: white; color: var(--color-gray-700); border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.2s; font-size: 0.875rem;"
                   onmouseover="this.style.background='var(--color-gray-900)'; this.style.color='white'; this.style.borderColor='var(--color-gray-900)';"
                   onmouseout="this.style.background='white'; this.style.color='var(--color-gray-700)'; this.style.borderColor='var(--color-gray-300)';">
                    Next ⟩
                </a>
            @else
                <button disabled style="padding: 0.5rem 1rem; border: 2px solid var(--color-gray-300); background: var(--color-gray-100); color: var(--color-gray-400); border-radius: 8px; font-weight: 600; cursor: not-allowed; font-size: 0.875rem;">
                    Next ⟩
                </button>
            @endif

            {{-- Last Page --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->url($paginator->lastPage()) }}" style="padding: 0.5rem 1rem; border: 2px solid var(--color-gray-300); background: white; color: var(--color-gray-700); border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.2s; font-size: 0.875rem;"
                   onmouseover="this.style.background='var(--color-gray-900)'; this.style.color='white'; this.style.borderColor='var(--color-gray-900)';"
                   onmouseout="this.style.background='white'; this.style.color='var(--color-gray-700)'; this.style.borderColor='var(--color-gray-300)';">
                    Last ⟩⟩
                </a>
            @else
                <button disabled style="padding: 0.5rem 1rem; border: 2px solid var(--color-gray-300); background: var(--color-gray-100); color: var(--color-gray-400); border-radius: 8px; font-weight: 600; cursor: not-allowed; font-size: 0.875rem;">
                    Last ⟩⟩
                </button>
            @endif
        </div>

        {{-- Jump to Page (for large datasets) --}}
        @if($paginator->lastPage() > 10)
        <div style="display: flex; align-items: center; gap: 0.5rem;">
            <label for="jumpToPage" style="font-size: 0.875rem; color: var(--color-gray-600); font-weight: 600; white-space: nowrap;">Jump to:</label>
            <input type="number" id="jumpToPage" min="1" max="{{ $paginator->lastPage() }}" 
                   placeholder="Page" 
                   style="width: 80px; padding: 0.5rem; border: 2px solid var(--color-gray-300); border-radius: 8px; font-size: 0.875rem; text-align: center; font-weight: 600;"
                   onkeypress="if(event.key === 'Enter') { var page = parseInt(this.value); if(page >= 1 && page <= {{ $paginator->lastPage() }}) { window.location.href = '{{ $paginator->url(1) }}'.replace(/page=\d+/, 'page=' + page); } }">
            <button onclick="var input = document.getElementById('jumpToPage'); var page = parseInt(input.value); if(page >= 1 && page <= {{ $paginator->lastPage() }}) { window.location.href = '{{ $paginator->url(1) }}'.replace(/page=\d+/, 'page=' + page); }" 
                    style="padding: 0.5rem 1rem; border: 2px solid var(--color-gray-900); background: var(--color-gray-900); color: white; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s; font-size: 0.875rem;"
                    onmouseover="this.style.background='var(--color-gray-700)';"
                    onmouseout="this.style.background='var(--color-gray-900)';">
                Go
            </button>
        </div>
        @endif
    </nav>
@endif
