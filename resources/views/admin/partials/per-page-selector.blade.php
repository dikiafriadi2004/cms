@props(['perPage' => 20, 'options' => [5, 10, 20, 50], 'paginator' => null])

<div class="flex items-center gap-3 flex-wrap">

    {{-- Info total data (jika paginator dikirim) --}}
    @if($paginator && method_exists($paginator, 'total'))
        <p class="text-sm text-gray-500 whitespace-nowrap">
            @if($paginator->firstItem())
                Menampilkan
                <span class="font-semibold text-gray-700">{{ number_format($paginator->firstItem()) }}</span>–<span class="font-semibold text-gray-700">{{ number_format($paginator->lastItem()) }}</span>
                dari <span class="font-semibold text-gray-700">{{ number_format($paginator->total()) }}</span> data
            @else
                <span class="font-semibold text-gray-700">0</span> data
            @endif
        </p>
        <div class="w-px h-4 bg-gray-300 hidden sm:block"></div>
    @endif

    {{-- Dropdown per-page --}}
    <form method="GET" class="flex items-center gap-2">
        {{-- Pertahankan semua query string kecuali page, per_page dikirim via select --}}
        @foreach(request()->except('page', 'per_page') as $key => $value)
            @if(is_array($value))
                @foreach($value as $v)
                    <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                @endforeach
            @else
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endif
        @endforeach

        <span class="text-sm text-gray-500 whitespace-nowrap">Tampilkan</span>

        <div class="relative">
            <select name="per_page"
                onchange="this.closest('form').submit()"
                class="appearance-none text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-lg pl-3 pr-7 py-1.5 cursor-pointer hover:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                @foreach($options as $option)
                    <option value="{{ $option }}" @selected((int)$perPage === (int)$option)>{{ $option }}</option>
                @endforeach
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
        </div>

        <span class="text-sm text-gray-500 whitespace-nowrap">per halaman</span>
    </form>

</div>
