<?php if (isset($component)) { $__componentOriginal09ae9edb6a4f3743836239ca1a9c4719 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal09ae9edb6a4f3743836239ca1a9c4719 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.master','data' => ['title' => 'Create New Subject']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.master'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Create New Subject']); ?>

     <?php $__env->slot('breadcrumb', null, []); ?> 
        <?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['links' => ['Dashboard' => '/welcome', 'Academic Records' => route('academicrecords.index')],'current' => 'New Subject']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['links' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['Dashboard' => '/welcome', 'Academic Records' => route('academicrecords.index')]),'current' => 'New Subject']); ?>
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
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Create New Subject</h2>
                <p class="text-sm text-slate-500 mt-1">Add a new subject "Bucket" to the system so scores can be imported against it.</p>
            </div>

            
            <form id="subject-form" class="p-8 space-y-10" action="<?php echo e(route('academicrecords.subjectstore')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">

                    
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500 block">Subject Name</label>
                        <input type="text" name="name" placeholder="e.g. Advanced Mathematics" required
                               class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" />
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500 block">Subject Code (ID)</label>
                        <input id="subject_code" type="text" name="subject_code" placeholder="e.g. MATH-101" required
                               class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm font-mono font-bold focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all uppercase" />
                        <p class="text-[10px] text-slate-400 mt-1">This MUST match the code used in your CSV imports.</p>
                        <?php $__errorArgs = ['subject_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500 block">Major / Department</label>
                        <select name="major" class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all cursor-pointer">
                            <?php $__currentLoopData = $majors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $major): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($major); ?>"><?php echo e($major); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500 block">Academic Year</label>
                        <select name="academic_year" class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all cursor-pointer">
                            <option value="2025/2026">2025/2026</option>
                            <option value="2024/2025">2024/2025</option>
                        </select>
                    </div>

                    
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500 block">Semester</label>
                        <div class="flex gap-4 mt-2">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="semester" value="Semester 1" checked class="text-primary focus:ring-primary">
                                <span class="text-sm text-slate-600 dark:text-slate-400">Semester 1</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="semester" value="Semester 2" class="text-primary focus:ring-primary">
                                <span class="text-sm text-slate-600 dark:text-slate-400">Semester 2</span>
                            </label>
                        </div>
                    </div>

                </div>

                
                <div class="pt-8 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-4">
                    <a href="<?php echo e(route('academicrecords.index')); ?>" class="px-6 py-2.5 rounded-lg text-sm font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-8 py-2.5 bg-primary text-white rounded-lg text-sm font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all active:scale-95 flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">add_circle</span>
                        Create Subject
                    </button>
                </div>

            </form>
        </div>

        
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="p-5 bg-blue-50/50 dark:bg-blue-900/10 rounded-xl border border-blue-100 dark:border-blue-900/30">
                <div class="flex items-center gap-3 mb-2">
                    <span class="material-symbols-outlined text-blue-600">link</span>
                    <h4 class="text-xs font-bold uppercase tracking-widest text-slate-900 dark:text-white">The Bridge Logic</h4>
                </div>
                <p class="text-xs text-slate-500 leading-relaxed">The <strong>Subject Code</strong> is the unique bridge between your CSV files and the database. Ensure teachers use this exact code in their grade sheets.</p>
            </div>
            <div class="p-5 bg-amber-50/50 dark:bg-amber-900/10 rounded-xl border border-amber-100 dark:border-amber-900/30">
                <div class="flex items-center gap-3 mb-2">
                    <span class="material-symbols-outlined text-amber-600">inventory_2</span>
                    <h4 class="text-xs font-bold uppercase tracking-widest text-slate-900 dark:text-white">Data Readiness</h4>
                </div>
                <p class="text-xs text-slate-500 leading-relaxed">Once created, this subject will immediately appear in your Academic Records dashboard and become available for bulk score imports.</p>
            </div>
        </div>

    </div>

    <script>
        // Automatic Code Formatter (Enterprise Standard: No spaces, all caps)
        const codeInput = document.getElementById('subject_code');
        
        codeInput.addEventListener('input', function(e) {
            let value = e.target.value.toUpperCase();
            e.target.value = value.replace(/\s+/g, '-'); // Replace spaces with dashes
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
<?php endif; ?><?php /**PATH D:\University\University Year 2\Backend Development with Api\Laravel\Student-Management-System\resources\views/academicrecords/subject.blade.php ENDPATH**/ ?>