<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['links' => [], 'current' => '']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['links' => [], 'current' => '']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="flex items-center gap-2 text-sm font-medium text-slate-500">
    <?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e($url); ?>" class="hover:text-primary transition-colors"><?php echo e($label); ?></a>
        <span class="text-slate-300">/</span>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <span class="text-slate-900 dark:text-white"><?php echo e($current); ?></span>
</div><?php /**PATH D:\Student-Management-System\resources\views/components/breadcrumb.blade.php ENDPATH**/ ?>