<?php if (isset($component)) { $__componentOriginal09ae9edb6a4f3743836239ca1a9c4719 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal09ae9edb6a4f3743836239ca1a9c4719 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.master','data' => ['title' => 'Attendance History']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.master'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Attendance History']); ?>
    
     <?php $__env->slot('breadcrumb', null, []); ?> 
        <?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['links' => ['Dashboard' => '/welcome', 'Attendances' => route('attendances.index') ,'History' => route('attendances.history', $student->id)],'current' => ''.e($student->name).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['links' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['Dashboard' => '/welcome', 'Attendances' => route('attendances.index') ,'History' => route('attendances.history', $student->id)]),'current' => ''.e($student->name).'']); ?>
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
            <div class="h-16 w-16 rounded-full ring-4 ring-slate-50 dark:ring-slate-800 bg-primary/10 flex items-center justify-center text-primary text-xl font-bold uppercase">
                <?php echo e(strtoupper(substr($student->name, 0, 1))); ?><?php echo e(strtoupper(substr(strrchr($student->name, ' '), 1, 1))); ?>

            </div>
            <div>
                <h2 class="text-2xl font-bold"><?php echo e($student->name); ?></h2>
                <div class="mt-1 flex flex-wrap gap-x-4 gap-y-1">
                    <span class="text-sm text-slate-500">#<?php echo e($student->id); ?></span>
                    <span class="text-sm text-slate-500"><?php echo e($student->major); ?></span>
                </div>
            </div>
        </div>
        <a href="<?php echo e(route('attendances.show', $student->id)); ?>">
            <button class="flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 transition-colors">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Back to Attendance
            </button>
        </a>
    </div>

    
    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden">

        <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">history</span>
            <h3 class="text-lg font-bold">Full Attendance History</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Days</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Present</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Absent</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Note</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                            <td class="px-6 py-4 text-sm text-slate-500"><?php echo e($loop->iteration); ?></td>
                            <td class="px-6 py-4 text-sm font-medium text-slate-700 dark:text-slate-300"><?php echo e($log->total_days); ?></td>
                            <td class="px-6 py-4 text-sm font-medium text-emerald-600"><?php echo e($log->present_days); ?></td>
                            <td class="px-6 py-4 text-sm font-medium text-red-500"><?php echo e($log->absent_days); ?></td>
                            <td class="px-6 py-4">
                                <?php if($log->status === 'Good'): ?>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                        <span class="size-1.5 rounded-full bg-emerald-500"></span>Good
                                    </span>
                                <?php elseif($log->status === 'At Risk'): ?>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                                        <span class="size-1.5 rounded-full bg-amber-500"></span>At Risk
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                        <span class="size-1.5 rounded-full bg-red-500"></span>Critical
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500">
                                <?php echo e($log->log_date ? $log->log_date->format('M d, Y') : '—'); ?>

                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500"><?php echo e($log->note ?? '—'); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-sm text-slate-400">No attendance history yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <div class="px-6 py-4">
            <?php echo e($logs->links()); ?>

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
<?php endif; ?><?php /**PATH D:\Student-Management-System\resources\views/attendances/history.blade.php ENDPATH**/ ?>