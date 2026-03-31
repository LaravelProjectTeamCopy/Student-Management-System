<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>EduAdmin - {{ $title ?? 'Auth' }}</title>

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
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100 min-h-screen flex flex-col">
<div class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden">
<div class="layout-container flex h-full grow flex-col">

    <main class="flex flex-1 items-center justify-center p-4">
        {{ $slot }}
    </main>

</div>
</div>
</body>
</html>