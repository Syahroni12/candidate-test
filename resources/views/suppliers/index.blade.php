@include('header')

{{-- ===== PAGE CONTENT ===== --}}
<main class="max-w-[1000px] mx-auto px-7 py-10">
    @include('sweetalert::alert')
    {{-- Page Header --}}
    <div class="flex items-start justify-between mb-8">
        <div>
            <h1 class="text-[26px] font-serif font-bold text-gray-900 mb-1 tracking-tight">Suppliers</h1>
            <p class="text-[14px] text-gray-500">Manage timber suppliers and material sourcing.</p>
        </div>
        <a href="{{ route('supplier.create') }}"
            class="flex items-center gap-2 bg-[#2d6a4f] hover:bg-[#1b4332] text-white px-4 py-2.5 rounded-lg text-[13.5px] font-semibold transition-all shadow-sm">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            Add Supplier
        </a>
    </div>

    {{-- Toolbar --}}
    <div class="flex items-center justify-between gap-3 mb-5">
        <div class="relative w-[320px]">
            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none" width="15"
                height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8" />
                <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg>
            {{-- Tambahkan id="searchInput" di sini --}}
            <input type="text" id="searchInput" placeholder="Search suppliers by name or ID..."
                class="w-full h-10 pl-10 pr-4 border border-gray-200 rounded-lg bg-white text-[13.5px] text-gray-800 placeholder-gray-400 outline-none focus:border-[#2d6a4f] focus:ring-1 focus:ring-[#2d6a4f] transition-all shadow-sm" />
        </div>
        <div class="flex gap-2.5">
            <button
                class="flex items-center gap-2 h-10 px-4 bg-white border border-gray-200 rounded-lg text-[13.5px] font-medium text-gray-700 hover:bg-gray-50 transition-all shadow-sm">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3" />
                </svg>
                Filter
            </button>

            <button
                class="flex items-center gap-2 h-10 px-4 bg-white border border-gray-200 rounded-lg text-[13.5px] font-medium text-gray-700 hover:bg-gray-50 transition-all shadow-sm">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    <polyline points="7 10 12 15 17 10" />
                    <line x1="12" y1="15" x2="12" y2="3" />
                </svg>
                Export
            </button>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <table class="w-full border-collapse">
            <thead>
                <tr class="border-b border-gray-200 bg-white">
                    <th
                        class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider text-gray-500 w-[45%]">
                        Name</th>
                    <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider text-gray-500">
                        Total Layups</th>
                    <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider text-gray-500">
                        Created At</th>
                    <th class="px-6 py-4 text-right text-[11px] font-bold uppercase tracking-wider text-gray-500">
                        Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                    // Array warna untuk rotasi avatar
                    $avatarColors = [
                        ['bg' => 'bg-blue-50', 'text' => 'text-blue-600'],
                        ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600'],
                        ['bg' => 'bg-orange-50', 'text' => 'text-orange-600'],
                        ['bg' => 'bg-purple-50', 'text' => 'text-purple-600'],
                        ['bg' => 'bg-teal-50', 'text' => 'text-teal-600'],
                    ];
                @endphp

                {{-- Looping data dari database --}}
                @forelse ($suppliers as $index => $supplier)
                    @php
                        // Ambil inisial dari nama (Misal: "Nordic Timber" -> "NT")
                        $words = explode(' ', $supplier->name);
                        $initials = strtoupper(
                            substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''),
                        );

                        // Rotasi warna berdasarkan index
                        $color = $avatarColors[$index % count($avatarColors)];
                    @endphp

                    <tr class="border-b border-gray-100 last:border-none hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-10 h-10 rounded-full {{ $color['bg'] }} {{ $color['text'] }} flex items-center justify-center text-[13px] font-bold shrink-0">
                                    {{ $initials }}
                                </div>
                                <div class="flex flex-col justify-center">
                                    <div class="text-[14.5px] font-serif font-bold text-gray-900">
                                        {{ $supplier->name }}
                                    </div>
                                    <div class="text-[12.5px] text-gray-400 mt-0.5">ID: {{ $supplier->id }}</div>
                                </div>
                            </div>
                        </td>
                        {{-- Gunakan atribut layups_count hasil dari withCount() --}}
                        <td class="px-6 py-4 text-[13.5px] text-gray-600">{{ $supplier->layups_count ?? 0 }}</td>
                        {{-- Format tanggal --}}
                        <td class="px-6 py-4 text-[13.5px] text-gray-600">
                            {{ $supplier->created_at ? $supplier->created_at->format('M d, Y') : '-' }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center gap-2 ml-auto justify-end">
                                <a href="{{ route('layup.index', $supplier->id) }}"
                                    class="flex items-center gap-2 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 px-3 py-2 rounded-lg text-[13px] font-semibold transition-all shadow-sm">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                    Layups
                                </a>
                                <a href="{{ route('supplier.edit', $supplier->id) }}"
                                    class="flex items-center gap-2 bg-[#2d6a4f] hover:bg-[#1b4332] text-white px-3 py-2 rounded-lg text-[13px] font-semibold transition-all shadow-sm">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2.5">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 6.5-6.5z" />
                                    </svg>
                                    Edit
                                </a>
                                <a href="#"
                                    class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg text-[13px] font-semibold transition-all shadow-sm"
                                    onclick="hapus({{ $supplier->id }})">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2.5">
                                        <line x1="18" y1="6" x2="6" y2="18" />
                                        <line x1="6" y1="6" x2="18" y2="18" />
                                    </svg>
                                    Delete
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500 text-[13.5px]">
                            No suppliers found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Custom Pagination Laravel --}}
        <div class="px-6 py-4 border-t border-gray-100 bg-white">
            {{-- Ini akan otomatis me-render tombol Next/Prev dan info halaman --}}
            {{ $suppliers->links() }}
        </div>

</main>

{{-- ===== SCRIPT LIVE SEARCH ===== --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const rows = document.querySelectorAll('.supplier-row');
        const noResultsRow = document.getElementById('noResultsRow');

        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            let hasVisibleRows = false;

            rows.forEach(row => {
                // Ambil teks dari nama supplier dan ID
                const rowText = row.querySelector('.supplier-name').textContent.toLowerCase() +
                    row.textContent.toLowerCase();

                // Cek apakah teks baris mengandung kata kunci pencarian
                if (rowText.includes(searchTerm)) {
                    row.style.display = ''; // Tampilkan baris
                    hasVisibleRows = true;
                } else {
                    row.style.display = 'none'; // Sembunyikan baris
                }
            });

            // Tampilkan pesan "No results" jika semua baris disembunyikan
            if (!hasVisibleRows && searchTerm !== '') {
                noResultsRow.classList.remove('hidden');
            } else {
                noResultsRow.classList.add('hidden');
            }
        });
    });

    // Fungsi untuk menampilkan SweetAlert saat tombol Delete diklik

    function hapus(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus data?',
            text: 'Data yang dihapus tidak dapat dikembalikan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "/supplier/delete/" + id;
            }
        });
    }
</script>
</body>

</html>
