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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['links' => ['Dashboard' => '/welcome', 'Attendances' => route('attendances.index')],'current' => 'History']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['links' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['Dashboard' => '/welcome', 'Attendances' => route('attendances.index')]),'current' => 'History']); ?>
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

    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">Attendance History</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-1">View archived attendance records from all semesters.</p>
        </div>
    </div>

    
    <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 flex flex-wrap gap-3 mb-6 items-center">
        
        
        <form action="<?php echo e(route('attendances.studenthistory')); ?>" method="GET" class="flex flex-wrap gap-3">

            
            <label class="flex items-center gap-2 px-4 py-2 border border-slate-200 dark:border-slate-800 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer">
                <select name="major" class="bg-transparent border-none outline-none focus:ring-0 focus:outline-none text-sm font-medium text-slate-700 dark:text-slate-300 cursor-pointer">
                    <option value="">All Majors</option>
                    <?php $__currentLoopData = $majors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $major): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($major); ?>" <?php echo e(request('major') == $major ? 'selected' : ''); ?>>
                            <?php echo e($major); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </label>

            
            <label class="flex items-center gap-2 px-4 py-2 border border-slate-200 dark:border-slate-800 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer">
                <select name="status" class="bg-transparent border-none outline-none focus:ring-0 focus:outline-none text-sm font-medium text-slate-700 dark:text-slate-300 cursor-pointer">
                    <option value="">All Results</option>
                    <?php $__currentLoopData = $attendanceresult; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($result); ?>" <?php echo e(request('status') == $result ? 'selected' : ''); ?>>
                            <?php echo e($result); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </label>

            
            <label class="flex items-center gap-2 px-4 py-2 border border-slate-200 dark:border-slate-800 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer">
                <span class="text-xs font-bold uppercase text-slate-400 mr-1">Term:</span>
                <select name="semester" class="bg-transparent border-none outline-none focus:ring-0 focus:outline-none text-sm font-medium text-slate-700 dark:text-slate-300 cursor-pointer">
                    <option value="">All History</option>
                    <?php $__currentLoopData = $semesters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $yearLabel => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <optgroup label="<?php echo e($yearLabel); ?>">
                            <?php $__currentLoopData = $group; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $sem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $formattedDate = \Carbon\Carbon::parse($sem)->format('M d, Y');
                                    $semLabel      = 'Semester ' . ($group->count() - $index) . ' (' . $formattedDate . ')';
                                ?>
                                <option value="<?php echo e($sem); ?>" <?php echo e(request('semester') == $sem ? 'selected' : ''); ?>>
                                    <?php echo e($semLabel); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </optgroup>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </label>
        </form>

        
        <?php if(request('semester')): ?>
            <form action="<?php echo e(route('attendances.deleteallstudenthistory', ['semester_end' => request('semester')])); ?>" method="POST" 
                  onsubmit="return confirm('Are you sure you want to delete all history for this semester?')"
                  class="ml-auto">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" 
                        class="flex items-center gap-2 px-4 py-2 rounded-lg bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 text-sm font-semibold hover:bg-red-100 dark:hover:bg-red-900/40 transition-colors border border-red-100 dark:border-red-900/30">
                    <span class="material-symbols-outlined text-sm">delete</span>
                    Delete Term
                </button>
            </form>
        <?php endif; ?>

    </div>

    
    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">

                
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Student Name</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Major</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Semester Start</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Semester End</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Present</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Absent</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Subject Failed</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Result</th>
                    </tr>
                </thead>

                
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">

                    <?php $__empty_1 = true; $__currentLoopData = $histories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">

                        
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="size-9 rounded-full bg-primary/10 flex items-center justify-center text-primary text-sm font-bold uppercase shrink-0">
                                    <?php echo e(strtoupper(substr($history->student->name, 0, 1))); ?><?php echo e(strtoupper(substr(strrchr($history->student->name, ' '), 1, 1))); ?>

                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-semibold text-slate-900 dark:text-white"><?php echo e($history->student->name); ?></span>
                                    <span class="text-xs text-slate-500 dark:text-slate-400"><?php echo e($history->student->email); ?></span>
                                </div>
                            </div>
                        </td>

                        
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-md bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 text-xs font-medium"><?php echo e($history->student->major); ?></span>
                        </td>

                        
                        <td class="px-6 py-4 text-sm text-slate-500">
                            <?php echo e($history->semester_start ? \Carbon\Carbon::parse($history->semester_start)->format('M d, Y') : '—'); ?>

                        </td>

                        
                        <td class="px-6 py-4 text-sm text-slate-500">
                            <?php echo e($history->semester_end ? \Carbon\Carbon::parse($history->semester_end)->format('M d, Y') : '—'); ?>

                        </td>

                        
                        <td class="px-6 py-4 text-sm font-medium text-emerald-600">
                            <?php echo e($history->present_days); ?>

                        </td>

                        
                        <td class="px-6 py-4 text-sm font-medium text-red-500">
                            <?php echo e($history->absent_days); ?>

                        </td>

                        
                        <td class="px-6 py-4">
                            <?php if($history->failed_subjects): ?>
                                <?php if($history->failed_subjects === 'General Absence Limit Reached'): ?>
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300">
                                        <span class="material-symbols-outlined text-xs">warning</span>
                                        General Absence Limit
                                    </span>
                                <?php else: ?>
                                    <div class="flex flex-wrap gap-1">
                                        <?php $__currentLoopData = explode(', ', $history->failed_subjects); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold uppercase bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300">
                                                <?php echo e(trim($subject)); ?>

                                            </span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="text-slate-400 text-xs">—</span>
                            <?php endif; ?>
                        </td>

                        
                        <td class="px-6 py-4">
                            <?php if($history->attendance_result === 'Passed'): ?>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">
                                    <span class="size-1.5 rounded-full bg-emerald-500"></span>Passed
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                    <span class="size-1.5 rounded-full bg-red-500"></span>Failed
                                </span>
                            <?php endif; ?>
                        </td>

                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-sm text-slate-400">No attendance history yet.</td>
                        </tr>
                    <?php endif; ?>

                </tbody>
            </table>
        </div>

        
        <div class="px-6 py-4">
            <?php echo e($histories->links()); ?>

        </div>

    </div>

    <script>
        document.querySelectorAll('select').forEach(select => {
            select.addEventListener('change', () => {
                select.closest('form').submit();
            });
        });
    </script>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal09ae9edb6a4f3743836239ca1a9c4719)): ?>
<?php $attributes = $__attributesOriginal09ae9edb6a4f3743836239ca1a9c4719; ?>
<?php unset($__attributesOriginal09ae9edb6a4f3743836239ca1a9c4719); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal09ae9edb6a4f3743836239ca1a9c4719)): ?>
<?php $component = $__componentOriginal09ae9edb6a4f3743836239ca1a9c4719; ?>
<?php unset($__componentOriginal09ae9edb6a4f3743836239ca1a9c4719); ?>
<?php endif; ?><?php /**PATH D:\Student-Management-System\resources\views/attendances/all-students-history.blade.php ENDPATH**/ ?>