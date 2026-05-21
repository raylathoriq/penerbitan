<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
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
<body class="bg-slate-50 text-slate-800 antialiased flex h-screen overflow-hidden">
    {{-- Sidebar --}}
    <div class="hidden md:flex md:flex-shrink-0">
        <div class="flex flex-col w-64 border-r border-slate-800 bg-slate-900 text-slate-300 shadow-xl z-20">
            <div class="h-16 flex items-center px-6 border-b border-slate-800">
                <span class="text-xl font-bold tracking-tight text-white">Admin LPPM <span class="text-emerald-500">.</span></span>
            </div>
            <div class="flex-1 flex flex-col overflow-y-auto py-6">
                <nav class="flex-1 px-4 space-y-1.5">
                    <a href="/admin/dashboard" class="{{ request()->is('admin/dashboard') ? 'bg-slate-800 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors">
                        Dashboard
                    </a>
                    <a href="/admin/naskah" class="{{ request()->is('admin/naskah*') ? 'bg-slate-800 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors">
                        Manajemen Naskah
                    </a>
                    <a href="/admin/publication" class="{{ request()->is('admin/publication*') ? 'bg-slate-800 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors">
                        Rilis Publikasi
                    </a>
                    <a href="/admin/users" class="{{ request()->is('admin/users*') ? 'bg-slate-800 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors">
                        Manajemen User
                    </a>
                </nav>
            </div>
        </div>
    </div>

    {{-- Main Column --}}
    <div class="flex flex-col w-0 flex-1 overflow-hidden">
        {{-- Topbar --}}
        <div class="relative z-10 flex-shrink-0 flex h-16 bg-white/80 backdrop-blur-md border-b border-slate-200/75">
            <button type="button" @click="sidebarOpen = true" class="px-4 border-r border-slate-200 text-slate-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-emerald-500 md:hidden">
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
                            <button @click="open = !open" type="button" class="bg-white rounded-full flex text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 ring-1 ring-slate-200 shadow-sm transition-all hover:shadow-md" id="user-menu-button">
                                <span class="sr-only">Buka profil</span>
                                <div class="h-9 w-9 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-800 font-bold">
                                    A
                                </div>
                            </button>
                        </div>
                        <div x-show="open" @click.away="open = false" 
                             x-transition:enter="transition ease-out duration-100" 
                             x-transition:enter-start="transform opacity-0 scale-95" 
                             x-transition:enter-end="transform opacity-100 scale-100" 
                             x-transition:leave="transition ease-in duration-75" 
                             x-transition:leave-start="transform opacity-100 scale-100" 
                             x-transition:leave-end="transform opacity-0 scale-95" 
                             class="origin-top-right absolute right-0 mt-2 w-48 rounded-xl shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu">
                            <a href="/admin/profil" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">Profil Admin</a>
                            <div class="border-t border-slate-100 my-1"></div>
                            <a href="/admin/login" class="block px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 transition-colors">Keluar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <main class="flex-1 relative overflow-y-auto focus:outline-none p-6 sm:p-8 lg:p-10">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>