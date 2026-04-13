<?php if (isset($component)) { $__componentOriginal09ae9edb6a4f3743836239ca1a9c4719 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal09ae9edb6a4f3743836239ca1a9c4719 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.master','data' => ['title' => ''.e($student->name).' â€” Academic Record']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.master'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => ''.e($student->name).' â€” Academic Record']); ?>

     <?php $__env->slot('breadcrumb', null, []); ?> 
        <?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['links' => ['Dashboard' => '/dashboard', 'Academic Records' => route('academicrecords.index')],'current' => ''.e($student->name).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['links' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['Dashboard' => '/dashboard', 'Academic Records' => route('academicrecords.index')]),'current' => ''.e($student->name).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2)): ?>
<?php $attributes = $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2; ?>
<?php unset($__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale19f62b34dfe0bfdf95075badcb45bc2)): ?>
<?php $component = $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2; ?>
<?php unset($__componentOriginale19f62b34dfe0bfdf95075badcb45bc2); ?>
<?php endif; ?>
     <?php $__env->endSlot(); ?>

    
    <div class="mb-8 flex flex-col items-start justify-between gap-6 rounded-xl bg-white p-6 shadow-sm dark:bg-slate-900 border border-slate-200 dark:border-slate-800 lg:flex-row lg:items-center">
        <div class="flex items-center gap-6">
            <div class="h-20 w-20 rounded-full ring-4 ring-slate-50 dark:ring-slate-800 bg-primary/10 flex items-center justify-center text-primary text-xl font-bold uppercase">
                <?php echo e(strtoupper(substr($student->name, 0, 1))); ?><?php echo e(strtoupper(substr(strrchr($student->name, ' ') ?: '', 1, 1))); ?>

            </div>
            <div>
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white"><?php echo e($student->name); ?></h2>
                <div class="mt-1 flex flex-wrap gap-x-4 gap-y-1">
                    <span class="text-sm text-slate-500"><?php echo e($student->student_code ?? ''); ?></span>
                    <span class="text-sm text-slate-500"><?php echo e($student->email); ?></span>
                    <span class="inline-block px-2 py-0.5 rounded-md bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 text-xs font-bold uppercase">
                        <?php echo e($student->major); ?>

                    </span>
                </div>
            </div>
        </div>
        <a href="<?php echo e(route('students.show', $student->id)); ?>" class="flex items-center gap-2 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 px-4 py-2 text-sm font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
            <span class="material-symbols-outlined text-sm">person</span>
            View Full Profile
        </a>
    </div>

    
    <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 flex flex-wrap items-center gap-6 mb-6 shadow-sm">
        <div class="flex items-center gap-3">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Year:</span>
            <div class="flex gap-1.5">
                <?php $__currentLoopData = ['2023/2024', '2024/2025', '2025/2026']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="?year=<?php echo e($year); ?>&semester=<?php echo e($currentSem); ?>"
                       class="px-3 py-1.5 rounded-lg border text-xs font-bold transition-all
                       <?php echo e($currentYear == $year
                           ? 'bg-slate-900 dark:bg-white text-white dark:text-slate-900 border-slate-900 dark:border-white shadow-sm'
                           : 'bg-white dark:bg-slate-900 border-slate-100 dark:border-slate-800 text-slate-500 hover:border-slate-300'); ?>">
                        <?php echo e($year); ?>

                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <div class="h-8 w-px bg-slate-200 dark:bg-slate-800"></div>
        <div class="flex items-center gap-3">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Semester:</span>
            <div class="flex gap-1.5">
                <?php $__currentLoopData = ['Semester 1', 'Semester 2']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="?semester=<?php echo e($sem); ?>&year=<?php echo e($currentYear); ?>"
                       class="px-3 py-1.5 rounded-lg border text-xs font-bold transition-all
                       <?php echo e($currentSem == $sem
                           ? 'bg-slate-900 dark:bg-white text-white dark:text-slate-900 border-slate-900 dark:border-white shadow-sm'
                           : 'bg-white dark:bg-slate-900 border-slate-100 dark:border-slate-800 text-slate-500 hover:border-slate-300'); ?>">
                        <?php echo e($sem); ?>

                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

    
    <?php
        $totalSubjects = $filteredScores->count();
        $passed = $filteredScores->where('total_score', '>=', 50)->count();
        $failed = $filteredScores->where('total_score', '<', 50)->count();
        $highest = $filteredScores->max('total_score') ?? 0;

        $stats = [
            ['label' => 'Average Score',   'val' => number_format($avgScore, 1),  'icon' => 'analytics',  'color' => 'text-primary'],
            ['label' => 'Subjects Taken',  'val' => $totalSubjects,               'icon' => 'menu_book',  'color' => 'text-blue-500'],
            ['label' => 'Passed',          'val' => $passed,                       'icon' => 'verified',   'color' => 'text-emerald-500'],
            ['label' => 'Failed',          'val' => $failed,                       'icon' => 'warning',    'color' => 'text-red-500'],
            ['label' => 'Highest Score',   'val' => number_format($highest, 1),   'icon' => 'trophy',     'color' => 'text-amber-500'],
        ];
    ?>
    <div class="grid grid-cols-2 sm:grid-cols-5 gap-4 mb-6">
        <?php $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="bg-white dark:bg-slate-900 rounded-xl p-4 border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400"><?php echo e($stat['label']); ?></p>
                <span class="material-symbols-outlined text-lg <?php echo e($stat['color']); ?>"><?php echo e($stat['icon']); ?></span>
            </div>
            <h3 class="text-2xl font-bold text-slate-900 dark:text-white"><?php echo e($stat['val']); ?></h3>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    
    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">
        <div class="p-5 border-b border-slate-100 dark:border-slate-800 flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">school</span>
            <h3 class="text-base font-bold text-slate-900 dark:text-white">Subject Scores â€” <?php echo e($currentSem); ?>, <?php echo e($currentYear); ?></h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Subject</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-center">Attendance</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-center">Quiz</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-center">Midterm</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-center">Final Exam</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-center">Total</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-center">Grade</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    <?php $__empty_1 = true; $__currentLoopData = $filteredScores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $score): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $total = $score->total_score ?? 0;
                            $grade = match(true) {
                                $total >= 90 => ['A+', 'text-emerald-600 bg-emerald-50 dark:bg-emerald-900/20 dark:text-emerald-400'],
                                $total >= 80 => ['A',  'text-emerald-600 bg-emerald-50 dark:bg-emerald-900/20 dark:text-emerald-400'],
                                $total >= 70 => ['B',  'text-blue-600 bg-blue-50 dark:bg-blue-900/20 dark:text-blue-400'],
                                $total >= 60 => ['C',  'text-amber-600 bg-amber-50 dark:bg-amber-900/20 dark:text-amber-400'],
                                $total >= 50 => ['D',  'text-orange-600 bg-orange-50 dark:bg-orange-900/20 dark:text-orange-400'],
                                default      => ['F',  'text-red-600 bg-red-50 dark:bg-red-900/20 dark:text-red-400'],
                            };
                            $scoreColor = $total < 50 ? 'text-red-500' : ($total >= 80 ? 'text-emerald-500' : 'text-slate-700 dark:text-slate-300');
                        ?>
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition-all">
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-semibold text-slate-900 dark:text-white"><?php echo e($score->subject->name ?? 'â€”'); ?></span>
                                    <span class="text-xs text-slate-400"><?php echo e($score->subject->subject_code ?? ''); ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center text-sm font-bold <?php echo e($scoreColor); ?>"><?php echo e($score->attendance ?? 'â€”'); ?></td>
                            <td class="px-6 py-4 text-center text-sm font-bold <?php echo e($scoreColor); ?>"><?php echo e($score->quiz ?? 'â€”'); ?></td>
                            <td class="px-6 py-4 text-center text-sm font-bold <?php echo e($scoreColor); ?>"><?php echo e($score->midterm ?? 'â€”'); ?></td>
                            <td class="px-6 py-4 text-center text-sm font-bold <?php echo e($scoreColor); ?>"><?php echo e($score->final_exam ?? 'â€”'); ?></td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm font-bold <?php echo e($scoreColor); ?>"><?php echo e(number_format($total, 1)); ?></span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold <?php echo e($grade[1]); ?>"><?php echo e($grade[0]); ?></span>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400 dark:text-slate-600 text-sm">
                                <span class="material-symbols-outlined text-4xl block mb-2 opacity-20">search_off</span>
                                No scores recorded for this semester.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($filteredScores->count() > 0): ?>
        <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-800/20 flex justify-between items-center">
            <p class="text-[11px] text-slate-400 font-medium">
                Showing <span class="font-bold text-slate-600 dark:text-slate-300"><?php echo e($filteredScores->count()); ?></span> subjects
            </p>
            <p class="text-sm font-bold <?php echo e($avgScore >= 50 ? 'text-emerald-500' : 'text-red-500'); ?>">
                Overall Average: <?php echo e(number_format($avgScore, 1)); ?>

            </p>
        </div>
        <?php endif; ?>
    </div>

    <div class="mt-6">
        <a href="<?php echo e(route('academicrecords.index')); ?>" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-primary transition-colors">
            <span class="material-symbols-outlined text-lg">arrow_back</span>
            Back to Academic Records
        </a>
    </div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal09ae9edb6a4f3743836239ca1a9c4719)): ?>
<?php $attributes = $__attributesOriginal09ae9edb6a4f3743836239ca1a9c4719; ?>
<?php unset($__attributesOriginal09ae9edb6a4f3743836239ca1a9c4719); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal09ae9edb6a4f3743836239ca1a9c4719)): ?>
<?php $component = $__componentOriginal09ae9edb6a4f3743836239ca1a9c4719; ?>
<?php unset($__componentOriginal09ae9edb6a4f3743836239ca1a9c4719); ?>
<?php endif; ?>
<?php /**PATH D:\University\University Year 2\Backend Development with Api\Laravel\Student-Management-System\resources\views/academicrecords/show.blade.php ENDPATH**/ ?>