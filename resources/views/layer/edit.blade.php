@include('header')

<main class="max-w-[800px] mx-auto px-7 py-10">
    @include('sweetalert::alert')

    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('layer.index', $layup->id) }}"
            class="text-[#2d6a4f] hover:underline text-[13.5px] font-medium flex items-center gap-1">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back to {{ $layup->name }} Layers
        </a>
    </div>

    {{-- Page Header --}}
    <div class="mb-8">
        <h1 class="text-[26px] font-serif font-bold text-gray-900 mb-1 tracking-tight">Edit Layer</h1>
        <p class="text-[14px] text-gray-500">Update layer #{{ $layer->layer_order }} in <span class="font-semibold text-gray-700">{{ $layup->name }}</span>.</p>
    </div>

    {{-- Form Card --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <form action="{{ route('layer.update', $layer->id) }}" method="POST" class="p-8">
            @csrf
            @method('PUT')

            {{-- Layer Order --}}
            <div class="mb-5">
                <label for="layer_order" class="block text-[14px] font-semibold text-gray-700 mb-2">
                    Layer Order <span class="text-red-500">*</span>
                </label>
                <input type="number" name="layer_order" id="layer_order"
                    value="{{ old('layer_order', $layer->layer_order) }}"
                    required min="1" placeholder="e.g., 1"
                    class="w-full h-11 px-4 border @error('layer_order') border-red-500 @else border-gray-300 @enderror rounded-lg text-[14px] focus:outline-none focus:border-[#2d6a4f] focus:ring-1 focus:ring-[#2d6a4f] transition-all shadow-sm">
                @error('layer_order')
                    <p class="mt-1 text-[12px] text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Thickness & Width --}}
            <div class="grid grid-cols-2 gap-5 mb-5">
                <div>
                    <label for="thickness" class="block text-[14px] font-semibold text-gray-700 mb-2">
                        Thickness (mm) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" step="0.01" name="thickness" id="thickness"
                        value="{{ old('thickness', $layer->thickness) }}"
                        required min="0" placeholder="e.g., 35.0"
                        class="w-full h-11 px-4 border @error('thickness') border-red-500 @else border-gray-300 @enderror rounded-lg text-[14px] focus:outline-none focus:border-[#2d6a4f] focus:ring-1 focus:ring-[#2d6a4f] transition-all shadow-sm">
                    @error('thickness')
                        <p class="mt-1 text-[12px] text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="width" class="block text-[14px] font-semibold text-gray-700 mb-2">
                        Width (mm) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" step="0.01" name="width" id="width"
                        value="{{ old('width', $layer->width) }}"
                        required min="0" placeholder="e.g., 200.0"
                        class="w-full h-11 px-4 border @error('width') border-red-500 @else border-gray-300 @enderror rounded-lg text-[14px] focus:outline-none focus:border-[#2d6a4f] focus:ring-1 focus:ring-[#2d6a4f] transition-all shadow-sm">
                    @error('width')
                        <p class="mt-1 text-[12px] text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Angle --}}
            <div class="mb-6">
                <label for="angle" class="block text-[14px] font-semibold text-gray-700 mb-2">
                    Angle (°) <span class="text-red-500">*</span>
                </label>
                <input type="number" step="0.01" name="angle" id="angle"
                    value="{{ old('angle', $layer->angle) }}"
                    required placeholder="e.g., 0 or 90"
                    class="w-full h-11 px-4 border @error('angle') border-red-500 @else border-gray-300 @enderror rounded-lg text-[14px] focus:outline-none focus:border-[#2d6a4f] focus:ring-1 focus:ring-[#2d6a4f] transition-all shadow-sm">
                @error('angle')
                    <p class="mt-1 text-[12px] text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('layer.index', $layup->id) }}"
                    class="px-5 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-700 text-[14px] font-medium hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                    class="px-6 py-2.5 bg-[#2d6a4f] hover:bg-[#1b4332] text-white rounded-lg text-[14px] font-semibold transition-all shadow-sm">
                    Update Layer
                </button>
            </div>
        </form>
    </div>
</main>
</body>
</html>
