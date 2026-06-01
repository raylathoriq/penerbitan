<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Author Dashboard')</title>
    <link rel="icon" href="{{ asset('img/upnvj.png') }}">
    <!-- Custom font for premium feel -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-slate-50/50 text-slate-800 antialiased flex h-screen overflow-hidden">
    {{-- Sidebar (Lighter for Author, distinct from Admin) --}}
    <div class="hidden md:flex md:flex-shrink-0">
        <div class="flex flex-col w-64 border-r border-slate-200 text-slate-700 bg-white shadow-sm z-20">
            <div class="h-16 flex items-center px-6 border-b border-slate-100">
                <span class="text-xl font-bold tracking-tight text-slate-900">Dashboard</span>
            </div>
            <div class="flex-1 flex flex-col overflow-y-auto p-4">
                <nav class="flex-1 space-y-1.5">
                    <a href="/author/dashboard" class="{{ request()->is('author/dashboard') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }} group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors">
                        Dashboard
                    </a>
                    <a href="/author/naskah" class="{{ request()->is('author/naskah*') || request()->is('author/upload*') || request()->is('author/revisi*') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }} group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors">
                        Naskah Saya
                    </a>
                </nav>
            </div>
        </div>
    </div>

    {{-- Main Column --}}
    <div class="flex flex-col w-0 flex-1 overflow-hidden">
        {{-- Topbar --}}
        <div class="relative z-10 flex-shrink-0 flex h-16 bg-white/80 backdrop-blur-md border-b border-slate-200/75">
            <button type="button" @click="sidebarOpen = true" class="px-4 border-r border-slate-200 text-slate-500 focus:outline-none md:hidden">
                <span class="sr-only">Buka sidebar</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                </svg>
            </button>
            <div class="flex-1 px-6 flex justify-between items-center">
                <div class="flex-1 flex items-center">
                    <h1 class="text-xl font-semibold text-slate-900 tracking-tight">@yield('page_title', 'Dashboard')</h1>
                </div>
                <div class="ml-4 flex items-center md:ml-6">
                    <div class="relative" x-data="{ open: false }">
                        <div>
                            <button @click="open = !open" type="button" class="bg-white rounded-full flex text-sm focus:outline-none ring-1 ring-slate-200 shadow-sm hover:shadow-md transition-all" id="user-menu-button">
                                <div class="h-9 w-9 rounded-full bg-slate-100 flex items-center justify-center text-slate-700 font-bold">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            </button>
                        </div>
                        <div x-show="open" @click.away="open = false" 
                             class="origin-top-right absolute right-0 mt-2 w-48 rounded-xl shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu">
                             <div class="px-4 py-2 text-xs text-slate-500 font-medium">{{ Auth::user()->name }}</div>
                             <a href="/" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">Beranda</a>
                            <div class="border-t border-slate-100 my-1"></div>
                            <a href="/author/profil" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Profil Saya</a>
                            <div class="border-t border-slate-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-rose-600 hover:bg-rose-50">Keluar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <main class="flex-1 relative overflow-y-auto focus:outline-none p-6 sm:p-8 lg:p-10">
            <div class="max-w-6xl mx-auto">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>