<?php if (isset($component)) { $__componentOriginal09ae9edb6a4f3743836239ca1a9c4719 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal09ae9edb6a4f3743836239ca1a9c4719 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.master','data' => ['title' => 'Update Financial Record']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.master'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Update Financial Record']); ?>

     <?php $__env->slot('breadcrumb', null, []); ?> 
        <?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['links' => ['Dashboard' => '/welcome', 'Financials' => route('financials.index')],'current' => 'Edit: '.e($student->name).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['links' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['Dashboard' => '/welcome', 'Financials' => route('financials.index')]),'current' => 'Edit: '.e($student->name).'']); ?>
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
                <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">Financial Management</h2>
                <p class="text-slate-500 mt-1">Deadline: <span class="font-bold text-primary"><?php echo e($financial->deadline ?? '—'); ?></span></p>
            </div>

            <?php if($lastLog): ?>
                <div class="flex items-center gap-2 px-3 py-1.5 bg-slate-100 dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 hover:bg-white dark:hover:bg-slate-700 transition-colors cursor-default">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    <span class="text-xs font-medium text-slate-600 dark:text-slate-400">
                        Last payment: <?php echo e($lastLog->payment_date ? \Carbon\Carbon::parse($lastLog->payment_date)->diffForHumans() : '—'); ?>

                    </span>
                </div>
            <?php endif; ?>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xl overflow-hidden">

            
            <div class="p-6 bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800 flex items-center gap-4 group">
                <div class="h-12 w-12 rounded-full bg-primary text-white flex items-center justify-center font-bold text-lg shadow-lg shadow-primary/20 transition-transform group-hover:scale-110">
                    <?php echo e(strtoupper(substr($student->name, 0, 1))); ?>

                </div>
                <div>
                    <h3 class="font-bold text-slate-900 dark:text-white group-hover:text-primary transition-colors"><?php echo e($student->name); ?></h3>
                    <p class="text-xs text-slate-500 uppercase tracking-widest font-semibold">Reg ID: <?php echo e($student->id); ?></p>
                </div>
            </div>

            <form action="<?php echo e(route('financials.edit', $financial->student_id)); ?>" method="POST" class="p-8">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Fees Due</label>
                        <div class="relative group">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold transition-colors group-focus-within:text-primary">$</span>
                            <input type="number" step="0.01" name="total_fees" value="<?php echo e(old('total_fees', $financial->total_fees)); ?>"
                                   class="w-full pl-8 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-sm font-medium focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all hover:border-slate-300 dark:hover:border-slate-600"
                                   required>
                        </div>
                    </div>

                    
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Amount Paid</label>
                        <div class="relative group">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold transition-colors group-focus-within:text-emerald-500">$</span>
                            <input type="number" step="0.01" name="amount_paid" value="<?php echo e(old('amount_paid', $financial->amount_paid)); ?>"
                                   class="w-full pl-8 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-sm font-medium focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all hover:border-slate-300 dark:hover:border-slate-600"
                                   required>
                        </div>
                    </div>

                    
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Payment Status</label>
                        <input type="text" id="payment_status_display"
                            value="<?php echo e(old('payment_status', $financial->payment_status)); ?>"
                            readonly
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800/50 text-slate-500 dark:text-slate-400 text-sm font-bold uppercase tracking-tight cursor-not-allowed">
                        <input type="hidden" id="payment_status" name="payment_status"
                            value="<?php echo e(old('payment_status', $financial->payment_status)); ?>">
                    </div>

                    
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Payment Date</label>
                        <input type="date" name="payment_date"
                               value="<?php echo e(old('payment_date', $financial->payment_date ? \Carbon\Carbon::parse($financial->payment_date)->format('Y-m-d') : '')); ?>"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-sm font-medium focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all hover:border-slate-300 dark:hover:border-slate-600"
                               required>
                    </div>

                    
                    <div class="flex flex-col gap-1.5 md:col-span-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Payment Method</label>
                        <select name="payment_method" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all cursor-pointer hover:border-slate-300 dark:hover:border-slate-600">
                            <option value="Cash" <?php echo e(old('payment_method', $financial->payment_method) == 'Cash' ? 'selected' : ''); ?>>Cash</option>
                            <option value="Bank Transfer" <?php echo e(old('payment_method', $financial->payment_method) == 'Bank Transfer' ? 'selected' : ''); ?>>Bank Transfer</option>
                            <option value="Online" <?php echo e(old('payment_method', $financial->payment_method) == 'Online' ? 'selected' : ''); ?>>Online</option>
                        </select>
                    </div>

                </div>

                
                <div class="mt-8 p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 flex items-center justify-between transition-all hover:shadow-inner">
                    <div class="flex flex-col">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Balance Remaining</span>
                        <p class="text-[10px] text-slate-400 mt-0.5 italic">* Recalculated automatically</p>
                    </div>
                    <span id="balance-display" class="text-2xl font-black <?php echo e($financial->balance_remaining > 0 ? 'text-red-500' : 'text-emerald-600'); ?>">
                        $<?php echo e(number_format($financial->balance_remaining, 2)); ?>

                    </span>
                </div>

                
                <div class="mt-10 flex flex-col sm:flex-row items-center justify-end gap-6">
                    <div class="flex items-center gap-4">
                        <a href="<?php echo e(route('financials.index')); ?>" class="px-6 py-2.5 text-sm font-bold text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 transition-all active:scale-95">
                            Cancel
                        </a>
                        <button type="submit" class="bg-slate-900 dark:bg-primary px-10 py-3 rounded-xl text-white font-bold shadow-lg shadow-slate-900/20 dark:shadow-primary/20 hover:opacity-90 hover:shadow-xl transition-all active:scale-95">
                            Save Record
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <?php if($errors->any()): ?>
        <div class="fixed top-6 left-1/2 transform -translate-x-1/2 bg-red-500 text-white px-6 py-3 rounded-xl shadow-2xl z-50 flex items-center gap-3 animate-bounce" role="alert">
            <span class="material-symbols-outlined">error</span>
            <ul class="text-sm font-bold">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <script>
        const totalFeesInput  = document.querySelector('input[name="total_fees"]');
        const amountPaidInput = document.querySelector('input[name="amount_paid"]');
        const balanceDisplay  = document.getElementById('balance-display');
        const statusHidden    = document.getElementById('payment_status'); 
        const statusDisplay   = document.getElementById('payment_status_display'); 

        function updateBalance() {
            const totalFees  = parseFloat(totalFeesInput.value)  || 0;
            const amountPaid = parseFloat(amountPaidInput.value) || 0;
            const balance    = totalFees - amountPaid;

            balanceDisplay.textContent = '$' + balance.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            balanceDisplay.className   = 'text-2xl font-black ' + (balance > 0 ? 'text-red-500' : 'text-emerald-600');

            let status = '';
            if (amountPaid <= 0)       status = 'Unpaid';
            else if (balance <= 0)     status = 'Paid';
            else                       status = 'Partial';

            statusHidden.value  = status;
            statusDisplay.value = status;
        }

        totalFeesInput.addEventListener('input', updateBalance);
        amountPaidInput.addEventListener('input', updateBalance);
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
<?php endif; ?><?php /**PATH D:\Student-Management-System\resources\views/financials/edit.blade.php ENDPATH**/ ?>