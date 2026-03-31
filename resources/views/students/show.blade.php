<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>EduAdmin – {{ $student->name }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet" />
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          fontFamily: {
            sans:  ['DM Sans', 'sans-serif'],
            serif: ['Instrument Serif', 'serif'],
          },
          keyframes: {
            fadeUp: {
              '0%':   { opacity: '0', transform: 'translateY(16px)' },
              '100%': { opacity: '1', transform: 'translateY(0)' },
            }
          },
          animation: {
            'fu1': 'fadeUp .45s ease both',
            'fu2': 'fadeUp .45s .07s ease both',
            'fu3': 'fadeUp .45s .14s ease both',
            'fu4': 'fadeUp .45s .21s ease both',
          }
        }
      }
    }
  </script>
  <style>
    ::-webkit-scrollbar            { width: 5px; height: 5px; }
    ::-webkit-scrollbar-track      { background: transparent; }
    ::-webkit-scrollbar-thumb      { background: #CBD5E1; border-radius: 99px; }
    .dark ::-webkit-scrollbar-thumb{ background: #334155; }
    *:not(canvas) { transition: background-color .25s ease, border-color .25s ease, color .2s ease; }

    @keyframes pulseRing {
      0%   { box-shadow: 0 0 0 0 rgba(16,185,129,.55); }
      70%  { box-shadow: 0 0 0 7px rgba(16,185,129,0); }
      100% { box-shadow: 0 0 0 0 rgba(16,185,129,0); }
    }
    .pulse { animation: pulseRing 2s infinite; }

    /* avatar ring glow */
    .avatar-ring {
      box-shadow: 0 0 0 3px #fff, 0 0 0 5px #3B82F6;
    }
    .dark .avatar-ring {
      box-shadow: 0 0 0 3px #161B22, 0 0 0 5px #3B82F6;
    }
  </style>
</head>

<body class="bg-slate-100 dark:bg-[#0D1117] font-sans text-slate-800 dark:text-slate-200 min-h-screen flex">

<!-- ═══════════════════  SIDEBAR  ═══════════════════ -->
<aside class="w-[230px] shrink-0 min-h-screen bg-white dark:bg-[#161B22] border-r border-slate-200 dark:border-slate-800 sticky top-0 h-screen flex flex-col z-50">

  <!-- Logo -->
  <div class="flex items-center gap-3 px-5 py-[22px] border-b border-slate-100 dark:border-slate-800">
    <div class="w-9 h-9 rounded-xl bg-blue-600 flex items-center justify-center shadow-md shadow-blue-200 dark:shadow-blue-900/40 shrink-0">
      <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.627 48.627 0 0 1 12 20.904a48.627 48.627 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5"/>
      </svg>
    </div>
    <span class="font-serif text-[1.2rem] text-slate-900 dark:text-white tracking-tight">EduAdmin</span>
  </div>

  <!-- Nav -->
  <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">
    <p class="text-[10px] font-semibold uppercase tracking-widest text-slate-400 dark:text-slate-600 px-3 pb-2">Main</p>

    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-white">
      <svg class="w-[18px] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z"/></svg>
      Overview
    </a>

    <!-- ACTIVE -->
    <a href="{{ route('students.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400">
      <svg class="w-[18px] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/></svg>
      Student Directory
    </a>

    <a href="{{ route('attendances.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-white">
      <svg class="w-[18px] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
      Academic Records
    </a>

    <a href="{{ route('financials.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-white">
      <svg class="w-[18px] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z"/></svg>
      Financials
    </a>

    <div class="pt-4">
      <p class="text-[10px] font-semibold uppercase tracking-widest text-slate-400 dark:text-slate-600 px-3 pb-2">System</p>
      <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-white">
        <svg class="w-[18px] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
        Settings
      </a>
    </div>
  </nav>

  <!-- User -->
  <div class="px-3 py-4 border-t border-slate-100 dark:border-slate-800">
    <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/60 cursor-pointer">
      <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-semibold shrink-0">{{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}</div>
      <div class="min-w-0">
        <p class="text-sm font-medium text-slate-800 dark:text-slate-200 truncate">{{ Auth::user()->name ?? 'User' }}</p>
        <p class="text-xs text-slate-400 dark:text-slate-500">Administrator</p>
      </div>
    </div>
  </div>
</aside>

<!-- ═══════════════════  MAIN  ═══════════════════ -->
<div class="flex-1 flex flex-col min-w-0">

  <!-- Top bar -->
  <header class="sticky top-0 z-40 bg-white/80 dark:bg-[#161B22]/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 flex items-center gap-4 px-7 py-3.5">
    <!-- Breadcrumb -->
    <div class="flex items-center gap-1.5 text-sm text-slate-400 dark:text-slate-500 flex-wrap">
      <a href="{{ route('dashboard') }}" class="hover:text-slate-600 dark:hover:text-slate-300">Dashboard</a>
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
      <a href="{{ route('students.index') }}" class="hover:text-slate-600 dark:hover:text-slate-300">Student Management</a>
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
      <span class="text-slate-700 dark:text-slate-300 font-medium">{{ $student->name }}</span>
    </div>

    <div class="ml-auto flex items-center gap-3">
      <!-- Search -->
      <div class="relative hidden sm:block">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
        <input type="text" placeholder="Search..." class="pl-9 pr-4 py-2 rounded-xl text-sm bg-slate-100 dark:bg-slate-800 border border-transparent focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:focus:ring-blue-900/40 outline-none text-slate-700 dark:text-slate-300 placeholder-slate-400 w-52" />
      </div>

      <!-- Dark / Light Toggle -->
      <button id="themeBtn" onclick="toggleTheme()"
        class="relative w-[52px] h-7 rounded-full bg-slate-200 dark:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 dark:focus:ring-offset-[#161B22]"
        aria-label="Toggle theme">
        <span id="thumb"
          class="absolute top-[3px] left-[3px] w-[22px] h-[22px] rounded-full bg-white dark:bg-slate-900 shadow flex items-center justify-center"
          style="transition: transform .3s cubic-bezier(.4,0,.2,1)">
          <!-- sun -->
          <svg class="w-3 h-3 text-amber-400 block dark:hidden" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.25a.75.75 0 0 1 .75.75v2.25a.75.75 0 0 1-1.5 0V3a.75.75 0 0 1 .75-.75ZM7.5 12a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM18.894 6.166a.75.75 0 0 0-1.06-1.06l-1.591 1.59a.75.75 0 1 0 1.06 1.061l1.591-1.59ZM21.75 12a.75.75 0 0 1-.75.75h-2.25a.75.75 0 0 1 0-1.5H21a.75.75 0 0 1 .75.75ZM17.834 18.894a.75.75 0 0 0 1.06-1.06l-1.59-1.591a.75.75 0 1 0-1.061 1.06l1.59 1.591ZM12 18a.75.75 0 0 1 .75.75V21a.75.75 0 0 1-1.5 0v-2.25A.75.75 0 0 1 12 18ZM7.758 17.303a.75.75 0 0 0-1.061-1.06l-1.591 1.59a.75.75 0 0 0 1.06 1.061l1.591-1.59ZM6 12a.75.75 0 0 1-.75.75H3a.75.75 0 0 1 0-1.5h2.25A.75.75 0 0 1 6 12ZM6.697 7.757a.75.75 0 0 0 1.06-1.06l-1.59-1.591a.75.75 0 0 0-1.061 1.06l1.59 1.591Z"/></svg>
          <!-- moon -->
          <svg class="w-3 h-3 text-blue-300 hidden dark:block" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M9.528 1.718a.75.75 0 0 1 .162.819A8.97 8.97 0 0 0 9 6a9 9 0 0 0 9 9 8.97 8.97 0 0 0 3.463-.69.75.75 0 0 1 .981.98 10.503 10.503 0 0 1-9.694 6.46c-5.799 0-10.5-4.7-10.5-10.5 0-4.368 2.667-8.112 6.46-9.694a.75.75 0 0 1 .818.162Z" clip-rule="evenodd"/></svg>
        </span>
      </button>

      <!-- Bell -->
      <button class="relative w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700">
        <svg class="w-[18px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"/></svg>
        <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-red-500 border-2 border-white dark:border-[#161B22]"></span>
      </button>
    </div>
  </header>

  <!-- Page Content -->
  <main class="flex-1 px-7 py-7 overflow-y-auto">

    <!-- ── PROFILE HEADER CARD ── -->
    <div class="animate-fu1 bg-white dark:bg-[#161B22] rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 mb-5 flex flex-col sm:flex-row items-start sm:items-center gap-5">
      <!-- Avatar -->
      <div class="relative shrink-0">
        <div class="w-20 h-20 rounded-2xl avatar-ring overflow-hidden bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
          <!-- Illustrated avatar placeholder -->
          <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
            <rect width="80" height="80" fill="url(#avatarGrad)"/>
            <defs>
              <linearGradient id="avatarGrad" x1="0" y1="0" x2="80" y2="80" gradientUnits="userSpaceOnUse">
                <stop stop-color="#60A5FA"/>
                <stop offset="1" stop-color="#2563EB"/>
              </linearGradient>
            </defs>
            <!-- body -->
            <ellipse cx="40" cy="92" rx="28" ry="22" fill="#1D4ED8" opacity=".7"/>
            <!-- head -->
            <circle cx="40" cy="34" r="18" fill="#FDE68A"/>
            <!-- hair -->
            <ellipse cx="40" cy="18" rx="18" ry="10" fill="#92400E"/>
            <rect x="22" y="18" width="36" height="8" rx="4" fill="#92400E"/>
            <!-- eyes -->
            <circle cx="33" cy="33" r="2.5" fill="#1E293B"/>
            <circle cx="47" cy="33" r="2.5" fill="#1E293B"/>
            <!-- smile -->
            <path d="M34 41 Q40 46 46 41" stroke="#92400E" stroke-width="1.5" fill="none" stroke-linecap="round"/>
            <!-- collar -->
            <path d="M28 54 L40 62 L52 54" stroke="#fff" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
        <!-- online dot -->
        <span class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full bg-emerald-500 border-2 border-white dark:border-[#161B22] pulse"></span>
      </div>

      <!-- Name / ID / Status -->
      <div class="flex-1 min-w-0">
        <h1 class="font-serif text-[1.75rem] text-slate-900 dark:text-white leading-tight">{{ $student->name }}</h1>
        <div class="flex items-center gap-3 mt-1 flex-wrap">
          <span class="text-sm text-slate-400 dark:text-slate-500 font-medium">ID: STU-{{ str_pad($student->id, 5, '0', STR_PAD_LEFT) }}</span>
          <span class="flex items-center gap-1.5 text-sm font-semibold text-emerald-600 dark:text-emerald-400">
            <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span>
            Active
          </span>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="flex items-center gap-2.5 flex-wrap shrink-0">
        <button onclick="confirmDelete()" class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold border border-red-200 dark:border-red-900/50 text-red-500 dark:text-red-400 bg-red-50 dark:bg-red-900/10 hover:bg-red-100 dark:hover:bg-red-900/20">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
          Delete Student
        </button>
        <button onclick="openEditModal()" class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125"/></svg>
          Edit Profile
        </button>
        <button onclick="openMessageModal()" class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold bg-blue-600 hover:bg-blue-700 text-white shadow-md shadow-blue-200 dark:shadow-blue-900/40">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/></svg>
          Message
        </button>
      </div>
    </div>

    <!-- ── MAIN GRID ── -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

      <!-- LEFT COL -->
      <div class="lg:col-span-2 space-y-5">

        <!-- Academic Overview -->
        <div class="animate-fu2 bg-white dark:bg-[#161B22] rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-6">
          <h2 class="flex items-center gap-2.5 font-semibold text-slate-800 dark:text-white text-[1.05rem] mb-5">
            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.627 48.627 0 0 1 12 20.904a48.627 48.627 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5"/></svg>
            Academic Overview
          </h2>

          <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <!-- Major -->
            <div class="bg-slate-50 dark:bg-slate-800/50 rounded-xl p-4 border border-slate-100 dark:border-slate-700/50">
              <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-2">Major</p>
              <p class="text-blue-600 dark:text-blue-400 font-bold text-lg leading-snug">{{ $student->major }}</p>
            </div>
            <!-- GPA -->
            <div class="bg-slate-50 dark:bg-slate-800/50 rounded-xl p-4 border border-slate-100 dark:border-slate-700/50">
              <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-2">GPA</p>
              <p class="text-slate-900 dark:text-white font-bold leading-none">
                <span class="text-[2rem]">3.8</span>
                <span class="text-sm text-slate-400 dark:text-slate-500 font-medium"> / 4.0</span>
              </p>
              <!-- GPA bar -->
              <div class="mt-3 h-1.5 rounded-full bg-slate-200 dark:bg-slate-700 overflow-hidden">
                <div class="h-full rounded-full bg-blue-500" style="width:95%"></div>
              </div>
            </div>
            <!-- Year -->
            <div class="bg-slate-50 dark:bg-slate-800/50 rounded-xl p-4 border border-slate-100 dark:border-slate-700/50">
              <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-2">Current Year</p>
              <p class="text-slate-900 dark:text-white font-bold text-lg">Sophomore</p>
              <div class="flex gap-1 mt-3">
                <div class="h-1.5 flex-1 rounded-full bg-blue-500"></div>
                <div class="h-1.5 flex-1 rounded-full bg-blue-500"></div>
                <div class="h-1.5 flex-1 rounded-full bg-slate-200 dark:bg-slate-700"></div>
                <div class="h-1.5 flex-1 rounded-full bg-slate-200 dark:bg-slate-700"></div>
              </div>
              <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1.5">Year 2 of 4</p>
            </div>
          </div>

          <!-- Course Progress -->
          <div class="mt-5 pt-5 border-t border-slate-100 dark:border-slate-800">
            <p class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">Current Courses</p>
            <div class="space-y-3">
              <div>
                <div class="flex justify-between text-xs mb-1">
                  <span class="text-slate-600 dark:text-slate-400">Data Structures &amp; Algorithms</span>
                  <span class="font-semibold text-slate-700 dark:text-slate-300">92%</span>
                </div>
                <div class="h-1.5 rounded-full bg-slate-200 dark:bg-slate-700 overflow-hidden">
                  <div class="h-full rounded-full bg-emerald-500" style="width:92%"></div>
                </div>
              </div>
              <div>
                <div class="flex justify-between text-xs mb-1">
                  <span class="text-slate-600 dark:text-slate-400">Introduction to Algorithms</span>
                  <span class="font-semibold text-slate-700 dark:text-slate-300">85%</span>
                </div>
                <div class="h-1.5 rounded-full bg-slate-200 dark:bg-slate-700 overflow-hidden">
                  <div class="h-full rounded-full bg-blue-500" style="width:85%"></div>
                </div>
              </div>
              <div>
                <div class="flex justify-between text-xs mb-1">
                  <span class="text-slate-600 dark:text-slate-400">Discrete Mathematics</span>
                  <span class="font-semibold text-slate-700 dark:text-slate-300">78%</span>
                </div>
                <div class="h-1.5 rounded-full bg-slate-200 dark:bg-slate-700 overflow-hidden">
                  <div class="h-full rounded-full bg-amber-400" style="width:78%"></div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Personal Information -->
        <div class="animate-fu3 bg-white dark:bg-[#161B22] rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-6">
          <h2 class="flex items-center gap-2.5 font-semibold text-slate-800 dark:text-white text-[1.05rem] mb-5">
            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>
            Personal Information
          </h2>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-5">
            <div>
              <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-1">Email Address</p>
              <a href="mailto:{{ $student->email }}" class="text-sm font-medium text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400 break-all">{{ $student->email }}</a>
            </div>
            <div>
              <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-1">Phone Number</p>
              <p class="text-sm font-medium text-slate-700 dark:text-slate-300">+1 (555) 123-4567</p>
            </div>
            <div>
              <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-1">Date of Birth</p>
              <p class="text-sm font-medium text-slate-700 dark:text-slate-300">May 14, 2004</p>
            </div>
            <div>
              <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-1">Address</p>
              <p class="text-sm font-medium text-slate-700 dark:text-slate-300">123 College Ave, Apt 4B, Cambridge, MA</p>
            </div>
            <div>
              <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-1">Nationality</p>
              <p class="text-sm font-medium text-slate-700 dark:text-slate-300">American</p>
            </div>
            <div>
              <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-1">Enrollment Date</p>
              <p class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $student->created_at->format('F j, Y') }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- RIGHT COL – Recent Activity -->
      <div class="animate-fu4 bg-white dark:bg-[#161B22] rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 flex flex-col">
        <h2 class="flex items-center gap-2.5 font-semibold text-slate-800 dark:text-white text-[1.05rem] mb-5">
          <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
          Recent Activity
        </h2>

        <div class="flex-1 space-y-1">

          <!-- Item -->
          <div class="flex gap-3 py-3 border-b border-slate-100 dark:border-slate-800">
            <div class="w-9 h-9 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center shrink-0 text-blue-500">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
            </div>
            <div class="min-w-0">
              <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">Submitted Assignment</p>
              <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Introduction to Algorithms - Lab 4</p>
              <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">2 hours ago</p>
            </div>
          </div>

          <!-- Item -->
          <div class="flex gap-3 py-3 border-b border-slate-100 dark:border-slate-800">
            <div class="w-9 h-9 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center shrink-0 text-emerald-500">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
            </div>
            <div class="min-w-0">
              <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">Grade Received</p>
              <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">A+ in Data Structures Quiz</p>
              <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Yesterday, 4:30 PM</p>
            </div>
          </div>

          <!-- Item -->
          <div class="flex gap-3 py-3 border-b border-slate-100 dark:border-slate-800">
            <div class="w-9 h-9 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center shrink-0 text-amber-500">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></svg>
            </div>
            <div class="min-w-0">
              <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">Attended Workshop</p>
              <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Career Development Seminar</p>
              <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Oct 24, 2023</p>
            </div>
          </div>

          <!-- Item -->
          <div class="flex gap-3 py-3 border-b border-slate-100 dark:border-slate-800">
            <div class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center shrink-0 text-slate-500 dark:text-slate-400">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15"/></svg>
            </div>
            <div class="min-w-0">
              <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">Logged into Portal</p>
              <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Accessed Student Resources</p>
              <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Oct 23, 2023</p>
            </div>
          </div>

          <!-- Item -->
          <div class="flex gap-3 py-3">
            <div class="w-9 h-9 rounded-xl bg-violet-100 dark:bg-violet-900/30 flex items-center justify-center shrink-0 text-violet-500">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487 18.549 2.8a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125"/></svg>
            </div>
            <div class="min-w-0">
              <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">Enrolled in New Course</p>
              <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Web Development Fundamentals</p>
              <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Oct 20, 2023</p>
            </div>
          </div>
        </div>

        <button class="mt-5 w-full py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-sm font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/60 hover:text-slate-800 dark:hover:text-white">
          View All Activity
        </button>
      </div>
    </div>

  </main>
</div>

<!-- ═══════════════════  DELETE CONFIRM MODAL  ═══════════════════ -->
<div id="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
  <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
  <div class="relative bg-white dark:bg-[#1C2128] rounded-2xl border border-slate-200 dark:border-slate-700 shadow-2xl p-6 w-full max-w-sm animate-fu1">
    <div class="w-12 h-12 rounded-2xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center mx-auto mb-4 text-red-500">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
    </div>
    <h3 class="text-center font-semibold text-slate-900 dark:text-white text-lg mb-1">Delete Student</h3>
    <p class="text-center text-sm text-slate-500 dark:text-slate-400 mb-6">Are you sure you want to delete <strong>{{ $student->name }}</strong>? This action cannot be undone.</p>
    <div class="flex gap-3">
      <button onclick="closeDeleteModal()" class="flex-1 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-sm font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800">Cancel</button>
      <button class="flex-1 py-2.5 rounded-xl bg-red-500 hover:bg-red-600 text-white text-sm font-semibold">Delete</button>
    </div>
  </div>
</div>

<!-- ═══════════════════  EDIT PROFILE MODAL  ═══════════════════ -->
<div id="editModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
  <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeEditModal()"></div>
  <div class="relative bg-white dark:bg-[#1C2128] rounded-2xl border border-slate-200 dark:border-slate-700 shadow-2xl p-6 w-full max-w-md animate-fu1">
    <div class="flex items-center justify-between mb-5">
      <h3 class="font-semibold text-slate-900 dark:text-white text-lg">Edit Profile</h3>
      <button onclick="closeEditModal()" class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:bg-slate-200 dark:hover:bg-slate-700">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
      </button>
    </div>
    <div class="space-y-4">
      <div class="grid grid-cols-2 gap-4">
        <div class="col-span-2">
          <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-1.5">Full Name</label>
          <input type="text" name="name" value="{{ $student->name }}" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/60 text-sm text-slate-800 dark:text-slate-200 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:focus:ring-blue-900/40" />
        </div>
      </div>
      <div>
        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-1.5">Email Address</label>
        <input type="email" name="email" value="{{ $student->email }}" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/60 text-sm text-slate-800 dark:text-slate-200 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:focus:ring-blue-900/40" />
      </div>
      <div>
        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-1.5">Major</label>
        <input type="text" name="major" value="{{ $student->major }}" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/60 text-sm text-slate-800 dark:text-slate-200 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:focus:ring-blue-900/40" />
      </div>
    </div>
    <div class="flex gap-3 mt-6">
      <button onclick="closeEditModal()" class="flex-1 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-sm font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800">Cancel</button>
      <button onclick="closeEditModal()" class="flex-1 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold shadow-md shadow-blue-200 dark:shadow-blue-900/30">Save Changes</button>
    </div>
  </div>
</div>

<!-- ═══════════════════  MESSAGE MODAL  ═══════════════════ -->
<div id="messageModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
  <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeMessageModal()"></div>
  <div class="relative bg-white dark:bg-[#1C2128] rounded-2xl border border-slate-200 dark:border-slate-700 shadow-2xl p-6 w-full max-w-md animate-fu1">
    <div class="flex items-center justify-between mb-5">
      <h3 class="font-semibold text-slate-900 dark:text-white text-lg">Send Message</h3>
      <button onclick="closeMessageModal()" class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:bg-slate-200 dark:hover:bg-slate-700">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
      </button>
    </div>
    <div class="space-y-4">
      <div>
        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-1.5">To</label>
        <div class="px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/60 text-sm text-slate-500 dark:text-slate-400">{{ $student->email }}</div>
      </div>
      <div>
        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-1.5">Subject</label>
        <input type="text" placeholder="e.g. Academic Performance Update" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/60 text-sm text-slate-800 dark:text-slate-200 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:focus:ring-blue-900/40 placeholder-slate-400" />
      </div>
      <div>
        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-1.5">Message</label>
        <textarea rows="4" placeholder="Write your message here..." class="w-full px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/60 text-sm text-slate-800 dark:text-slate-200 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:focus:ring-blue-900/40 placeholder-slate-400 resize-none"></textarea>
      </div>
    </div>
    <div class="flex gap-3 mt-6">
      <button onclick="closeMessageModal()" class="flex-1 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-sm font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800">Cancel</button>
      <button onclick="closeMessageModal()" class="flex-1 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold shadow-md shadow-blue-200 dark:shadow-blue-900/30 flex items-center justify-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5"/></svg>
        Send Message
      </button>
    </div>
  </div>
</div>

<!-- ═══════════════════  SCRIPTS  ═══════════════════ -->
<script>
  /* ── THEME ─────────────────────────── */
  const html  = document.documentElement;
  const thumb = document.getElementById('thumb');

  function applyTheme(dark) {
    if (dark) { html.classList.add('dark');    thumb.style.transform = 'translateX(24px)'; }
    else       { html.classList.remove('dark'); thumb.style.transform = 'translateX(0)'; }
  }

  function toggleTheme() {
    const dark = !html.classList.contains('dark');
    localStorage.setItem('theme', dark ? 'dark' : 'light');
    applyTheme(dark);
  }

  (function(){
    const saved = localStorage.getItem('theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    applyTheme(saved === 'dark' || (!saved && prefersDark));
  })();

  /* ── MODALS ─────────────────────────── */
  function confirmDelete()     { document.getElementById('deleteModal').classList.remove('hidden'); }
  function closeDeleteModal()  { document.getElementById('deleteModal').classList.add('hidden'); }
  function openEditModal()     { document.getElementById('editModal').classList.remove('hidden'); }
  function closeEditModal()    { document.getElementById('editModal').classList.add('hidden'); }
  function openMessageModal()  { document.getElementById('messageModal').classList.remove('hidden'); }
  function closeMessageModal() { document.getElementById('messageModal').classList.add('hidden'); }

  // Close modals on Escape key
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
      closeDeleteModal();
      closeEditModal();
      closeMessageModal();
    }
  });
</script>
</body>
</html>