<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Penerbitan Buku LPPM UPNVJ')</title>
    <link rel="icon" href="{{ asset('img/upnvj.png') }}">
    @yield('meta')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased flex flex-col min-h-screen">
    {{-- Main Navbar --}}
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="/" class="text-xl font-bold text-green-700">LPPM UPNVJ Press</a>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="/" class="{{ request()->is('/') ? 'border-green-700 text-slate-900' : 'border-transparent text-slate-500 hover:border-green-700 hover:text-slate-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Beranda</a>
                        <a href="/katalog" class="{{ request()->is('katalog*') ? 'border-green-700 text-slate-900' : 'border-transparent text-slate-500 hover:border-green-700 hover:text-slate-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Katalog Buku</a>
                        <a href="/persyaratan" class="{{ request()->is('persyaratan*') ? 'border-green-700 text-slate-900' : 'border-transparent text-slate-500 hover:border-green-700 hover:text-slate-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Persyaratan & Alur</a>
                    </div>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:items-center">
                    @auth
                        <div x-data="{ open: false }" class="relative ml-3">
                            <div>
                                <button @click="open = !open" type="button" class="flex items-center text-sm focus:outline-none transition duration-150 ease-in-out">
                                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-green-100 border border-green-300">
                                        <span class="text-sm font-medium leading-none text-green-800">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    </span>
                                    <span class="ml-2 font-medium text-slate-700">{{ Auth::user()->name }}</span>
                                    <svg class="ml-1 h-4 w-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                            <div x-show="open" @click.away="open = false" style="display: none;" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                                <a href="{{ Auth::user()->role === 'admin' ? '/admin/dashboard' : '/author/dashboard' }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">Dashboard</a>
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-rose-600 hover:bg-slate-100">Keluar</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-slate-500 hover:text-slate-700 px-3 py-2 rounded-md text-sm font-medium">Login</a>
                        <a href="{{ route('register') }}" class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-md text-sm font-medium ml-3">Daftar Author</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t border-slate-200 mt-auto">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-sm text-slate-500">
                &copy; {{ date('Y') }} LPPM UPN "Veteran" Jakarta. Hak Cipta Dilindungi.
            </p>
        </div>
    </footer>
</body>
</html>