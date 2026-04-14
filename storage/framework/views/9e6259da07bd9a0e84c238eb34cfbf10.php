<!DOCTYPE html>
<html lang="en">
<script>
    if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
</script>

<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>EduAdmin - <?php echo e($title); ?></title>

    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    
    <script src="<?php echo e(asset('js/tailwind.config.js')); ?>"></script>

    <style>
        body { font-family: 'Lexend', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen">
<?php if(session('success')): ?>
    <div class="fixed top-4 left-1/2 -translate-x-1/2 z-50 bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300 px-6 py-3 rounded-lg shadow-lg">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>
<div class="flex h-screen overflow-hidden">

    
    <aside class="w-64 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 flex flex-col">

        
        <div class="p-6 flex items-center gap-3">
            <div class="bg-primary p-1.5 rounded-lg text-white">
                <span class="material-symbols-outlined text-2xl">school</span>
            </div>
            <h2 class="text-lg font-bold tracking-tight text-slate-900 dark:text-white leading-tight">
                EduAdmin
            </h2>
        </div>

        
        <nav class="flex-1 px-4 space-y-1 overflow-y-auto">
    
            <a href="/dashboard" class="flex items-center gap-3 px-3 py-2 rounded-lg <?php echo e(request()->is('dashboard') ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800'); ?>">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="text-sm font-medium leading-normal">Dashboard</span>
            </a>

            <a href="/student" class="flex items-center gap-3 px-3 py-2 rounded-lg <?php echo e(request()->is('student*') ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800'); ?>">
                <span class="material-symbols-outlined">group</span>
                <span class="text-sm font-medium leading-normal">Student Directory</span>
            </a>

            <a href="/academics" class="flex items-center gap-3 px-3 py-2 rounded-lg <?php echo e(request()->is('academics*') ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800'); ?>">
                <span class="material-symbols-outlined">school</span>
                <span class="text-sm font-medium leading-normal">Academic Record</span>
            </a>

            <a href="/attendances" class="flex items-center gap-3 px-3 py-2 rounded-lg <?php echo e(request()->is('attendances*') ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800'); ?>">
                <span class="material-symbols-outlined">description</span>
                <span class="text-sm font-medium leading-normal">Attendance Record</span>
            </a>

            <a href="/financials" class="flex items-center gap-3 px-3 py-2 rounded-lg <?php echo e(request()->is('financials*') ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800'); ?>">
                <span class="material-symbols-outlined">payments</span>
                <span class="text-sm font-medium leading-normal">Financials</span>
            </a>

            
            <div class="pt-4 pb-2 text-xs font-semibold text-slate-400 uppercase px-3 tracking-wider">
                System
            </div>

            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg <?php echo e(request()->is('settings*') ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800'); ?>">
                <span class="material-symbols-outlined">settings</span>
                <span class="text-sm font-medium leading-normal">Settings</span>
            </a>

        </nav>

        
        <div class="p-4 border-t border-slate-200 dark:border-slate-800">
            <div class="flex items-center gap-3 px-2 py-3 bg-slate-50 dark:bg-slate-800/50 rounded-xl">
                <div class="size-10 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold">
                    <?php echo e(strtoupper(substr($user->name, 0, 1))); ?><?php echo e(strtoupper(substr(strrchr($user->name, ' '), 1, 1))); ?>

                </div>
                <div class="flex flex-col flex-1 min-w-0">
                    <p class="text-xs font-bold truncate"><?php echo e($user->name); ?></p>
                    <p class="text-[10px] text-slate-500">Administrator</p>
                </div>
                <form method="POST" action="<?php echo e(route('handleLogout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit"
                        class="text-slate-400 hover:text-red-500 dark:hover:text-red-400 transition-colors"
                        title="Logout">
                        <span class="material-symbols-outlined text-xl">logout</span>
                    </button>
                </form>
            </div>
        </div>

    </aside>

    
    <main class="flex-1 flex flex-col overflow-hidden">

        
        <header class="h-16 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 px-8 flex items-center justify-between shrink-0">

            
            <div class="flex items-center gap-2 text-sm font-medium text-slate-500">
                <?php echo e($breadcrumb ?? ''); ?>

            </div>

            
            <div class="flex items-center gap-3 ml-auto">

                
                <div class="relative flex items-center">
                    <?php echo e($search ?? ''); ?>

                </div>
                
                <button class="size-10 flex items-center justify-center rounded-full text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800">
                    <span class="material-symbols-outlined">notifications</span>
                </button>

                
                <button onclick="toggleTheme()" id="theme-toggle" class="size-10 flex items-center justify-center rounded-full text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" title="Toggle dark mode">
                    <span class="material-symbols-outlined dark:hidden">dark_mode</span>
                    <span class="material-symbols-outlined hidden dark:inline">light_mode</span>
                </button>

            </div>
        </header>

        
        <div class="flex-1 overflow-y-auto p-8">
            <?php echo e($slot); ?>

        </div>

    </main>

</div>
<script>
    function toggleTheme() {
        const html = document.documentElement;
        if (html.classList.contains('dark')) {
            html.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        } else {
            html.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        }
    }
</script>
</body>
</html><?php /**PATH D:\Student-Management-System\resources\views/components/layouts/master.blade.php ENDPATH**/ ?>