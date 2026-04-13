<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php if(session('success')): ?>
        <div class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-lg z-50" role="alert">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <form action="<?php echo e(route('handleLogout')); ?>" method="post">
        <?php echo csrf_field(); ?>
        <button type="submit">Logout</button>
    </form>
</body>
</html><?php /**PATH D:\University\University Year 2\Backend Development with Api\Laravel\Student-Management-System\resources\views/welcome.blade.php ENDPATH**/ ?>