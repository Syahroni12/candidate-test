@include('header')

<main class="max-w-[1100px] mx-auto px-7 py-8">

    @include('sweetalert::alert')

    {{-- Back Button --}}
    <div class="mb-4">
        <a href="{{ route('supplier.index') }}"
            class="text-[#2d6a4f] hover:underline text-[13.5px] font-medium flex items-center gap-1 w-fit">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back to Suppliers
        </a>
    </div>

    {{-- Breadcrumbs --}}
    <div class="mb-5 flex items-center gap-2 text-[13px] text-gray-500">
        <a href="{{ route('supplier.index') }}" class="hover:text-[#2d6a4f] transition-colors">Suppliers</a>
        <span class="text-gray-400">/</span>
        <span class="font-medium text-gray-800">{{ $supplier->name }}</span>
    </div>

    {{-- 1. HEADER CARD (Supplier Details) --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm mb-5 p-6 flex items-start justify-between">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <h1 class="text-[26px] font-serif font-bold text-gray-900 tracking-tight">{{ $supplier->name }}</h1>
                <span class="bg-[#2d6a4f] text-white text-[11px] font-semibold px-2.5 py-0.5 rounded-full">
                    Active Partner
                </span>
            </div>
            <div class="text-[13px] font-mono text-gray-500">
                ID: SUP-{{ $supplier->created_at->format('Y') }}-{{ str_pad($supplier->id, 3, '0', STR_PAD_LEFT) }}
            </div>
        </div>
        <a href="{{ route('supplier.edit', $supplier->id) }}"
            class="flex items-center gap-2 h-9 px-4 bg-white border border-gray-200 rounded-lg text-[13px] font-semibold text-gray-700 hover:bg-gray-50 transition-all shadow-sm">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 6.5-6.5z" />
            </svg>
            Edit Supplier
        </a>
    </div>

    {{-- 2. INFO GRID CARD --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm mb-10 overflow-hidden">
        <div class="grid grid-cols-4 divide-x divide-gray-100">
            <div class="p-5">
                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Primary Contact</div>
                <div class="flex items-center gap-2 text-[13.5px] text-gray-800 font-medium">
                    <svg class="text-[#2d6a4f]" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    engineering@nordic.ca
                </div>
            </div>
            <div class="p-5">
                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Location</div>
                <div class="flex items-center gap-2 text-[13.5px] text-gray-800 font-medium">
                    <svg class="text-[#2d6a4f]" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    Montreal, QC, Canada
                </div>
            </div>
            <div class="p-5">
                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Material Certifications
                </div>
                <div class="flex items-center gap-2 text-[13.5px] text-gray-800 font-medium">
                    <svg class="text-[#2d6a4f]" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    SPF No. 1/2, D. Fir-L
                </div>
            </div>
            <div class="p-5">
                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Last Audit Date</div>
                <div class="flex items-center gap-2 text-[13.5px] text-gray-800 font-medium">
                    <svg class="text-[#2d6a4f]" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    Oct 12, 2023
                </div>
            </div>
        </div>
    </div>

    {{-- 3. ASSOCIATED LAYUPS SECTION --}}
    <div class="flex items-end justify-between mb-4">
        <h2 class="text-[19px] font-serif font-bold text-gray-900">Associated Layups</h2>

        <div class="flex items-center gap-2">
            <button onclick="document.getElementById('importModal').classList.remove('hidden')"
                class="flex items-center gap-2 h-9 px-3.5 bg-white border border-gray-200 rounded-lg text-[13px] font-medium text-gray-700 hover:bg-gray-50 transition-all shadow-sm">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    <polyline points="7 10 12 15 17 10" />
                    <line x1="12" y1="15" x2="12" y2="3" />
                </svg>
                Import
            </button>
            <a href="{{ route('supplier.export', $supplier->id) }}"
                class="flex items-center gap-2 h-9 px-3.5 bg-white border border-gray-200 rounded-lg text-[13px] font-medium text-gray-700 hover:bg-gray-50 transition-all shadow-sm">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    <polyline points="17 8 12 3 7 8" />
                    <line x1="12" y1="3" x2="12" y2="15" />
                </svg>
                Export
            </a>
            <a href="{{ route('layup.create', $supplier->id) }}"
                class="flex items-center gap-2 h-9 px-4 bg-[#407c60] hover:bg-[#2d6a4f] text-white rounded-lg text-[13px] font-semibold transition-all shadow-sm ml-1">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5">
                    <line x1="12" y1="5" x2="12" y2="19" />
                    <line x1="5" y1="12" x2="19" y2="12" />
                </svg>
                Add Layup
            </a>
        </div>
    </div>

    {{-- LAYUPS TABLE --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <table class="w-full border-collapse">
            <thead>
                <tr class="border-b border-gray-200 bg-white">
                    <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-wider text-gray-400 w-[120px]">Layup ID</th>
                    <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-wider text-gray-400">Name</th>
                    <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-wider text-gray-400">Created At</th>
                    <th class="px-6 py-4 text-right text-[10px] font-bold uppercase tracking-wider text-gray-400">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($supplier->layups as $layup)
                    <tr class="border-b border-gray-100 last:border-none hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 text-[12.5px] font-mono text-gray-500">
                            L-{{ str_pad($layup->id, 3, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="px-6 py-4 text-[13.5px] font-semibold text-gray-800">{{ $layup->name }}</td>
                        <td class="px-6 py-4 text-[13px] text-gray-500">
                            {{ $layup->created_at ? $layup->created_at->format('M d, Y') : '-' }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                {{-- Tombol View Layers --}}
                                <a href="{{ route('layer.index', $layup->id) }}"
                                    class="flex items-center gap-2 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 px-3 py-2 rounded-lg text-[13px] font-semibold transition-all shadow-sm">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                    Layers
                                </a>
                                {{-- Tombol Edit Layup --}}
                                <a href="{{ route('layup.edit', $layup->id) }}"
                                    class="flex items-center gap-2 bg-[#2d6a4f] hover:bg-[#1b4332] text-white px-3 py-2 rounded-lg text-[13px] font-semibold transition-all shadow-sm">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2.5">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 6.5-6.5z" />
                                    </svg>
                                    Edit
                                </a>

                                {{-- Tombol Hapus Layup --}}
                                <button type="button" onclick="hapusLayup({{ $layup->id }})"
                                    class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg text-[13px] font-semibold transition-all shadow-sm">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2.5">
                                        <line x1="18" y1="6" x2="6" y2="18" />
                                        <line x1="6" y1="6" x2="18" y2="18" />
                                    </svg>
                                    Delete
                                </button>

                                {{-- Hidden Form Delete --}}
                                <form id="delete-layup-{{ $layup->id }}"
                                    action="{{ route('layup.destroy', $layup->id) }}" method="POST"
                                    class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500 text-[13.5px]">No associated
                            layups found for this supplier.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</main>

{{-- IMPORT MODAL --}}
<div id="importModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900/50 backdrop-blur-sm" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</div>
        
        <div class="relative inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-xl shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            <div class="absolute top-0 right-0 hidden pt-4 pr-4 sm:block">
                <button type="button" onclick="document.getElementById('importModal').classList.add('hidden')" class="text-gray-400 bg-white rounded-md hover:text-gray-500 focus:outline-none">
                    <span class="sr-only">Close</span>
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="sm:flex sm:items-start">
                <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-blue-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                    <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Import Supplier Data</h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">Upload a JSON file containing Layups and Layers to import into this supplier.</p>
                        
                        <form id="importForm" action="{{ route('supplier.import', $supplier->id) }}" method="POST" enctype="multipart/form-data" class="mt-4 space-y-4">
                            @csrf
                            <div>
                                <label class="block text-[13px] font-medium text-gray-700 mb-1">JSON File</label>
                                <input type="file" name="import_file" accept=".json" required
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>

                            <div>
                                <label class="block text-[13px] font-medium text-gray-700 mb-1">Conflict Resolution Strategy</label>
                                <select name="conflict_strategy" required
                                    class="w-full h-[42px] px-3 border border-gray-200 rounded-lg text-[13.5px] text-gray-800 bg-white outline-none focus:border-[#2d6a4f] focus:ring-1 focus:ring-[#2d6a4f] transition-all shadow-sm">
                                    <option value="overwrite">Overwrite Existing Data</option>
                                    <option value="skip">Skip Conflict (Keep Current)</option>
                                    <option value="duplicate">Duplicate Layup (Add Suffix)</option>
                                </select>
                                <p class="text-[11.5px] text-gray-500 mt-1">If a layup or layer identical conflict is found, how should the system handle it?</p>
                            </div>

                            <div class="pt-3 sm:flex sm:flex-row-reverse border-t border-gray-100">
                                <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                    Start Import
                                </button>
                                <button type="button" onclick="document.getElementById('importModal').classList.add('hidden')" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function hapusLayup(id) {
        Swal.fire({
            title: 'Hapus Layup ini?',
            text: 'Tindakan ini tidak bisa dibatalkan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-layup-' + id).submit();
            }
        });
    }
</script>

</body>

</html>
