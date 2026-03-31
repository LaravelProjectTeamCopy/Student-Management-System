<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>EduAdmin - {{ $title }}</title>

    <script>
        (() => {
            const stored = localStorage.getItem('theme');
            const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            const enableDark = stored ? stored === 'dark' : prefersDark;
            document.documentElement.classList.toggle('dark', enableDark);
        })();
    </script>

    {{-- Tailwind CDN (must load before config so `tailwind` global exists) --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    {{-- Tailwind Config --}}
    <script src="{{ asset('js/tailwind.config.js') }}"></script>

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <style>
        body { font-family: 'Lexend', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }

        ::-webkit-scrollbar { width:5px; height:5px }
        ::-webkit-scrollbar-track { background:transparent }
        ::-webkit-scrollbar-thumb { background:#CBD5E1; border-radius:99px }
        .dark ::-webkit-scrollbar-thumb { background:#334155 }

        *:not(canvas) { transition: background-color .25s ease, border-color .25s ease, color .2s ease; }
    </style>
</head>

<body class="bg-slate-100 dark:bg-[#0D1117] text-slate-800 dark:text-slate-200 min-h-screen">
@if(session('success'))
    <div class="fixed top-4 right-4 bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300 px-4 py-2 rounded-lg shadow-md">
        {{ session('success') }}
    </div>
@endif
<div class="flex h-screen overflow-hidden">

    {{-- ==================== SIDEBAR ==================== --}}
    <aside class="w-64 bg-white dark:bg-[#161B22] border-r border-slate-200 dark:border-slate-800 flex flex-col">

        {{-- Logo --}}
        <div class="p-6 flex items-center gap-3">
            <div class="bg-primary p-1.5 rounded-lg text-white">
                <span class="material-symbols-outlined text-2xl">school</span>
            </div>
            <h2 class="text-lg font-bold tracking-tight text-slate-900 dark:text-white leading-tight">
                EduAdmin
            </h2>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-4 space-y-1 overflow-y-auto">

            <a href="/welcome" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->is('welcome') ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="text-sm font-medium leading-normal">Dashboard</span>
            </a>

            <a href="/index" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->is('index') ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                <span class="material-symbols-outlined">group</span>
                <span class="text-sm font-medium leading-normal">Student Directory</span>
            </a>

            <a href="/attendances" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->is('attendances*') ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                <span class="material-symbols-outlined">description</span>
                <span class="text-sm font-medium leading-normal">Attendance Record</span>
            </a>

            <a href="/financials" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->is('financials*') ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                <span class="material-symbols-outlined">payments</span>
                <span class="text-sm font-medium leading-normal">Financials</span>
            </a>

            {{-- System Section --}}
            <div class="pt-4 pb-2 text-xs font-semibold text-slate-400 uppercase px-3 tracking-wider">
                System
            </div>

            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->is('settings*') ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                <span class="material-symbols-outlined">settings</span>
                <span class="text-sm font-medium leading-normal">Settings</span>
            </a>

        </nav>

        {{-- User Profile --}}
        <div class="p-4 border-t border-slate-200 dark:border-slate-800">
            <div class="flex items-center gap-3 px-2 py-3 bg-slate-50 dark:bg-slate-800/50 rounded-xl">
                <div class="size-10 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold">
                    {{ strtoupper(substr($user->name, 0, 1)) }}{{ strtoupper(substr(strrchr($user->name, ' '), 1, 1)) }}
                </div>
                <div class="flex flex-col">
                    <p class="text-xs font-bold">{{$user->name}}</p>
                    <p class="text-[10px] text-slate-500">Administrator</p>
                </div>
            </div>
        </div>

    </aside>

    {{-- ==================== MAIN CONTENT ==================== --}}
    <main class="flex-1 flex flex-col overflow-hidden">

        {{-- Header --}}
        <header class="h-16 bg-white/80 dark:bg-[#161B22]/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 px-8 flex items-center justify-between shrink-0">

            {{-- Breadcrumb --}}
            <div class="flex items-center gap-2 text-sm font-medium text-slate-500">
                {{$breadcrumb ?? '' }}
            </div>

            {{-- Search + Notifications --}}
            <div class="flex items-center gap-3 ml-auto">

                {{-- Search --}}
                <div class="relative flex items-center">
                    {{ $search ?? ''     }}
                </div>
                {{-- Notifications --}}
                <button class="size-10 flex items-center justify-center rounded-full text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800">
                    <span class="material-symbols-outlined">notifications</span>
                </button>

                {{-- Theme toggle --}}
                <button id="themeBtn" type="button" onclick="toggleTheme()" class="relative w-[52px] h-7 rounded-full bg-slate-200 dark:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-1 dark:focus:ring-offset-[#161B22]" aria-label="Toggle theme">
                    <span id="themeThumb" class="absolute top-[3px] left-[3px] w-[22px] h-[22px] rounded-full bg-white dark:bg-slate-900 shadow flex items-center justify-center" style="transition: transform .3s cubic-bezier(.4,0,.2,1)">
                        <span class="material-symbols-outlined text-[16px] text-amber-400 block dark:hidden">light_mode</span>
                        <span class="material-symbols-outlined text-[16px] text-blue-300 hidden dark:block">dark_mode</span>
                    </span>
                </button>

            </div>
        </header>

        {{-- ==================== PAGE CONTENT ==================== --}}
        <div class="flex-1 overflow-y-auto p-8">
            {{ $slot }}
        </div>

    </main>

</div>

<script>
    const html = document.documentElement;
    const themeThumb = document.getElementById('themeThumb');

    function applyTheme(dark) {
        html.classList.toggle('dark', dark);
        if (themeThumb) themeThumb.style.transform = dark ? 'translateX(24px)' : 'translateX(0)';
    }

    function toggleTheme() {
        const dark = !html.classList.contains('dark');
        localStorage.setItem('theme', dark ? 'dark' : 'light');
        applyTheme(dark);
    }

    document.addEventListener('DOMContentLoaded', () => {
        applyTheme(html.classList.contains('dark'));
    });
</script>
</body>
</html>