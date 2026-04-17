@include('header')

<main class="max-w-[1100px] mx-auto px-7 py-8">

    @include('sweetalert::alert')

    {{-- Back Button --}}
    <div class="mb-4">
        <a href="{{ route('layup.index', $supplier->id) }}"
            class="text-[#2d6a4f] hover:underline text-[13.5px] font-medium flex items-center gap-1 w-fit">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back to {{ $supplier->name }} Layups
        </a>
    </div>

    {{-- Breadcrumbs --}}
    <div class="mb-5 flex items-center gap-2 text-[13px] text-gray-500">
        <a href="{{ route('supplier.index') }}" class="hover:text-[#2d6a4f] transition-colors">Suppliers</a>
        <span class="text-gray-400">/</span>
        <a href="{{ route('layup.index', $supplier->id) }}" class="hover:text-[#2d6a4f] transition-colors">{{ $supplier->name }}</a>
        <span class="text-gray-400">/</span>
        <span class="font-medium text-gray-800">{{ $layup->name }}</span>
    </div>

    {{-- Header Card --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm mb-5 p-6 flex items-start justify-between">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <h1 class="text-[26px] font-serif font-bold text-gray-900 tracking-tight">{{ $layup->name }}</h1>
                <span class="bg-[#2d6a4f] text-white text-[11px] font-semibold px-2.5 py-0.5 rounded-full">
                    Layup
                </span>
            </div>
            <div class="text-[13px] font-mono text-gray-500">
                Supplier: {{ $supplier->name }} &nbsp;·&nbsp; Layup ID: L-{{ str_pad($layup->id, 3, '0', STR_PAD_LEFT) }}
            </div>
        </div>
        <a href="{{ route('layup.edit', $layup->id) }}"
            class="flex items-center gap-2 h-9 px-4 bg-white border border-gray-200 rounded-lg text-[13px] font-semibold text-gray-700 hover:bg-gray-50 transition-all shadow-sm">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 6.5-6.5z" />
            </svg>
            Edit Layup
        </a>
    </div>

    {{-- Section Header --}}
    <div class="flex items-end justify-between mb-4">
        <h2 class="text-[19px] font-serif font-bold text-gray-900">CLT Layers</h2>
        <a href="{{ route('layer.create', $layup->id) }}"
            class="flex items-center gap-2 h-9 px-4 bg-[#407c60] hover:bg-[#2d6a4f] text-white rounded-lg text-[13px] font-semibold transition-all shadow-sm">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            Add Layer
        </a>
    </div>

    {{-- Layers Table --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <table class="w-full border-collapse">
            <thead>
                <tr class="border-b border-gray-200 bg-white">
                    <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-wider text-gray-400 w-[100px]">Order</th>
                    <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-wider text-gray-400">Thickness (mm)</th>
                    <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-wider text-gray-400">Width (mm)</th>
                    <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-wider text-gray-400">Angle (°)</th>
                    <th class="px-6 py-4 text-right text-[10px] font-bold uppercase tracking-wider text-gray-400">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($layup->layers as $layer)
                    <tr class="border-b border-gray-100 last:border-none hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center justify-center w-8 h-8 bg-[#2d6a4f]/10 text-[#2d6a4f] font-bold text-[13px] rounded-lg">
                                {{ $layer->layer_order }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-[13.5px] text-gray-700 font-medium">{{ $layer->thickness }}</td>
                        <td class="px-6 py-4 text-[13.5px] text-gray-700">{{ $layer->width }}</td>
                        <td class="px-6 py-4 text-[13.5px] text-gray-700">{{ $layer->angle }}°</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('layer.edit', $layer->id) }}"
                                    class="flex items-center gap-2 bg-[#2d6a4f] hover:bg-[#1b4332] text-white px-3 py-2 rounded-lg text-[13px] font-semibold transition-all shadow-sm">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 6.5-6.5z" />
                                    </svg>
                                    Edit
                                </a>
                                <button type="button" onclick="hapusLayer({{ $layer->id }})"
                                    class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg text-[13px] font-semibold transition-all shadow-sm">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <line x1="18" y1="6" x2="6" y2="18" />
                                        <line x1="6" y1="6" x2="18" y2="18" />
                                    </svg>
                                    Delete
                                </button>
                                <form id="delete-layer-{{ $layer->id }}"
                                    action="{{ route('layer.destroy', $layer->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500 text-[13.5px]">
                            No layers found for this layup. Add the first layer.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function hapusLayer(id) {
        Swal.fire({
            title: 'Hapus Layer ini?',
            text: 'Tindakan ini tidak bisa dibatalkan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-layer-' + id).submit();
            }
        });
    }
</script>
</body>
</html>
