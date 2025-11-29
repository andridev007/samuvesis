<!doctype html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <title>SAMUVE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-brand-900 text-white min-h-screen">
<div class="flex">
    <aside class="hidden md:block w-64 bg-brand-800 min-h-screen p-4">
        <div class="text-xl font-semibold mb-6">SAMUVE</div>
        <nav class="flex flex-col gap-1">
            <a class="sidebar-link" href="{{ route('member.dashboard') }}">Dashboard</a>
            <a class="sidebar-link" href="{{ route('member.join.index') }}">Join</a>
            <a class="sidebar-link" href="{{ route('member.join.history') }}">Join History</a>
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="sidebar-link" style="text-align:left;">Logout</button>
                </form>
            @endauth
        </nav>
    </aside>
    <main class="flex-1 p-4 md:p-6">
        <header class="flex items-center justify-between mb-4">
            <div class="md:hidden text-lg font-semibold">SAMUVE</div>
            <div class="flex items-center gap-2">
                <span class="text-brand-300">{{ auth()->user()->nama_user ?? '' }}</span>
            </div>
        </header>
        @if(session('success'))
            <div class="mb-4 bg-green-600 px-4 py-2 rounded">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="mb-4 bg-red-600 px-4 py-2 rounded">
                <ul class="list-disc pl-4">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('content')
    </main>
</div>
</body>
</html>