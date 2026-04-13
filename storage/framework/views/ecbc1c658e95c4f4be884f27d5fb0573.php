<?php if (isset($component)) { $__componentOriginal09ae9edb6a4f3743836239ca1a9c4719 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal09ae9edb6a4f3743836239ca1a9c4719 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.master','data' => ['title' => 'Export Academic Scores']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.master'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Export Academic Scores']); ?>

     <?php $__env->slot('breadcrumb', null, []); ?> 
        <?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['links' => ['Dashboard' => '/welcome', 'Academic Scores' => route('academicrecords.index')],'current' => 'Export']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['links' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['Dashboard' => '/welcome', 'Academic Scores' => route('academicrecords.index')]),'current' => 'Export']); ?>
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

    <div class="flex flex-1 flex-col items-center justify-center">

        
        <div class="w-full max-w-2xl overflow-hidden rounded-xl bg-white dark:bg-slate-900 shadow-sm border border-slate-200 dark:border-slate-800">
            <div class="p-12 flex flex-col items-center text-center">

                
                <div class="mb-8 flex h-24 w-24 items-center justify-center rounded-full bg-primary/10 text-primary">
                    <span class="material-symbols-outlined text-5xl">file_export</span>
                </div>

                
                <h2 class="mb-3 text-2xl font-bold text-slate-900 dark:text-white">
                    Export Academic Scores
                </h2>
                <p class="mb-10 max-w-md text-slate-600 dark:text-slate-400 leading-relaxed">
                    Generate a complete export of academic records, grades, and student performance data in your preferred format. Your file will be processed and downloaded automatically.
                </p>

                
                <a
                    href="<?php echo e(route('academicrecords.exportcsv')); ?>"
                    class="flex items-center justify-center gap-2 rounded-lg bg-primary px-8 py-3.5 text-base font-semibold text-white shadow-lg shadow-primary/25 hover:bg-primary/90 transition-all active:scale-95"
                >
                    <span class="material-symbols-outlined text-xl">download</span>
                    <span>Generate and Export</span>
                </a>

                
                <div class="mt-8 flex items-center gap-4 border-t border-slate-100 dark:border-slate-800 pt-8 w-full justify-center">
                    <div class="flex items-center gap-1.5 text-xs text-slate-500 dark:text-slate-400">
                        <span class="material-symbols-outlined text-base">verified</span>
                        <span>Security Verified</span>
                    </div>
                    <div class="h-1 w-1 rounded-full bg-slate-300 dark:bg-slate-700"></div>
                    <div class="flex items-center gap-1.5 text-xs text-slate-500 dark:text-slate-400">
                        <span class="material-symbols-outlined text-base">history</span>
                        <span>Last export: 2 days ago</span>
                    </div>
                </div>

            </div>
        </div>

        
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4 w-full max-w-2xl">

            
            <div class="p-4 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex items-start gap-4">
                <div class="p-2 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600">
                    <span class="material-symbols-outlined">table_chart</span>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-slate-900 dark:text-white">CSV Format</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Universal format for Excel and Google Sheets data analysis.</p>
                </div>
            </div>

            
            <div class="p-4 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex items-start gap-4">
                <div class="p-2 rounded-lg bg-amber-50 dark:bg-amber-500/10 text-amber-600">
                    <span class="material-symbols-outlined">picture_as_pdf</span>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-slate-900 dark:text-white">PDF Archive</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Ready to print official grade reports.</p>
                </div>
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
<?php endif; ?><?php /**PATH D:\University\University Year 2\Backend Development with Api\Laravel\Student-Management-System\resources\views/academicrecords/export.blade.php ENDPATH**/ ?>