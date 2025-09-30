
<?php $__env->startSection('main-content'); ?>
    <div class="container-fluid">
        <iframe src="<?php echo e(url('laravel-filemanager')); ?>" style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\benny_cards\laravel\resources\views/backend/layouts/file-manager.blade.php ENDPATH**/ ?>