<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login - LPPM UPNVJ')</title>
    <link rel="icon" href="{{ asset('img/upnvj.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-xl border border-slate-200">
        <div>
            <h2 class="mt-2 text-center text-3xl font-extrabold text-green-800">
                LPPM UPNVJ Press
            </h2>
            <p class="mt-2 text-center text-sm text-slate-600">
                @yield('subtitle', 'Sistem Penerbitan Buku')
            </p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 text-red-500 p-4 rounded-md text-sm">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        @yield('content')
        
    </div>
</body>
</html>