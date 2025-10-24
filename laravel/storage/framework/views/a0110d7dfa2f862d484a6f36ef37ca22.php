<?php if($paginator->hasPages()): ?>
<nav class="flex justify-center items-center space-x-3 mt-6 text-gray-600 text-2xl">
    
    <?php if($paginator->onFirstPage()): ?>
        <span class="cursor-not-allowed select-none px-3 py-1 rounded">&laquo;</span>
    <?php else: ?>
        <a href="<?php echo e($paginator->previousPageUrl()); ?>" class="hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 px-3 py-1 rounded">&laquo;</a>
    <?php endif; ?>

    
    <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(is_string($element)): ?>
            <span class="px-2 select-none">…</span>
        <?php endif; ?>

        <?php if(is_array($element)): ?>
            <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($page == $paginator->currentPage()): ?>
                    <span class="px-4 py-2 font-bold text-white bg-info rounded shadow select-none"><?php echo e($page); ?></span> 
                <?php else: ?>
                    <a href="<?php echo e($url); ?>" class="px-3 py-1 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded"><?php echo e($page); ?></a>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    
    <?php if($paginator->hasMorePages()): ?>
        <a href="<?php echo e($paginator->nextPageUrl()); ?>" class="hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 px-3 py-1 rounded">&raquo;</a>
    <?php else: ?>
        <span class="cursor-not-allowed select-none px-3 py-1 rounded">&raquo;</span>
    <?php endif; ?>
</nav>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\benny_cards\laravel\resources\views/vendor/pagination/tailwind.blade.php ENDPATH**/ ?>