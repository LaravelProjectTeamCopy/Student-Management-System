<?php if (isset($component)) { $__componentOriginal09ae9edb6a4f3743836239ca1a9c4719 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal09ae9edb6a4f3743836239ca1a9c4719 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.master','data' => ['title' => 'Weekly Attendance Update']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.master'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Weekly Attendance Update']); ?>

     <?php $__env->slot('breadcrumb', null, []); ?> 
        <?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['links' => ['Dashboard' => '/welcome', 'Attendances' => route('attendances.index')],'current' => 'Weekly Update: '.e($student->name).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['links' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['Dashboard' => '/welcome', 'Attendances' => route('attendances.index')]),'current' => 'Weekly Update: '.e($student->name).'']); ?>
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

    <div class="max-w-4xl mx-auto">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
            <div>
                <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">Attendance Management</h2>
                <p class="text-slate-500 mt-1">System is currently open for: <span class="font-bold text-primary"><?php echo e($attendance->semester_start); ?></span></p>
            </div>
            
            <?php if($lastUpdate): ?>
                <div class="flex items-center gap-2 px-3 py-1.5 bg-slate-100 dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    <span class="text-xs font-medium text-slate-600 dark:text-slate-400">
                        Last saved: <?php echo e($lastUpdate->created_at->diffForHumans()); ?>

                    </span>
                </div>
            <?php endif; ?>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xl overflow-hidden">
            
            
            <div class="p-6 bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800 flex items-center gap-4">
                <div class="h-12 w-12 rounded-full bg-primary text-white flex items-center justify-center font-bold">
                    <?php echo e(substr($student->name, 0, 1)); ?>

                </div>
                <div>
                    <h3 class="font-bold text-slate-900 dark:text-white"><?php echo e($student->name); ?></h3>
                    <p class="text-xs text-slate-500 uppercase tracking-widest font-semibold">Reg ID: <?php echo e($student->id); ?></p>
                </div>
            </div>

            <form action="<?php echo e(route('attendances.update', $attendance->student_id)); ?>" method="POST" class="p-8">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                
                <div class="overflow-hidden rounded-xl border border-slate-200 dark:border-slate-700">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50 dark:bg-slate-800">
                            <tr>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Work Day</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            <?php $__currentLoopData = $weekDays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-slate-700 dark:text-slate-200"><?php echo e($day['label']); ?></span>
                                        <span class="text-xs text-slate-400"><?php echo e($day['date']); ?></span>
                                    </div>
                                    <input type="hidden" name="days[<?php echo e($i); ?>][date]" value="<?php echo e($day['date']); ?>">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-8">
                                        <label class="inline-flex items-center cursor-pointer group">
                                            <input type="radio" name="days[<?php echo e($i); ?>][status]" value="present" 
                                                   <?php echo e($day['status'] === 'present' ? 'checked' : ''); ?>

                                                   class="hidden peer" required>
                                            <div class="px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-700 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 dark:peer-checked:bg-emerald-500/10 peer-checked:text-emerald-600 text-slate-400 transition-all font-bold text-sm">
                                                Present
                                            </div>
                                        </label>

                                        <label class="inline-flex items-center cursor-pointer group">
                                            <input type="radio" name="days[<?php echo e($i); ?>][status]" value="absent"
                                                   <?php echo e($day['status'] === 'absent' ? 'checked' : ''); ?>

                                                   class="hidden peer" required>
                                            <div class="px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-700 peer-checked:border-red-500 peer-checked:bg-red-50 dark:peer-checked:bg-red-500/10 peer-checked:text-red-600 text-slate-400 transition-all font-bold text-sm">
                                                Absent
                                            </div>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                
                <div class="mt-8 flex items-center justify-between">
                    <p class="text-sm text-slate-400 italic">
                        * Submission will update the cumulative record for this semester.
                    </p>
                    <div class="flex gap-3">
                        <a href="<?php echo e(route('attendances.index')); ?>" class="px-6 py-2.5 text-sm font-bold text-slate-500 hover:text-slate-700">Cancel</a>
                        <button type="submit" class="bg-slate-900 dark:bg-primary px-10 py-2.5 rounded-xl text-white font-bold shadow-lg hover:opacity-90 transition-all">
                            Finalize Week
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php if($errors->any()): ?>
        <div class = "fixed top-4 left-1/2 transform -translate-x-1/2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-lg z-50" role="alert">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal09ae9edb6a4f3743836239ca1a9c4719)): ?>
<?php $attributes = $__attributesOriginal09ae9edb6a4f3743836239ca1a9c4719; ?>
<?php unset($__attributesOriginal09ae9edb6a4f3743836239ca1a9c4719); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal09ae9edb6a4f3743836239ca1a9c4719)): ?>
<?php $component = $__componentOriginal09ae9edb6a4f3743836239ca1a9c4719; ?>
<?php unset($__componentOriginal09ae9edb6a4f3743836239ca1a9c4719); ?>
<?php endif; ?><?php /**PATH D:\xampp\htdocs\proweb\Student-Management-System\resources\views/attendances/edit.blade.php ENDPATH**/ ?>