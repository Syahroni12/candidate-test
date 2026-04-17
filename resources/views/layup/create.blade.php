@include('header')

<main class="max-w-[800px] mx-auto px-7 py-10">
    {{-- Breadcrumb / Back Button --}}
    <div class="mb-6">
        <a href="{{ route('layup.index', $supplier->id) }}"
            class="text-[#2d6a4f] hover:underline text-[13.5px] font-medium flex items-center gap-1">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back to {{ $supplier->name }} Layups
        </a>
    </div>

    {{-- Page Header --}}
    <div class="mb-8">
        <h1 class="text-[26px] font-serif font-bold text-gray-900 mb-1 tracking-tight">Add New Layup</h1>
        <p class="text-[14px] text-gray-500">Create a new layup for <span class="font-semibold text-gray-700">{{ $supplier->name }}</span>.</p>
    </div>

    {{-- Form Card --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <form action="{{ route('layup.store', $supplier->id) }}" method="POST" class="p-8">
            @csrf

            <div class="mb-6">
                <label for="name" class="block text-[14px] font-semibold text-gray-700 mb-2">
                    Layup Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    placeholder="e.g., 3-Ply Nordic"
                    class="w-full h-11 px-4 border @error('name') border-red-500 @else border-gray-300 @enderror rounded-lg text-[14px] focus:outline-none focus:border-[#2d6a4f] focus:ring-1 focus:ring-[#2d6a4f] transition-all shadow-sm">
                @error('name')
                    <p class="mt-2 text-[12px] text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('layup.index', $supplier->id) }}"
                    class="px-5 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-700 text-[14px] font-medium hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                    class="px-6 py-2.5 bg-[#2d6a4f] hover:bg-[#1b4332] text-white rounded-lg text-[14px] font-semibold transition-all shadow-sm">
                    Save Layup
                </button>
            </div>
        </form>
    </div>
</main>
</body>

</html>
