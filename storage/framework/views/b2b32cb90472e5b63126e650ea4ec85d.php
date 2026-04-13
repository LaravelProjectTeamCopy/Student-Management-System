<?php if (isset($component)) { $__componentOriginal6107cafe1a6b2bb3ae2fbdc60a313162 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6107cafe1a6b2bb3ae2fbdc60a313162 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.auth','data' => ['title' => 'Register']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.auth'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Register']); ?>
    <style>
        @layer utilities {
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none;
            }
        }
    </style>
    <div class="layout-content-container flex flex-col max-w-[480px] w-full bg-white dark:bg-slate-900 p-8 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 shadow-xl">

        
        <div class="text-center">
            <div class="flex flex-col items-center">

                <div class="flex items-center gap-3 mb-6">
                    <div class="size-10 bg-primary rounded-lg flex items-center justify-center text-white">
                        <span class="material-symbols-outlined text-3xl">school</span>
                    </div>
                    <h2 class="text-slate-900 dark:text-slate-100 text-2xl font-bold leading-tight tracking-tight">
                        EduAdmin
                    </h2>
                </div>

                <div class="text-center">
                    <h1 class="text-slate-900 dark:text-slate-100 text-3xl font-bold mb-2">
                        Create Your Account
                    </h1>
                    <p class="text-slate-500 dark:text-slate-400 text-sm">
                        Join the EduAdmin Management System
                    </p>
                </div>

            </div>
        </div>

        
        <form action="<?php echo e(route('handleRegister')); ?>" method="POST" class="flex flex-col gap-5">
            <?php echo csrf_field(); ?>

            
            <div class="flex flex-col gap-2">
                <label class="text-slate-900 dark:text-slate-100 text-sm font-medium leading-normal flex items-center gap-2 font-semibold">
                    <span class="material-symbols-outlined text-lg">person</span>
                    Name
                </label>
                <input
                    type="text"
                    name = "name"
                    value = "<?php echo e(old('name')); ?>"
                    placeholder="Enter your name"
                    required=""
                    class="w-full px-4 py-3.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none placeholder:text-slate-400"
                />
            </div>
            
            
            <div class="flex flex-col gap-2">
                <label class="text-slate-900 dark:text-slate-100 text-sm font-medium leading-normal flex items-center gap-2 font-semibold">
                    <span class="material-symbols-outlined text-lg">mail</span>
                    Email Address
                </label>
                <input
                    type="email"
                    name = "email"
                    value = "<?php echo e(old('email')); ?>"
                    placeholder="name@university.edu"
                    required=""
                    class="w-full px-4 py-3.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none placeholder:text-slate-400"
                />
            </div>

            
            <div class="flex flex-col gap-2">
                <label class="text-slate-900 dark:text-slate-100 text-sm font-medium leading-normal flex items-center gap-2 font-semibold">
                    <span class="material-symbols-outlined text-lg">lock</span>
                    Password
                </label>
                
                <div class="relative flex items-center">
                    <input
                        type="password"
                        name="password"
                        placeholder="Enter your password"
                        class="w-full px-4 py-3.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none placeholder:text-slate-400"
                    />
                    <button type="button" class="toggle-password absolute right-4 text-slate-400 hover:text-slate-600 cursor-pointer">
                        <span class="material-symbols-outlined">visibility</span>
                    </button>
                </div>
            </div>
            <div class="flex flex-col gap-2">
                <label class="text-slate-900 dark:text-slate-100 text-sm font-medium leading-normal flex items-center gap-2 font-semibold">
                    <span class="material-symbols-outlined text-lg">lock_reset</span>
                    Confirm Password
                </label>
                
                <div class="relative flex items-center">
                    <input
                        type="password"
                        name="password_confirmation"
                        placeholder="Repeat your password"
                        class="w-full px-4 py-3.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none placeholder:text-slate-400"
                    />
                    <button type="button" class="toggle-password absolute right-4 text-slate-400 hover:text-slate-600 cursor-pointer">
                        <span class="material-symbols-outlined">visibility</span>
                    </button>
                </div>
            </div>

            
            <div class="mt-4">
                <button
                    type="submit"
                    class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-3 px-4 rounded-lg transition-colors shadow-lg shadow-primary/20 py-4 flex items-center justify-center gap-2 mt-2"
                >
                    Create Account
                    <span class="material-symbols-outlined text-xl">person_add</span>
                </button>
            </div>

        </form>

        
        <div class="pt-4 border-t border-slate-100 dark:border-slate-800 text-center">
            <p class="text-slate-600 dark:text-slate-400 text-sm">
                Already have an account?
                <a href="/login" class="text-primary font-bold hover:underline ml-1">Login here</a>
            </p>
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
    <script>
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.previousElementSibling;
                const icon = this.querySelector('.material-symbols-outlined');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.textContent = 'visibility_off';
                } else {
                    input.type = 'password';
                    icon.textContent = 'visibility';
                }
            });
        });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6107cafe1a6b2bb3ae2fbdc60a313162)): ?>
<?php $attributes = $__attributesOriginal6107cafe1a6b2bb3ae2fbdc60a313162; ?>
<?php unset($__attributesOriginal6107cafe1a6b2bb3ae2fbdc60a313162); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6107cafe1a6b2bb3ae2fbdc60a313162)): ?>
<?php $component = $__componentOriginal6107cafe1a6b2bb3ae2fbdc60a313162; ?>
<?php unset($__componentOriginal6107cafe1a6b2bb3ae2fbdc60a313162); ?>
<?php endif; ?><?php /**PATH D:\University\University Year 2\Backend Development with Api\Laravel\Student-Management-System\resources\views/auth/register.blade.php ENDPATH**/ ?>