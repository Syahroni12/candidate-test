<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Suppliers Dashboard – CLT Layup</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Merriweather:wght@700&display=swap');
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Merriweather', 'serif'],
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50 text-gray-900 text-sm min-h-screen font-sans">

    {{-- ===== NAVBAR ===== --}}
    <nav class="sticky top-0 z-50 bg-white border-b border-gray-200 flex items-center gap-8 px-7 h-14">

        {{-- Brand --}}
        <div class="flex items-center gap-2.5 shrink-0">
            <div class="w-8 h-8 bg-emerald-700 rounded-md flex items-center justify-center text-white">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5">
                    <rect x="3" y="3" width="7" height="7" rx="1" />
                    <rect x="14" y="3" width="7" height="7" rx="1" />
                    <rect x="3" y="14" width="7" height="7" rx="1" />
                    <rect x="14" y="14" width="7" height="7" rx="1" />
                </svg>
            </div>
            <div class="flex flex-col leading-none justify-center mt-1">
                <span class="text-[13px] font-bold text-gray-900 leading-tight">CLT Layup</span>
                <span class="text-[9px] font-bold text-gray-400 tracking-widest leading-tight mt-0.5">MANAGER</span>
            </div>
        </div>

        {{-- Nav Links --}}
        <ul class="flex items-center gap-1 flex-1 list-none h-full">
            @php
                $navLinks = ['Overview', 'Suppliers', 'Layups', 'Layers', 'Settings'];
                $activeLink = 'Suppliers';
            @endphp
            @foreach ($navLinks as $link)
                <li class="h-full flex items-center">
                    <a href="#"
                        class="relative inline-flex items-center px-3 h-full text-[13.5px] transition-colors
                      {{ $link === $activeLink ? 'text-emerald-700 font-semibold' : 'text-gray-500 hover:text-gray-900' }}">
                        {{ $link }}
                        @if ($link === $activeLink)
                            <span class="absolute bottom-0 left-0 right-0 h-[3px] bg-emerald-700 rounded-t-md"></span>
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>

        {{-- Right side --}}
        <div class="flex items-center gap-4 ml-auto shrink-0">
            <button class="text-gray-400 hover:text-gray-700 transition-colors">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                    <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                </svg>
            </button>
            <div class="w-px h-6 bg-gray-200"></div>
            <div class="flex items-center gap-2.5">
                <div
                    class="w-8 h-8 rounded-full bg-gray-200 text-gray-600 text-[11px] font-bold flex items-center justify-center shrink-0">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
                <div class="flex flex-col leading-none justify-center mt-1">
                    <span class="text-[13px] font-semibold text-gray-900 leading-tight">Alex Morgan</span>
                    <span class="text-[11px] text-gray-400 leading-tight mt-0.5">Engineering Lead</span>
                </div>
            </div>
        </div>
    </nav>
