<?php if (isset($component)) { $__componentOriginal09ae9edb6a4f3743836239ca1a9c4719 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal09ae9edb6a4f3743836239ca1a9c4719 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.master','data' => ['title' => 'Student Financials']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.master'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Student Financials']); ?>
    
     <?php $__env->slot('breadcrumb', null, []); ?> 
        <?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['links' => ['Dashboard' => '/welcome', 'Financials' => route('financials.index')],'current' => ''.e($student->name).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['links' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['Dashboard' => '/welcome', 'Financials' => route('financials.index')]),'current' => ''.e($student->name).'']); ?>
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
                Print Statement
            </button>
            <a href="<?php echo e(route('financials.edit', $financial->student_id)); ?>"><button class="flex flex-1 items-center justify-center gap-2 rounded-lg bg-slate-100 px-4 py-2 text-sm font-bold text-slate-900 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-100 lg:flex-none transition-colors">
                <span class="material-symbols-outlined text-sm">edit</span>
                Edit Record
            </button></a>
            <button class="flex flex-1 items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-bold text-white hover:bg-primary/90 lg:flex-none transition-colors">
                <span class="material-symbols-outlined text-sm">payments</span>
                Record Payment
            </button>
        </div>
    </div>

    
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

        
        <div class="lg:col-span-2 flex flex-col gap-8">

            
            <section class="rounded-xl bg-white p-6 shadow-sm dark:bg-slate-900">
                <div class="mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">account_balance_wallet</span>
                    <h3 class="text-lg font-bold">Financial Overview</h3>
                </div>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div class="rounded-lg bg-slate-50 p-4 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Fees Due</p>
                        <p class="mt-1 text-2xl font-bold text-slate-900 dark:text-white"><?php echo e($financial->total_fees); ?></p>
                    </div>
                    <div class="rounded-lg bg-slate-50 p-4 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Amount Paid</p>
                        <p class="mt-1 text-2xl font-bold text-emerald-600"><?php echo e($financial->amount_paid); ?></p>
                    </div>
                    <div class="rounded-lg bg-slate-50 p-4 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Balance Remaining</p>
                        <p class="mt-1 text-2xl font-bold text-red-500"><?php echo e($financial->balance_remaining); ?></p>
                    </div>
                </div>
                
                <?php $pct = $financial->total_fees > 0 ? round(($financial->amount_paid / $financial->total_fees) * 100) : 0; ?>
                <div class="mt-6">
                    <div class="flex justify-between text-xs font-medium text-slate-500 mb-1.5">
                        <span>Payment Progress</span>
                        <span><?php echo e($pct); ?>% Paid</span>
                    </div>
                    <div class="w-full h-2.5 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                        <div class="h-full rounded-full <?php echo e($pct >= 100 ? 'bg-emerald-500' : ($pct >= 50 ? 'bg-amber-500' : 'bg-red-500')); ?>" style="width: <?php echo e($pct); ?>%"></div>
                    </div>
                </div>
            </section>

            
            <section class="rounded-xl bg-white p-6 shadow-sm dark:bg-slate-900">
                <div class="mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">receipt_long</span>
                    <h3 class="text-lg font-bold">Payment Details</h3>
                </div>
                <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Payment Status</p>
                        <span class="mt-1 inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300">
                            <span class="size-1.5 rounded-full bg-amber-500"></span>
                            <?php echo e($financial->payment_status); ?>

                        </span>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Last Payment Date</p>
                        <p class="mt-1 font-medium text-slate-900 dark:text-slate-100"><?php echo e($financial->payment_date ? $financial->payment_date->format('M d, Y') : '—'); ?></p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Major</p>
                        <p class="mt-1 font-medium text-slate-900 dark:text-slate-100"><?php echo e($student->major); ?></p>
                    </div>
                </div>
            </section>

        </div>
        

        
        <div class="lg:col-span-1">
            <section class="h-full rounded-xl bg-white p-6 shadow-sm dark:bg-slate-900">
                <div class="mb-6 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">history</span>
                        <h3 class="text-lg font-bold">Payment History</h3>
                    </div>
                </div>

                <div class="flex flex-col gap-6">
                    <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="relative flex gap-4 pb-2">
                            <div class="absolute left-4 top-8 h-full w-px bg-slate-200 dark:bg-slate-800"></div>
                            <div class="relative z-10 flex size-12 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
                                <span class="material-symbols-outlined text-2xl">payments</span>
                            </div>
                            <div class="flex flex-col">
                                <p class="text-sm font-semibold">Payment Made</p>
                                <p class="text-xs text-slate-500">$<?php echo e(number_format($log->amount_paid, 2)); ?> via <?php echo e($log->payment_method); ?></p>
                                <p class="text-xs text-slate-500">Status: <?php echo e($log->payment_status); ?></p>
                                <p class="mt-1 text-xs text-slate-400"><?php echo e($log->payment_date ? $log->payment_date->format('M d, Y') : '—'); ?></p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-sm text-slate-400">No payment history yet.</p>
                    <?php endif; ?>
                </div>

                <a href="<?php echo e(route('financials.history', $student->id)); ?>"><button class="mt-8 w-full rounded-lg border border-slate-200 dark:border-slate-800 py-2 text-sm font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
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
<?php endif; ?><?php /**PATH D:\xampp\htdocs\proweb\Student-Management-System\resources\views/financials/show.blade.php ENDPATH**/ ?>