

<?php $__env->startSection('title','BENNY CARDS || PRODUCT PAGE'); ?>

<?php $__env->startSection('main-content'); ?>
<!-- Breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="<?php echo e(url('/')); ?>">Home<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><span><?php echo e($category_name); ?></span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->

<!-- Product Style -->
<div class="container mt-3 mb-3">
    <h3 class="text-start text-uppercase"><?php echo e($category_name); ?></h3>
</div>

<form action="<?php echo e(route('shop.filter')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <section class="product-area shop-sidebar shop section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="shop-sidebar d-flex justify-content-between flex-wrap">
                        <!-- Single Widget -->
                        <div class="single-widget category">
                            <h3 class="title">Categories</h3>
                            <?php
                            $categories = App\Models\Category::getAllParentWithChild();
                            ?>
                            <select name="category" class="form-control" onchange="this.form.submit()">
                                <option value="">Select Category</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cat->slug); ?>" <?php if(!empty($_GET['category']) &&
                                    $_GET['category']==$cat->slug): ?> selected <?php endif; ?>>
                                    <?php echo e($cat->title); ?>

                                </option>
                                <?php if($cat->child_cat->count() > 0): ?>
                                <?php $__currentLoopData = $cat->child_cat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($sub->slug); ?>" <?php if(!empty($_GET['category']) &&
                                    $_GET['category']==$sub->slug): ?> selected <?php endif; ?>>
                                    &nbsp;&nbsp;— <?php echo e($sub->title); ?>

                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!--/ End Single Widget -->
                        <!-- Shop By Price -->
                        <div class="single-widget range">
                            <h3 class="title">Price</h3>
                            <div class="price-filter-inner">
                                <?php
                                $price_ranges =
                                DB::table('price_ranges')->where('status','active')->orderBy('min_price','ASC')->get();
                                ?>
                                <select name="price_range" class="form-control" onchange="this.form.submit()">
                                    <option value="">Select Price</option>
                                    <?php $__currentLoopData = $price_ranges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $range): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($range->slug); ?>" <?php if(!empty($_GET['price_range']) &&
                                        $_GET['price_range']==$range->slug): ?> selected <?php endif; ?>>
                                        <?php echo e($range->title); ?>

                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="single-widget category">
                            <h3 class="title">Brands</h3>
                            <?php
                            $brands = DB::table('brands')->orderBy('title','ASC')->where('status','active')->get();
                            ?>
                            <select name="brand" class="form-control" onchange="this.form.submit()">
                                <option value="">Select Brand</option>
                                <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($brand->slug); ?>" <?php if(!empty($_GET['brand']) &&
                                    $_GET['brand']==$brand->slug): ?> selected <?php endif; ?>>
                                    <?php echo e($brand->title); ?>

                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                    </div>
                </div>
                <div class="col-lg-12 col-md-8 col-12">
                    <div class="row">
                        <div class="col-12">
                        </div>
                    </div>
                    <div class="row">
                        
                        <?php if(count($products)>0): ?>
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="single-product">
                                <div class="product-img">
                                    <a href="<?php echo e(route('product-detail',$product->slug)); ?>">
                                        <?php
                                        $photo=explode(',',$product->photo);
                                        ?>
                                        <img class="default-img" src="<?php echo e($photo[0]); ?>" alt="<?php echo e($photo[0]); ?>">
                                        <img class="hover-img" src="<?php echo e($photo[0]); ?>" alt="<?php echo e($photo[0]); ?>">
                                        <?php if($product->discount): ?>
                                        <span class="price-dec"><?php echo e($product->discount); ?> % Off</span>
                                        <?php endif; ?>
                                    </a>
                                    <div class="button-head">
                                        <div class="product-action">
                                            <a data-toggle="modal" data-target="#<?php echo e($product->id); ?>" title="Quick View"
                                                href="#"><i class=" ti-eye"></i><span>Quick Shop</span></a>
                                            <a title="Wishlist" href="<?php echo e(route('add-to-wishlist',$product->slug)); ?>"
                                                class="wishlist" data-id="<?php echo e($product->id); ?>"><i
                                                    class=" ti-heart "></i><span>Add to Wishlist</span></a>
                                        </div>
                                        <div class="product-action-2">
                                            <a title="Add to cart" href="<?php echo e(route('add-to-cart',$product->slug)); ?>">Add to
                                                cart</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h3><a href="<?php echo e(route('product-detail',$product->slug)); ?>"><?php echo e($product->title); ?></a>
                                    </h3>
                                    <?php
                                    $after_discount=($product->price-($product->price*$product->discount)/100);
                                    ?>
                                    <span>₹<?php echo e(number_format($after_discount,2)); ?></span>
                                    <!-- <del style="padding-left:4%;">₹<?php echo e(number_format($product->price,2)); ?></del> -->
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                        <h4 class="text-warning" style="margin:100px auto;">There are no products.</h4>
                        <?php endif; ?>
                    </div>
                    <div class="row">
<<<<<<< HEAD
                            <div class="col-md-12 justify-content-center d-flex">
                                <?php echo e($products->appends($_GET)->links()); ?>

                            </div>
                    </div>
=======
                        <div class="col-md-12 justify-content-center d-flex">
                            <?php echo e($products->appends($_GET)->links()); ?>

                        </div>
                    </div>

>>>>>>> a7e52c3faa7299694fb1684abe1e3bf8a959ca9b
                </div>
            </div>
        </div>
    </section>
</form>


<?php $__env->stopSection(); ?>
<?php $__env->startPush('styles'); ?>
<style>
    .pagination {
        display: inline-flex;
    }

    .filter_button {
        /* height:20px; */
        text-align: center;
        background: #F7941D;
        padding: 8px 16px;
        margin-top: 10px;
        color: white;
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
    $(document).ready(function() {
        /*----------------------------------------------------*/
        /*  Jquery Ui slider js
        /*----------------------------------------------------*/
        if ($("#slider-range").length > 0) {
            const max_value = parseInt($("#slider-range").data('max')) || 500;
            const min_value = parseInt($("#slider-range").data('min')) || 0;
            const currency = $("#slider-range").data('currency') || '';
            let price_range = min_value + '-' + max_value;
            if ($("#price_range").length > 0 && $("#price_range").val()) {
                price_range = $("#price_range").val().trim();
            }

            let price = price_range.split('-');
            $("#slider-range").slider({
                range: true,
                min: min_value,
                max: max_value,
                values: price,
                slide: function(event, ui) {
                    $("#amount").val(currency + ui.values[0] + " -  " + currency + ui.values[1]);
                    $("#price_range").val(ui.values[0] + "-" + ui.values[1]);
                }
            });
        }
        if ($("#amount").length > 0) {
            const m_currency = $("#slider-range").data('currency') || '';
            $("#amount").val(m_currency + $("#slider-range").slider("values", 0) +
                "  -  " + m_currency + $("#slider-range").slider("values", 1));
        }
    })
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\benny_cards\laravel\resources\views/frontend/pages/product-grids.blade.php ENDPATH**/ ?>