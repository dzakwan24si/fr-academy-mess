@php
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
@endphp

<div>
    @if ($paginator->hasPages() || $paginator->total() > 0)
        <div class="flex flex-col sm:flex-row items-center justify-between text-sm text-gray-600 gap-4 mt-4">
            <div class="flex items-center gap-2">
                <span>Tampilkan</span>
                <select wire:model.live="perPage" class="bg-gray-50 border border-gray-200 text-gray-700 rounded-lg px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-[#59A338] cursor-pointer hover:bg-gray-100 transition-colors">
                    @if(property_exists($this, 'perPageOptions') && is_array($this->perPageOptions))
                        @foreach($this->perPageOptions as $option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                    @else
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    @endif
                </select>
                <span>data per halaman</span>
            </div>
            
            <div class="flex flex-col sm:flex-row items-center gap-4">
                <span>Menampilkan {{ $paginator->firstItem() ?? 0 }} - {{ $paginator->lastItem() ?? 0 }} dari {{ $paginator->total() }} data</span>
                
                @if ($paginator->hasPages())
                <div class="flex items-center gap-1">
                    @if ($paginator->onFirstPage())
                        <span class="p-1 text-gray-300 cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </span>
                    @else
                        <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" class="p-1 text-gray-500 hover:text-[#59A338] transition-colors focus:outline-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                    @endif
                    
                    <div class="px-3 py-1 bg-gray-100 text-gray-700 font-semibold rounded-lg text-xs">
                        <span class="text-black">{{ $paginator->currentPage() }}</span> <span class="text-gray-400 font-normal">/ {{ $paginator->lastPage() }}</span>
                    </div>
                    
                    @if ($paginator->hasMorePages())
                        <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" class="p-1 text-gray-500 hover:text-[#59A338] transition-colors focus:outline-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    @else
                        <span class="p-1 text-gray-300 cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </span>
                    @endif
                </div>
                @endif
            </div>
        </div>
    @endif
</div>
