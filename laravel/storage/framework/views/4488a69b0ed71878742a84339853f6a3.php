<div class="row">
    <?php if(count($products) > 0): ?>
        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $photo = explode(',', $product->photo);
                $after_discount = ($product->price - ($product->price * $product->discount) / 100);
            ?>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="product-card-modern">
                    <div class="product-image-modern">
                        <a href="<?php echo e(route('product-detail', $product->slug)); ?>">
                            <img src="<?php echo e($photo[0]); ?>" alt="<?php echo e($product->title); ?>">
                        </a>
                        <?php if($product->stock <= 0): ?>
                            <span class="badge out-of-stock">Sold Out</span>
                        <?php elseif($product->condition == 'new'): ?>
                            <span class="badge new">New</span>
                        <?php elseif($product->condition == 'hot'): ?>
                            <span class="badge hot">Hot</span>
                        <?php elseif($product->condition == 'trending'): ?>
                            <span class="badge trending">Trending</span>
                        <?php endif; ?>
                    </div>
                    <div class="product-info-modern text-center">
                        <h3 class="product-title">
                            <a href="<?php echo e(route('product-detail', $product->slug)); ?>"><?php echo e($product->title); ?></a>
                        </h3>
                        <div class="product-price d-flex justify-content-center align-items-center gap-2">
                            <span class="current-price fw-bold text-dark">₹<?php echo e(number_format($after_discount, 2)); ?></span>
                            <?php if($product->discount > 0): ?>
                                <del class="text-muted small">₹<?php echo e(number_format($product->price, 2)); ?></del>
                                <span class="badge discount-badge"><?php echo e($product->discount); ?>% Off</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <h4 class="text-warning text-center my-5">There are no products.</h4>
    <?php endif; ?>
</div>

<div class="row">
    <div class="col-md-12 d-flex justify-content-center" id="pagination-links">
        <?php echo e($products->appends(request()->query())->links()); ?>

    </div>
</div>
<?php /**PATH C:\xampp\htdocs\benny_cards\laravel\resources\views/frontend/pages/product-grids-ajax.blade.php ENDPATH**/ ?>