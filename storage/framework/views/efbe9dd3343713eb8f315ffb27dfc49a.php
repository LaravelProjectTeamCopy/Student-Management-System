<?php if (isset($component)) { $__componentOriginal09ae9edb6a4f3743836239ca1a9c4719 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal09ae9edb6a4f3743836239ca1a9c4719 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.master','data' => ['title' => 'Set Attendance Deadline']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.master'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Set Attendance Deadline']); ?>

     <?php $__env->slot('breadcrumb', null, []); ?> 
        <?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['links' => ['Dashboard' => '/welcome', 'Attendance' => route('attendances.index')],'current' => 'Set Attendance Deadline']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['links' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['Dashboard' => '/welcome', 'Attendance' => route('attendances.index')]),'current' => 'Set Attendance Deadline']); ?>
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

        
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">

            
            <div class="p-8 border-b border-slate-100 dark:border-slate-800">
                <h2 class="text-2xl font-bold">Set Attendance Deadline</h2>
                <p class="text-sm text-slate-500 mt-1">Set a deadline for student attendance submission per semester.</p>
            </div>

            <form id="attendance-form" class="p-8 space-y-10" action="<?php echo e(route('attendances.duration')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">

                    
                    

                    
                    

                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500 block">Semester Start Date</label>
                        <input id="semester_start" type="date" name="semester_start"
                               class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" />
                        <?php $__errorArgs = ['semester_start'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500 block">Semester Duration</label>
                        <select id="semester_duration" name="semester_duration"
                                class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all cursor-pointer">
                            <option value="15">15 Weeks</option>
                            <option value="17">17 Weeks</option>
                            <option value="18">18 Weeks</option>
                        </select>
                        <p id="duration_hint" class="text-[10px] font-medium text-primary mt-1 italic"></p>
                        <?php $__errorArgs = ['semester_duration'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500 block">Apply To</label>
                        <select name="apply_to"
                                class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all cursor-pointer">
                            <option value="all">All Students</option>
                        </select>
                        <?php $__errorArgs = ['apply_to'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                </div>

                
                <div class="pt-8 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-4">
                    <a href="<?php echo e(route('attendances.index')); ?>" class="px-6 py-2.5 rounded-lg text-sm font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-8 py-2.5 bg-primary text-white rounded-lg text-sm font-bold shadow-sm hover:bg-primary/90 transition-all active:scale-95">
                        Set Deadline
                    </button>
                </div>

            </form>
        </div>

        
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-5 bg-slate-50 dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">
                <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center text-primary mb-3">
                    <span class="material-symbols-outlined text-lg">info</span>
                </div>
                <h4 class="text-xs font-bold uppercase tracking-widest text-slate-900 dark:text-white">Auto Attendance Check</h4>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">Students who have not submitted attendance by the deadline will automatically be flagged.</p>
            </div>
            <div class="p-5 bg-slate-50 dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">
                <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600 mb-3">
                    <span class="material-symbols-outlined text-lg">calendar_today</span>
                </div>
                <h4 class="text-xs font-bold uppercase tracking-widest text-slate-900 dark:text-white">Daily Update</h4>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">The system checks attendance submission daily to track pending submissions automatically.</p>
            </div>
            <div class="p-5 bg-slate-50 dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-600 mb-3">
                    <span class="material-symbols-outlined text-lg">verified</span>
                </div>
                <h4 class="text-xs font-bold uppercase tracking-widest text-slate-900 dark:text-white">Submitted Students Safe</h4>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">Students who have already submitted attendance will not be affected by the deadline update.</p>
            </div>
        </div>

    </div>

    
    <div id="reset-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-700 w-full max-w-md mx-4 p-6">

            <div class="flex items-center justify-center w-14 h-14 rounded-full bg-red-100 dark:bg-red-900/30 mx-auto mb-4">
                <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
            </div>

            <h3 class="text-lg font-bold text-slate-900 dark:text-white text-center">Set Attendance Deadline?</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400 text-center mt-2">
                This will set a new attendance deadline for <span class="font-semibold text-red-500">all students</span>
                and reset all attendance counts to <span class="font-semibold">zero</span>. This cannot be undone.
            </p>

            
            <div class="mt-4 p-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-500 space-y-1">
                <div class="flex justify-between">
                    <span class="font-semibold">Semester Start</span>
                    <span id="summary-start">—</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-semibold">Duration</span>
                    <span id="summary-duration">—</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-semibold">Attendance Deadline</span>
                    <span id="summary-deadline" class="text-red-500 font-bold">—</span>
                </div>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="button" onclick="closeModal()"
                        class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-sm font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                    Cancel
                </button>
                <button type="button" onclick="confirmSubmit()"
                        class="flex-1 px-4 py-2.5 rounded-xl bg-red-500 text-white text-sm font-bold hover:bg-red-600 transition shadow-lg">
                    Yes, Set Deadline
                </button>
            </div>
        </div>
    </div>

    <script>
        const form                  = document.getElementById('attendance-form');
        const semesterStartInput    = document.getElementById('semester_start');
        const semesterDurationInput = document.getElementById('semester_duration');
        const hint                  = document.getElementById('duration_hint');

        function calculateDeadline() {
            const durationWeeks = parseInt(semesterDurationInput.value);
            if (semesterStartInput.value && durationWeeks) {
                hint.innerText = `➔ This semester will cover ${durationWeeks * 7} days of attendance.`;
            } else {
                hint.innerText = '';
            }
        }

        function getDeadlineDate() {
            const start = semesterStartInput.value;
            const weeks = parseInt(semesterDurationInput.value);
            if (!start || !weeks) return '—';
            const date = new Date(start);
            date.setDate(date.getDate() + weeks * 7);
            return date.toISOString().split('T')[0];
        }

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            document.getElementById('summary-start').textContent    = semesterStartInput.value || '—';
            document.getElementById('summary-duration').textContent = semesterDurationInput.value ? semesterDurationInput.value + ' Weeks' : '—';
            document.getElementById('summary-deadline').textContent = getDeadlineDate();
            document.getElementById('reset-modal').classList.remove('hidden');
        });

        function closeModal() {
            document.getElementById('reset-modal').classList.add('hidden');
        }

        function confirmSubmit() {
            closeModal();
            form.submit();
        }

        semesterStartInput.addEventListener('change', calculateDeadline);
        semesterDurationInput.addEventListener('change', calculateDeadline);
        window.addEventListener('load', calculateDeadline);
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
<?php endif; ?><?php /**PATH D:\Student-Management-System\resources\views/attendances/duration.blade.php ENDPATH**/ ?>