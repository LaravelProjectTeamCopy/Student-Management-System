<?php if (isset($component)) { $__componentOriginal09ae9edb6a4f3743836239ca1a9c4719 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal09ae9edb6a4f3743836239ca1a9c4719 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.master','data' => ['title' => 'Student Directory']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.master'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Student Directory']); ?>

     <?php $__env->slot('breadcrumb', null, []); ?> 
        <?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['links' => ['Dashboard' => '/welcome'],'current' => 'Student Directory']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['links' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['Dashboard' => '/welcome']),'current' => 'Student Directory']); ?>
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

     <?php $__env->slot('search', null, []); ?> 
        <?php if (isset($component)) { $__componentOriginal9b33c063a2222f59546ad2a2a9a94bc6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9b33c063a2222f59546ad2a2a9a94bc6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.search','data' => ['action' => ''.e(route('students.index')).'','placeholder' => 'Search students...']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('search'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['action' => ''.e(route('students.index')).'','placeholder' => 'Search students...']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9b33c063a2222f59546ad2a2a9a94bc6)): ?>
<?php $attributes = $__attributesOriginal9b33c063a2222f59546ad2a2a9a94bc6; ?>
<?php unset($__attributesOriginal9b33c063a2222f59546ad2a2a9a94bc6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9b33c063a2222f59546ad2a2a9a94bc6)): ?>
<?php $component = $__componentOriginal9b33c063a2222f59546ad2a2a9a94bc6; ?>
<?php unset($__componentOriginal9b33c063a2222f59546ad2a2a9a94bc6); ?>
<?php endif; ?>
     <?php $__env->endSlot(); ?>

    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">Student Directory</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Manage and view all enrolled students across majors and years.</p>
        </div>
        <div class="flex items-center gap-3 ml-auto">
            <a href="<?php echo e(route('students.create')); ?>">
                <button class="border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 px-5 py-2.5 rounded-lg text-sm font-semibold flex items-center gap-2 hover:bg-white dark:hover:bg-slate-800 hover:border-primary/30 hover:shadow-md transition-all active:scale-95">
                    <span class="material-symbols-outlined text-lg">person_add</span>
                    <span>Add Student</span>
                </button>
            </a>
            <a href="<?php echo e(route('students.import')); ?>">
                <button class="border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 px-5 py-2.5 rounded-lg text-sm font-semibold flex items-center gap-2 hover:bg-white dark:hover:bg-slate-800 hover:border-primary/30 hover:shadow-md transition-all active:scale-95">
                    <span class="material-symbols-outlined text-lg">upload_file</span>
                    <span>Import</span>
                </button>
            </a>
            <button class="bg-slate-900 dark:bg-slate-800 text-white px-5 py-2.5 rounded-lg text-sm font-semibold flex items-center gap-2 hover:bg-slate-800 dark:hover:bg-slate-700 hover:shadow-lg transition-all active:scale-95">
                <span class="material-symbols-outlined text-lg">download</span>
                <span>Export</span>
            </button>
        </div>
    </div>

    
    <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 flex flex-wrap items-center gap-6 mb-6 shadow-sm">

        
        <div class="flex items-center gap-3">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Year:</span>
            <div class="flex gap-1.5">
                <a href="?year=&major=<?php echo e($currentMajor); ?>&status=<?php echo e($currentStatus); ?>"
                   class="px-3 py-1.5 rounded-lg border text-xs font-bold transition-all
                   <?php echo e($currentYear == '' 
                       ? 'bg-slate-900 dark:bg-white text-white dark:text-slate-900 border-slate-900 dark:border-white shadow-sm'
                       : 'bg-white dark:bg-slate-900 border-slate-100 dark:border-slate-800 text-slate-500 hover:border-slate-300'); ?>">
                    All Years
                </a>
                <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($year): ?> 
                    <a href="?year=<?php echo e($year); ?>&major=<?php echo e($currentMajor); ?>&status=<?php echo e($currentStatus); ?>"
                       class="px-3 py-1.5 rounded-lg border text-xs font-bold transition-all
                       <?php echo e($currentYear == $year
                           ? 'bg-slate-900 dark:bg-white text-white dark:text-slate-900 border-slate-900 dark:border-white shadow-sm'
                           : 'bg-white dark:bg-slate-900 border-slate-100 dark:border-slate-800 text-slate-500 hover:border-slate-300'); ?>">
                        <?php echo e($year); ?>

                    </a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <div class="h-8 w-px bg-slate-200 dark:bg-slate-800"></div>

        
        <div class="flex items-center gap-3">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Status:</span>
            <div class="flex gap-1.5">
                <a href="?status=&year=<?php echo e($currentYear); ?>&major=<?php echo e($currentMajor); ?>"
                   class="px-3 py-1.5 rounded-full border text-xs font-bold transition-all
                   <?php echo e($currentStatus == ''
                       ? 'bg-primary text-white border-primary'
                       : 'bg-white dark:bg-slate-900 border-slate-100 dark:border-slate-800 text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800'); ?>">
                    All
                </a>
                <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="?status=<?php echo e($status); ?>&year=<?php echo e($currentYear); ?>&major=<?php echo e($currentMajor); ?>"
                       class="px-3 py-1.5 rounded-full border text-xs font-bold transition-all
                       <?php echo e($currentStatus == $status
                           ? 'bg-primary text-white border-primary'
                           : 'bg-white dark:bg-slate-900 border-slate-100 dark:border-slate-800 text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800'); ?>">
                        <?php echo e($status); ?>

                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">

        
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-5 flex flex-col gap-3 hover:shadow-md transition-all">
            <div class="w-9 h-9 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center">
                <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-lg">groups</span>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400 mb-1">Total Students</p>
                <p class="text-3xl font-bold text-slate-900 dark:text-white leading-none"><?php echo e($totalStudents ?? 0); ?></p>
            </div>
            <p class="text-xs font-medium text-blue-600 dark:text-blue-400">All majors</p>
        </div>

        
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-5 flex flex-col gap-3 hover:shadow-md transition-all">
            <div class="w-9 h-9 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center">
                <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400 text-lg">verified</span>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400 mb-1">Active Students</p>
                <p class="text-3xl font-bold text-slate-900 dark:text-white leading-none"><?php echo e($activeStudents ?? 0); ?></p>
            </div>
            <div class="h-1 bg-emerald-100 dark:bg-emerald-900/30 rounded-full overflow-hidden">
                <?php $activePct = ($totalStudents ?? 0) > 0 ? round((($activeStudents ?? 0) / $totalStudents) * 100) : 0; ?>
                <div class="h-full bg-emerald-500 rounded-full transition-all duration-700" style="width: <?php echo e($activePct); ?>%"></div>
            </div>
        </div>

        
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-5 flex flex-col gap-3 hover:shadow-md transition-all">
            <div class="w-9 h-9 rounded-lg bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center">
                <span class="material-symbols-outlined text-amber-500 dark:text-amber-400 text-lg">person_add</span>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400 mb-1">New This Month</p>
                <p class="text-3xl font-bold text-slate-900 dark:text-white leading-none"><?php echo e($newThisMonth ?? 0); ?></p>
            </div>
            <p class="text-xs font-medium text-amber-500 dark:text-amber-400">Recently enrolled</p>
        </div>

        
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-5 flex flex-col gap-3 hover:shadow-md transition-all">
            <div class="w-9 h-9 rounded-lg bg-violet-50 dark:bg-violet-900/20 flex items-center justify-center">
                <span class="material-symbols-outlined text-violet-500 dark:text-violet-400 text-lg">school</span>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400 mb-1">Graduated</p>
                <p class="text-3xl font-bold text-slate-900 dark:text-white leading-none"><?php echo e($graduated ?? 0); ?></p>
            </div>
            <div class="h-1 bg-violet-100 dark:bg-violet-900/30 rounded-full overflow-hidden">
                <?php $gradPct = ($totalStudents ?? 0) > 0 ? round((($graduated ?? 0) / $totalStudents) * 100) : 0; ?>
                <div class="h-full bg-violet-500 rounded-full transition-all duration-700" style="width: <?php echo e($gradPct); ?>%"></div>
            </div>
        </div>

    </div>

    
    <div class="border-b border-slate-200 dark:border-slate-800 mb-6 overflow-x-auto">
        <div class="flex gap-0 min-w-max">
            <?php $__currentLoopData = $majors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="?major=<?php echo e($m); ?>&year=<?php echo e($currentYear); ?>&status=<?php echo e($currentStatus); ?>"
                   class="px-5 py-3 text-sm font-bold border-b-2 transition-colors whitespace-nowrap
                   <?php echo e($currentMajor == $m
                       ? 'border-primary text-primary'
                       : 'border-transparent text-slate-400 hover:text-slate-600 dark:hover:text-slate-300'); ?>">
                    <?php echo e(strtoupper($m)); ?>

                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    
    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Student</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Student ID</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Major</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Year</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $statusClasses = [
                                'Active'    => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300',
                                'Inactive'  => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                'Graduated' => 'bg-violet-100 text-violet-800 dark:bg-violet-900/30 dark:text-violet-300',
                            ];
                            $dotClasses = [
                                'Active'    => 'bg-emerald-500',
                                'Inactive'  => 'bg-red-500',
                                'Graduated' => 'bg-violet-500',
                            ];
                            $statusLabel = $student->status ?? 'Active';
                        ?>
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition-all group">

                            
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="size-9 rounded-full bg-primary/10 flex items-center justify-center text-primary text-sm font-bold uppercase shrink-0 transition-transform group-hover:scale-110">
                                        <?php echo e(strtoupper(substr($student->name, 0, 1))); ?><?php echo e(strtoupper(substr(strrchr($student->name, ' '), 1, 1))); ?>

                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-semibold text-slate-900 dark:text-white group-hover:text-primary transition-colors">
                                            <?php echo e($student->name); ?>

                                        </span>
                                        <span class="text-xs text-slate-500 dark:text-slate-400"><?php echo e($student->email); ?></span>
                                    </div>
                                </div>
                            </td>

                            
                            <td class="px-6 py-4 text-sm font-medium text-slate-600 dark:text-slate-400">
                                <?php echo e($student->id); ?>

                            </td>

                            
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded-md bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 text-[10px] font-bold uppercase">
                                    <?php echo e($student->major); ?>

                                </span>
                            </td>

                            
                            <td class="px-6 py-4 text-sm font-medium text-slate-600 dark:text-slate-400">
                                <?php echo e($student->academic_year); ?>

                            </td>

                            
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase <?php echo e($statusClasses[$statusLabel] ?? $statusClasses['Active']); ?>">
                                    <span class="size-1.5 rounded-full <?php echo e($dotClasses[$statusLabel] ?? $dotClasses['Active']); ?>"></span>
                                    <?php echo e($statusLabel); ?>

                                </span>
                            </td>

                            
                            <td class="px-6 py-4 text-right">
                                <a href="<?php echo e(route('students.show', $student->id)); ?>"
                                   class="inline-flex items-center gap-1 text-primary font-bold text-xs hover:gap-2 transition-all active:scale-95 group/link">
                                    VIEW PROFILE
                                    <span class="material-symbols-outlined text-sm transition-transform group-hover/link:translate-x-0.5">arrow_forward</span>
                                </a>
                            </td>

                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400 dark:text-slate-600 text-sm">
                                <span class="material-symbols-outlined text-4xl block mb-2 opacity-20">search_off</span>
                                No students found for the selected filters.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/30 flex justify-between items-center flex-wrap gap-3">
            <p class="text-[11px] text-slate-400 font-medium">
                Showing students in
                <span class="font-bold text-slate-600 dark:text-slate-300"><?php echo e($currentMajor ?: 'All Majors'); ?></span>
                ·
                <span class="font-bold text-slate-600 dark:text-slate-300"><?php echo e($currentStatus ?: 'All Statuses'); ?></span>
                ·
                <span class="font-bold text-slate-600 dark:text-slate-300"><?php echo e($currentYear); ?></span>
            </p>
            <div><?php echo e($students->links()); ?></div>
        </div>
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
<?php endif; ?><?php /**PATH D:\University\University Year 2\Backend Development with Api\Laravel\Student-Management-System\resources\views/students/index.blade.php ENDPATH**/ ?>