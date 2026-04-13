<?php if (isset($component)) { $__componentOriginal09ae9edb6a4f3743836239ca1a9c4719 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal09ae9edb6a4f3743836239ca1a9c4719 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.master','data' => ['title' => 'Student Attendance']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.master'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Student Attendance']); ?>
    
     <?php $__env->slot('breadcrumb', null, []); ?> 
        <?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['links' => ['Dashboard' => '/welcome', 'Attendances' => route('attendances.index')],'current' => ''.e($student->name).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['links' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['Dashboard' => '/welcome', 'Attendances' => route('attendances.index')]),'current' => ''.e($student->name).'']); ?>
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
    
    
    <div class="mb-8 flex flex-col items-start justify-between gap-6 rounded-xl bg-white p-6 shadow-sm dark:bg-slate-900 lg:flex-row lg:items-center">
        <div class="flex items-center gap-6">
            <div class="h-24 w-24 rounded-full ring-4 ring-slate-50 dark:ring-slate-800 bg-primary/10 flex items-center justify-center text-primary text-2xl font-bold uppercase">
                <?php echo e(strtoupper(substr($student->name, 0, 1))); ?><?php echo e(strtoupper(substr(strrchr($student->name, ' '), 1, 1))); ?>

            </div>
            <div>
                <h2 class="text-2xl font-bold"><?php echo e($student->name); ?></h2>
                <div class="mt-1 flex flex-wrap gap-x-4 gap-y-1">
                    <span class="text-sm text-slate-500"><?php echo e($student->id); ?></span>
                    <span class="flex items-center gap-1 text-sm font-medium text-emerald-600">
                        <span class="size-2 rounded-full bg-emerald-600"></span>
                        Active
                    </span>
                </div>
            </div>
        </div>
        <div class="flex w-full gap-3 lg:w-auto">
            <button class="flex flex-1 items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 lg:flex-none transition-colors">
                <span class="material-symbols-outlined text-sm">print</span>
                Print Report
            </button>
            <a href="<?php echo e(route('attendances.edit', $attendance->student_id)); ?>">
                <button class="flex flex-1 items-center justify-center gap-2 rounded-lg bg-slate-100 px-4 py-2 text-sm font-bold text-slate-900 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-100 lg:flex-none transition-colors">
                    <span class="material-symbols-outlined text-sm">edit</span>
                    Edit Record
                </button>
            </a>
            <button class="flex flex-1 items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-bold text-white hover:bg-primary/90 lg:flex-none transition-colors">
                <span class="material-symbols-outlined text-sm">edit_calendar</span>
                Mark Attendance
            </button>
        </div>
    </div>

    
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

        
        <div class="lg:col-span-2 flex flex-col gap-8">

            
            <section class="rounded-xl bg-white p-6 shadow-sm dark:bg-slate-900">
                <div class="mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">calendar_month</span>
                    <h3 class="text-lg font-bold">Attendance Overview</h3>
                </div>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div class="rounded-lg bg-slate-50 p-4 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Days</p>
                        <p class="mt-1 text-2xl font-bold text-slate-900 dark:text-white"><?php echo e($attendance->total_days); ?></p>
                    </div>
                    <div class="rounded-lg bg-slate-50 p-4 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Present</p>
                        <p class="mt-1 text-2xl font-bold text-emerald-600"><?php echo e($attendance->present_days); ?></p>
                    </div>
                    <div class="rounded-lg bg-slate-50 p-4 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Absent</p>
                        <p class="mt-1 text-2xl font-bold text-red-500"><?php echo e($attendance->absent_days); ?></p>
                    </div>
                </div>

                
                <?php $pct = $attendance->total_days > 0 ? round(($attendance->present_days / $attendance->total_days) * 100) : 0; ?>
                <div class="mt-6">
                    <div class="flex justify-between text-xs font-medium text-slate-500 mb-1.5">
                        <span>Attendance Rate</span>
                        <span><?php echo e($pct); ?>% Present</span>
                    </div>
                    <div class="w-full h-2.5 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                        <div class="h-full rounded-full <?php echo e($pct >= 75 ? 'bg-emerald-500' : ($pct >= 50 ? 'bg-amber-500' : 'bg-red-500')); ?>" style="width: <?php echo e($pct); ?>%"></div>
                    </div>
                </div>
            </section>

            
            <section class="rounded-xl bg-white p-6 shadow-sm dark:bg-slate-900">
                <div class="mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">info</span>
                    <h3 class="text-lg font-bold">Attendance Details</h3>
                </div>
                <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Status</p>
                        <?php if($pct >= 75): ?>
                            <span class="mt-1 inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">
                                <span class="size-1.5 rounded-full bg-emerald-500"></span>Good
                            </span>
                        <?php elseif($pct >= 50): ?>
                            <span class="mt-1 inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300">
                                <span class="size-1.5 rounded-full bg-amber-500"></span>At Risk
                            </span>
                        <?php else: ?>
                            <span class="mt-1 inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                <span class="size-1.5 rounded-full bg-red-500"></span>Critical
                            </span>
                        <?php endif; ?>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Major</p>
                        <p class="mt-1 font-medium text-slate-900 dark:text-slate-100"><?php echo e($student->major); ?></p>
                    </div>
                    <div>
                        <div class="mt-4">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Attendance Result</p>
                        
                        <?php if($attendance->deadline && now()->gt($attendance->deadline)): ?>
                            <?php if($result === 'Pass'): ?>
                                
                                <div class="flex flex-col gap-2">
                                    <span class="inline-flex w-fit items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                                        <span class="size-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                        Passed
                                    </span>
                                    <p class="text-sm text-slate-600 dark:text-slate-400"><?php echo e($message); ?></p>
                                </div>
                            <?php else: ?>
                                
                                <div class="flex flex-col gap-2">
                                    <span class="inline-flex w-fit items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800">
                                        <span class="size-1.5 rounded-full bg-red-500"></span>
                                        Failed
                                    </span>
                                    <p class="text-sm font-medium text-red-600 dark:text-red-400 leading-tight">
                                        <?php echo e($message); ?>

                                    </p>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            
                            <div class="flex items-center gap-2 text-slate-400">
                                <span class="material-symbols-outlined text-lg leading-none">hourglass_empty</span>
                                <span class="text-sm italic font-medium">Pending deadline (<?php echo e(\Carbon\Carbon::parse($attendance->deadline)->format('M d')); ?>)</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    </div>
                </div>
            </section>

        </div>

        
        <div class="lg:col-span-1">
            <section class="h-full rounded-xl bg-white p-6 shadow-sm dark:bg-slate-900">
                <div class="mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">history</span>
                    <h3 class="text-lg font-bold">Attendance Log</h3>
                </div>

                <div class="flex flex-col gap-6">
                    <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="relative flex gap-4 pb-2">
                            <div class="absolute left-4 top-8 h-full w-px bg-slate-200 dark:bg-slate-800"></div>
                            <div class="relative z-10 flex size-12 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
                                <span class="material-symbols-outlined text-2xl">calendar_month</span>
                            </div>
                            <div class="flex flex-col">
                                <p class="text-sm font-semibold">Attendance Updated</p>
                                <p class="text-xs text-slate-500">Present: <?php echo e($log->present_days); ?> / <?php echo e($log->total_days); ?> days</p>
                                <p class="text-xs text-slate-500">Absent: <?php echo e($log->absent_days); ?> days</p>
                                <p class="text-xs text-slate-500">Status: <?php echo e($log->status); ?></p>
                                <p class="mt-1 text-xs text-slate-400"><?php echo e($log->log_date ? $log->log_date->format('M d, Y') : '—'); ?></p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-sm text-slate-400">No attendance history yet.</p>
                    <?php endif; ?>
                </div>
                <a href="<?php echo e(route('attendances.history', $student->id)); ?>"><button class="mt-8 w-full rounded-lg border border-slate-200 dark:border-slate-800 py-2 text-sm font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                    See History
                </a></button>
            </section>
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
<?php endif; ?><?php /**PATH D:\University\University Year 2\Backend Development with Api\Laravel\Student-Management-System\resources\views/attendances/show.blade.php ENDPATH**/ ?>