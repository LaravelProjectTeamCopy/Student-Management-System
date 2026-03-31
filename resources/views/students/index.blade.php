<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>EduAdmin – Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet" />
  <script>
    (() => {
      const stored = localStorage.getItem('theme');
      const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
      const enableDark = stored ? stored === 'dark' : prefersDark;
      document.documentElement.classList.toggle('dark', enableDark);
    })();
  </script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          fontFamily: {
            sans:  ['DM Sans',  'sans-serif'],
            serif: ['Instrument Serif', 'serif'],
          },
          keyframes: {
            fadeUp: {
              '0%':   { opacity: '0', transform: 'translateY(18px)' },
              '100%': { opacity: '1', transform: 'translateY(0)' },
            }
          },
          animation: {
            'fu1': 'fadeUp .5s ease both',
            'fu2': 'fadeUp .5s .07s ease both',
            'fu3': 'fadeUp .5s .14s ease both',
            'fu4': 'fadeUp .5s .21s ease both',
            'fu5': 'fadeUp .5s .28s ease both',
            'fu6': 'fadeUp .5s .35s ease both',
          }
        }
      }
    }
  </script>
  <style>
    ::-webkit-scrollbar            { width:5px; height:5px }
    ::-webkit-scrollbar-track      { background:transparent }
    ::-webkit-scrollbar-thumb      { background:#CBD5E1; border-radius:99px }
    .dark ::-webkit-scrollbar-thumb{ background:#334155 }

    /* smooth theme switch for everything except canvas */
    *:not(canvas) { transition: background-color .25s ease, border-color .25s ease, color .2s ease; }

    @keyframes pulseRing {
      0%   { box-shadow:0 0 0 0 rgba(16,185,129,.55) }
      70%  { box-shadow:0 0 0 7px rgba(16,185,129,0) }
      100% { box-shadow:0 0 0 0 rgba(16,185,129,0) }
    }
    .pulse { animation: pulseRing 2s infinite; }
  </style>
</head>

<body class="bg-slate-100 dark:bg-[#0D1117] font-sans text-slate-800 dark:text-slate-200 min-h-screen flex">

<!-- ═══════════════════════════  SIDEBAR  ═══════════════════════════ -->
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

  <!-- Nav links -->
  <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">
    <p class="text-[10px] font-semibold uppercase tracking-widest text-slate-400 dark:text-slate-600 px-3 pb-2">Main</p>

    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400">
      <svg class="w-[18px] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z"/></svg>
      Overview
    </a>

    <a href="{{ route('students.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-white">
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
      <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-semibold shrink-0">AU</div>
      <div class="min-w-0">
        <p class="text-sm font-medium text-slate-800 dark:text-slate-200 truncate">Admin User</p>
        <p class="text-xs text-slate-400 dark:text-slate-500">Super Admin</p>
      </div>
    </div>
  </div>
</aside>

<!-- ═══════════════════════════  MAIN  ═══════════════════════════ -->
<div class="flex-1 flex flex-col min-w-0">

  <!-- Top bar -->
  <header class="sticky top-0 z-40 bg-white/80 dark:bg-[#161B22]/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 flex items-center gap-4 px-7 py-3.5">
    <!-- Breadcrumb -->
    <div class="flex items-center gap-1.5 text-sm text-slate-400 dark:text-slate-500">
      <span>Pages</span>
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
      <span class="text-slate-700 dark:text-slate-300 font-medium">Dashboard</span>
    </div>

    <div class="ml-auto flex items-center gap-3">
      <!-- Search -->
      <div class="relative hidden sm:block">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
        <input type="text" placeholder="Search..." class="pl-9 pr-4 py-2 rounded-xl text-sm bg-slate-100 dark:bg-slate-800 border border-transparent focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:focus:ring-blue-900/40 outline-none text-slate-700 dark:text-slate-300 placeholder-slate-400 w-52" />
      </div>

      <!-- ✦ DARK / LIGHT TOGGLE ✦ -->
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

  <!-- Content -->
  <main class="flex-1 px-7 py-7 overflow-y-auto">

    <!-- Greeting -->
    <div class="mb-7 animate-fu1">
      <h1 class="font-serif text-2xl text-slate-900 dark:text-white">Good morning, Admin 👋</h1>
      <p class="text-sm text-slate-400 dark:text-slate-500 mt-0.5">Here's what's happening across your institution today.</p>
    </div>

    <!-- ── STAT CARDS ── -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-5">

      <div class="animate-fu2 bg-white dark:bg-[#161B22] rounded-2xl p-5 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md">
        <div class="flex items-center justify-between mb-4">
          <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Students</p>
          <span class="text-[11px] font-bold px-2 py-0.5 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400">+5.2%</span>
        </div>
        <p class="text-[2rem] font-bold text-slate-900 dark:text-white tracking-tight leading-none mb-4">1,284</p>
        <div class="h-[3px] w-16 rounded-full bg-blue-500"></div>
      </div>

      <div class="animate-fu3 bg-white dark:bg-[#161B22] rounded-2xl p-5 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md">
        <div class="flex items-center justify-between mb-4">
          <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Active Students</p>
          <span class="text-[11px] font-bold px-2 py-0.5 rounded-full bg-red-100 dark:bg-red-900/30 text-red-500 dark:text-red-400">-1.2%</span>
        </div>
        <p class="text-[2rem] font-bold text-slate-900 dark:text-white tracking-tight leading-none mb-4">1,150</p>
        <div class="h-[3px] w-16 rounded-full bg-blue-500"></div>
      </div>

      <div class="animate-fu4 bg-white dark:bg-[#161B22] rounded-2xl p-5 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md">
        <div class="flex items-center justify-between mb-4">
          <p class="text-sm font-medium text-slate-500 dark:text-slate-400">New Enrollments</p>
          <span class="text-[11px] font-bold px-2 py-0.5 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400">+12.5%</span>
        </div>
        <p class="text-[2rem] font-bold text-slate-900 dark:text-white tracking-tight leading-none mb-4">42</p>
        <div class="h-[3px] w-16 rounded-full bg-blue-500"></div>
      </div>
    </div>

    <!-- ── CHARTS ── -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-5">

      <!-- Enrollment trend -->
      <div class="animate-fu5 lg:col-span-2 bg-white dark:bg-[#161B22] rounded-2xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm">
        <div class="flex items-center justify-between mb-5">
          <h2 class="font-semibold text-slate-800 dark:text-white">Student Enrollment Trends</h2>
          <select class="text-xs font-medium px-3 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-400 outline-none cursor-pointer">
            <option>Last 6 Months</option>
            <option>Last 12 Months</option>
            <option>This Year</option>
          </select>
        </div>
        <div class="h-52"><canvas id="enrollChart"></canvas></div>
      </div>

      <!-- Dept donut -->
      <div class="animate-fu6 bg-white dark:bg-[#161B22] rounded-2xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm">
        <h2 class="font-semibold text-slate-800 dark:text-white mb-5">Department Distribution</h2>
        <div class="flex justify-center mb-5">
          <div class="relative w-36 h-36">
            <canvas id="deptChart"></canvas>
            <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
              <span class="text-2xl font-bold text-slate-900 dark:text-white">1.2k</span>
              <span class="text-[10px] uppercase tracking-widest text-slate-400 dark:text-slate-500 font-medium">Total</span>
            </div>
          </div>
        </div>
        <div class="space-y-2.5 text-sm">
          <div class="flex items-center justify-between">
            <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-blue-500 inline-block"></span><span class="text-slate-600 dark:text-slate-400">Science</span></span>
            <span class="font-semibold text-slate-700 dark:text-slate-300">40%</span>
          </div>
          <div class="flex items-center justify-between">
            <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block"></span><span class="text-slate-600 dark:text-slate-400">Arts</span></span>
            <span class="font-semibold text-slate-700 dark:text-slate-300">30%</span>
          </div>
          <div class="flex items-center justify-between">
            <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-amber-400 inline-block"></span><span class="text-slate-600 dark:text-slate-400">Tech</span></span>
            <span class="font-semibold text-slate-700 dark:text-slate-300">20%</span>
          </div>
          <div class="flex items-center justify-between">
            <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-slate-300 dark:bg-slate-600 inline-block"></span><span class="text-slate-600 dark:text-slate-400">Other</span></span>
            <span class="font-semibold text-slate-700 dark:text-slate-300">10%</span>
          </div>
        </div>
      </div>
    </div>

    <!-- ── RECENT ACTIVITIES ── -->
    <div class="bg-white dark:bg-[#161B22] rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
      <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 dark:border-slate-800">
        <h2 class="font-semibold text-slate-800 dark:text-white">Recent Activities</h2>
        <button class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">View All</button>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr class="bg-slate-50 dark:bg-slate-800/40">
              <th class="text-left text-[11px] font-semibold uppercase tracking-widest text-slate-400 dark:text-slate-500 px-6 py-3">Activity</th>
              <th class="text-left text-[11px] font-semibold uppercase tracking-widest text-slate-400 dark:text-slate-500 px-4 py-3">User / Student</th>
              <th class="text-left text-[11px] font-semibold uppercase tracking-widest text-slate-400 dark:text-slate-500 px-4 py-3">Category</th>
              <th class="text-left text-[11px] font-semibold uppercase tracking-widest text-slate-400 dark:text-slate-500 px-4 py-3">Time</th>
              <th class="text-left text-[11px] font-semibold uppercase tracking-widest text-slate-400 dark:text-slate-500 px-4 py-3">Status</th>
            </tr>
          </thead>
          <tbody id="activityTable" class="divide-y divide-slate-100 dark:divide-slate-800"></tbody>
        </table>
      </div>
    </div>

  </main>
</div>

<!-- ═══════════════════════════  JS  ═══════════════════════════ -->
<script>
/* ── THEME ─────────────────────────────── */
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
  rebuildCharts();
}

// init
(function(){
  const saved = localStorage.getItem('theme');
  const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
  applyTheme(saved === 'dark' || (!saved && prefersDark));
})();


/* ── ACTIVITY DATA ─────────────────────── */
const activities = [
  { icon:'user-plus',  iconBg:'bg-blue-100 dark:bg-blue-900/30',   iconColor:'text-blue-500',   text:'New student registered',           user:'Sarah Jenkins',  cat:'Enrollment', time:'2 mins ago',  status:'COMPLETED', statusBg:'bg-emerald-100 dark:bg-emerald-900/30', statusTx:'text-emerald-600 dark:text-emerald-400' },
  { icon:'pencil',     iconBg:'bg-violet-100 dark:bg-violet-900/30',iconColor:'text-violet-500', text:'Grades updated for Alex Rivers',    user:'Alex Rivers',    cat:'Academic',   time:'15 mins ago', status:'UPDATED',   statusBg:'bg-blue-100 dark:bg-blue-900/30',     statusTx:'text-blue-600 dark:text-blue-400'     },
  { icon:'cash',       iconBg:'bg-amber-100 dark:bg-amber-900/30',  iconColor:'text-amber-500',  text:'Financial record added',            user:'Marcus Thorne',  cat:'Financial',  time:'1 hour ago',  status:'COMPLETED', statusBg:'bg-emerald-100 dark:bg-emerald-900/30', statusTx:'text-emerald-600 dark:text-emerald-400' },
  { icon:'alert',      iconBg:'bg-rose-100 dark:bg-rose-900/30',    iconColor:'text-rose-500',   text:'Attendance alert triggered',        user:'Priya Nair',     cat:'Academic',   time:'2 hours ago', status:'PENDING',   statusBg:'bg-amber-100 dark:bg-amber-900/30',   statusTx:'text-amber-600 dark:text-amber-500'   },
  { icon:'check',      iconBg:'bg-teal-100 dark:bg-teal-900/30',    iconColor:'text-teal-500',   text:'Course schedule published',         user:'Admin User',     cat:'System',     time:'3 hours ago', status:'COMPLETED', statusBg:'bg-emerald-100 dark:bg-emerald-900/30', statusTx:'text-emerald-600 dark:text-emerald-400' },
];

const iconSvgs = {
  'user-plus': `<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z"/></svg>`,
  'pencil':    `<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487 18.549 2.8a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125"/></svg>`,
  'cash':      `<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75"/></svg>`,
  'alert':     `<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/></svg>`,
  'check':     `<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>`,
};

function renderTable() {
  const tbody = document.getElementById('activityTable');
  tbody.innerHTML = activities.map(a => `
    <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/30 transition-colors">
      <td class="px-6 py-4">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 rounded-xl ${a.iconBg} flex items-center justify-center shrink-0 ${a.iconColor}">${iconSvgs[a.icon]}</div>
          <span class="text-sm font-medium text-slate-700 dark:text-slate-300">${a.text}</span>
        </div>
      </td>
      <td class="px-4 py-4 text-sm text-slate-600 dark:text-slate-400 whitespace-nowrap">${a.user}</td>
      <td class="px-4 py-4 text-sm text-slate-500 dark:text-slate-500 whitespace-nowrap">${a.cat}</td>
      <td class="px-4 py-4 text-sm text-slate-400 dark:text-slate-500 whitespace-nowrap">${a.time}</td>
      <td class="px-4 py-4 whitespace-nowrap">
        <span class="text-[11px] font-bold px-2.5 py-1 rounded-full ${a.statusBg} ${a.statusTx} uppercase tracking-wide">${a.status}</span>
      </td>
    </tr>
  `).join('');
}
renderTable();


/* ── CHARTS ─────────────────────────────── */
let enrollInst = null, deptInst = null;

function isDark() { return html.classList.contains('dark'); }

function buildEnrollChart() {
  const ctx = document.getElementById('enrollChart').getContext('2d');
  const dark = isDark();
  const grad = ctx.createLinearGradient(0, 0, 0, 200);
  grad.addColorStop(0, dark ? 'rgba(59,130,246,.3)' : 'rgba(59,130,246,.18)');
  grad.addColorStop(1, 'rgba(59,130,246,0)');

  enrollInst = new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Jan','Feb','Mar','Apr','May','Jun'],
      datasets: [{
        data: [320, 415, 480, 625, 780, 720],
        fill: true,
        backgroundColor: grad,
        borderColor: '#3B82F6',
        borderWidth: 2.5,
        pointRadius: 0,
        pointHoverRadius: 5,
        pointHoverBackgroundColor: '#3B82F6',
        tension: 0.45,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: dark ? '#1e293b' : '#fff',
          titleColor:       dark ? '#e2e8f0' : '#1e293b',
          bodyColor:        dark ? '#94a3b8' : '#64748b',
          borderColor:      dark ? '#334155' : '#e2e8f0',
          borderWidth: 1, padding: 10,
          callbacks: { label: c => ` ${c.parsed.y} students` }
        }
      },
      scales: {
        x: { grid:{ display:false }, ticks:{ color: dark?'#64748b':'#94a3b8', font:{size:11} }, border:{display:false} },
        y: { grid:{ color: dark?'rgba(255,255,255,.05)':'rgba(0,0,0,.05)' }, ticks:{ color: dark?'#64748b':'#94a3b8', font:{size:11}, maxTicksLimit:5 }, border:{display:false} }
      }
    }
  });
}

function buildDeptChart() {
  const ctx = document.getElementById('deptChart').getContext('2d');
  const dark = isDark();
  deptInst = new Chart(ctx, {
    type: 'doughnut',
    data: {
      datasets: [{
        data: [40, 30, 20, 10],
        backgroundColor: ['#3B82F6','#10B981','#F59E0B', dark ? '#334155' : '#E2E8F0'],
        borderWidth: 0,
        hoverOffset: 4,
      }]
    },
    options: {
      responsive: true, maintainAspectRatio: true, cutout: '74%',
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: dark ? '#1e293b' : '#fff',
          titleColor:       dark ? '#e2e8f0' : '#1e293b',
          bodyColor:        dark ? '#94a3b8' : '#64748b',
          borderColor:      dark ? '#334155' : '#e2e8f0',
          borderWidth: 1,
          callbacks: { label: c => ` ${c.parsed}%` }
        }
      }
    }
  });
}

function rebuildCharts() {
  if (enrollInst) enrollInst.destroy();
  if (deptInst)   deptInst.destroy();
  buildEnrollChart();
  buildDeptChart();
}

window.addEventListener('DOMContentLoaded', () => {
  buildEnrollChart();
  buildDeptChart();
});
</script>
</body>
</html>