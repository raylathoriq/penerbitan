<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Penerbitan Buku LPPM UPNVJ')</title>
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
                    <a href="/auth/login" class="text-slate-500 hover:text-slate-700 px-3 py-2 rounded-md text-sm font-medium">Login</a>
                    <a href="/auth/register" class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-md text-sm font-medium ml-3">Daftar Author</a>
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