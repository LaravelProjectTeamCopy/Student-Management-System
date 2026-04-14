<?php if (isset($component)) { $__componentOriginal6107cafe1a6b2bb3ae2fbdc60a313162 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6107cafe1a6b2bb3ae2fbdc60a313162 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.auth','data' => ['title' => 'Login']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.auth'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Login']); ?>
    <?php if(session('success')): ?>
        <div class="fixed top-4 left-1/2 -translate-x-1/2 z-50 bg-green-100 border border-green-400 text-green-700 px-6 py-3 rounded-lg shadow-lg">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <div class="w-full max-w-[480px] bg-white dark:bg-slate-900 rounded-xl shadow-xl overflow-hidden border border-slate-200 dark:border-slate-800">
        
        <div class="p-8 pb-0 flex flex-col items-center">

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
                    Welcome Back
                </h1>
                <p class="text-slate-500 dark:text-slate-400 text-sm">
                    Access the management system with your credentials
                </p>
            </div>

        </div>

        
        <form action = "<?php echo e(route('handleLogin')); ?>" method = "POST">
            <?php echo csrf_field(); ?>
            <div class="p-8 space-y-5">

                    
                <div class="space-y-2">
                    <label class="text-slate-700 dark:text-slate-300 text-sm font-semibold flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg">mail</span>
                        Email Address
                    </label>
                    <input
                        type="email"
                        name = "email"
                        value = "<?php echo e(old('email')); ?>"
                        placeholder="admin@eduadmin.com"
                        class="w-full px-4 py-3.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none placeholder:text-slate-400"
                    />
                </div>

                
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <label class="text-slate-700 dark:text-slate-300 text-sm font-semibold flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">lock</span>
                            Password
                        </label>
                        <a href="/select" class="text-primary text-xs font-semibold hover:underline">
                            Forgot Password?
                        </a>
                    </div>
                    <div class="relative group">
                        <input
                            type="password"
                            name = "password"
                            value = "<?php echo e(old('password')); ?>"
                            placeholder="••••••••"
                            class="w-full px-4 py-3.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none placeholder:text-slate-400"
                        />
                    </div>
                </div>
                

                
                <div class="flex items-center gap-2">
                    <input
                        type="checkbox"
                        name="remember"
                        id="remember"
                        class="rounded border-slate-300 text-primary focus:ring-primary cursor-pointer"
                    />
                    <label for="remember" class="text-sm text-slate-600 dark:text-slate-400 cursor-pointer">
                        Keep me logged in
                    </label>
                </div>

                
                <button class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-4 rounded-lg shadow-lg shadow-primary/20 transition-all flex items-center justify-center gap-2 mt-2" type="submit">
                    Log In
                    <span class="material-symbols-outlined text-xl">login</span>
                </button>
            </form>

            
            <div class="pt-4 border-t border-slate-100 dark:border-slate-800 text-center">
                <p class="text-slate-600 dark:text-slate-400 text-sm">
                    New to the system?
                    <a href="/register" class="text-primary font-bold hover:underline ml-1">Create an account</a>
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
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6107cafe1a6b2bb3ae2fbdc60a313162)): ?>
<?php $attributes = $__attributesOriginal6107cafe1a6b2bb3ae2fbdc60a313162; ?>
<?php unset($__attributesOriginal6107cafe1a6b2bb3ae2fbdc60a313162); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6107cafe1a6b2bb3ae2fbdc60a313162)): ?>
<?php $component = $__componentOriginal6107cafe1a6b2bb3ae2fbdc60a313162; ?>
<?php unset($__componentOriginal6107cafe1a6b2bb3ae2fbdc60a313162); ?>
<?php endif; ?><?php /**PATH D:\Student-Management-System\resources\views/auth/login.blade.php ENDPATH**/ ?>