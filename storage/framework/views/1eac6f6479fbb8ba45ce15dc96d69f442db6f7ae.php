<!DOCTYPE html>
<html lang="en">

<head>
    <title>Document</title>
</head>

<body>
    <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <li>
        <a href="<?php echo e($service->patch()); ?>"><?php echo e($service->name); ?></a>
    </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <h1>no services</h1>
    <?php endif; ?>
</body>

</html>
<?php /**PATH C:\Users\AKH\OneDrive\Desktop\project\سلمونی\hairdresser-appointments\resources\views/service/index.blade.php ENDPATH**/ ?>