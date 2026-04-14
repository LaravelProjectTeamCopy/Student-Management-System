<?php if (isset($component)) { $__componentOriginal09ae9edb6a4f3743836239ca1a9c4719 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal09ae9edb6a4f3743836239ca1a9c4719 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.master','data' => ['title' => 'Edit Student']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.master'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Edit Student']); ?>

     <?php $__env->slot('breadcrumb', null, []); ?> 
        <?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['links' => ['Dashboard' => '/dashboard', 'Students' => route('students.index')],'current' => 'Edit '.e($student->name).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['links' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['Dashboard' => '/dashboard', 'Students' => route('students.index')]),'current' => 'Edit '.e($student->name).'']); ?>
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
                <h2 class="text-2xl font-bold">Edit Student</h2>
                <p class="text-sm text-slate-500 mt-1">Update the student profile information below.</p>
            </div>

            <form class="p-8 space-y-10" action="<?php echo e(route('students.update', $student->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">

                    
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500 block">Full Name</label>
                        <input class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" type="text" name="name" placeholder="e.g. Alexander Pierce" value="<?php echo e(old('name', $student->name)); ?>" />
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
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500 block">Email Address</label>
                        <input class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" type="email" name="email" placeholder="alex.p@university.edu" value="<?php echo e(old('email', $student->email)); ?>" />
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500 block">Date of Birth</label>
                        <input class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" type="date" name="date_of_birth" value="<?php echo e(old('date_of_birth', $student->date_of_birth)); ?>" />
                        <?php $__errorArgs = ['date_of_birth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500 block">Gender</label>
                        <input class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" type="text" name="gender" placeholder="e.g. Male" value="<?php echo e(old('gender', $student->gender)); ?>" />
                        <?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500 block">Address</label>
                        <input class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" type="text" name="address" placeholder="e.g. 123 Main St" value="<?php echo e(old('address', $student->address)); ?>" />
                        <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500 block">Major</label>
                        <select name="major" class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all cursor-pointer">
                            <option value="" disabled>Select Major</option>
                            <option value="Computer Science"        <?php echo e(old('major', $student->major) == 'Computer Science'        ? 'selected' : ''); ?>>Computer Science</option>
                            <option value="Business Administration" <?php echo e(old('major', $student->major) == 'Business Administration' ? 'selected' : ''); ?>>Business Administration</option>
                            <option value="Nursing"                 <?php echo e(old('major', $student->major) == 'Nursing'                 ? 'selected' : ''); ?>>Nursing</option>
                            <option value="Engineering"             <?php echo e(old('major', $student->major) == 'Engineering'             ? 'selected' : ''); ?>>Engineering</option>
                            <option value="Psychology"              <?php echo e(old('major', $student->major) == 'Psychology'              ? 'selected' : ''); ?>>Psychology</option>
                            <option value="Medicine"                <?php echo e(old('major', $student->major) == 'Medicine'                ? 'selected' : ''); ?>>Medicine</option>
                            <option value="Architecture"            <?php echo e(old('major', $student->major) == 'Architecture'            ? 'selected' : ''); ?>>Architecture</option>
                        </select>
                        <?php $__errorArgs = ['major'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500 block">Academic Year</label>
                        <input class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" type="text" name="academic_year" placeholder="e.g. 2023-2024" value="<?php echo e(old('academic_year', $student->academic_year)); ?>" />
                        <?php $__errorArgs = ['academic_year'];
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
                    <a href="<?php echo e(route('students.show', $student->id)); ?>" class="px-6 py-2.5 rounded-lg text-sm font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                        Cancel
                    </a>
                    <button class="px-8 py-2.5 bg-primary text-white rounded-lg text-sm font-bold shadow-sm hover:bg-primary/90 transition-all active:scale-95" type="submit">
                        Update Student
                    </button>
                </div>

            </form>
        </div>

        
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-5 bg-slate-50 dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">
                <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center text-primary mb-3">
                    <span class="material-symbols-outlined text-lg">badge</span>
                </div>
                <h4 class="text-xs font-bold uppercase tracking-widest text-slate-900 dark:text-white">Student ID</h4>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed"><?php echo e($student->student_code ?? $student->student_id ?? 'N/A'); ?> — This ID cannot be changed.</p>
            </div>
            <div class="p-5 bg-slate-50 dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-600 mb-3">
                    <span class="material-symbols-outlined text-lg">history</span>
                </div>
                <h4 class="text-xs font-bold uppercase tracking-widest text-slate-900 dark:text-white">Change Tracking</h4>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">All changes are logged in the system activity history.</p>
            </div>
            <div class="p-5 bg-slate-50 dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">
                <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600 mb-3">
                    <span class="material-symbols-outlined text-lg">assignment_late</span>
                </div>
                <h4 class="text-xs font-bold uppercase tracking-widest text-slate-900 dark:text-white">Required Fields</h4>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">All fields are required for a successful update.</p>
            </div>
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
<?php endif; ?><?php /**PATH D:\Student-Management-System\resources\views/students/edit.blade.php ENDPATH**/ ?>