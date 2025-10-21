

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
    <h3 class="text-start"><?php echo e($category_name); ?></h3>
         
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

                        <!--/ End Shop By Price -->
                        <!-- Single Widget -->

                        <!--/ End Single Widget -->
                        <!-- Single Widget -->
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

                        <!--/ End Single Widget -->
                    </div>
                </div>
                <div class="col-lg-12 col-md-8 col-12">
                    <div class="row">
                        <div class="col-12">
                            <!-- Shop Top -->
                            <!-- <div class="shop-top">
                                    <div class="shop-shorter">
                                        <div class="single-shorter">
                                            <label>Show :</label>
                                            <select class="show" name="show" onchange="this.form.submit();">
                                                <option value="">Default</option>
                                                <option value="9" <?php if(!empty($_GET['show']) && $_GET['show']=='9'): ?> selected <?php endif; ?>>09</option>
                                                <option value="15" <?php if(!empty($_GET['show']) && $_GET['show']=='15'): ?> selected <?php endif; ?>>15</option>
                                                <option value="21" <?php if(!empty($_GET['show']) && $_GET['show']=='21'): ?> selected <?php endif; ?>>21</option>
                                                <option value="30" <?php if(!empty($_GET['show']) && $_GET['show']=='30'): ?> selected <?php endif; ?>>30</option>
                                            </select>
                                        </div>
                                        <div class="single-shorter">
                                            <label>Sort By :</label>
                                            <select class='sortBy' name='sortBy' onchange="this.form.submit();">
                                                <option value="">Default</option>
                                                <option value="title" <?php if(!empty($_GET['sortBy']) && $_GET['sortBy']=='title'): ?> selected <?php endif; ?>>Name</option>
                                                <option value="price" <?php if(!empty($_GET['sortBy']) && $_GET['sortBy']=='price'): ?> selected <?php endif; ?>>Price</option>
                                                <option value="category" <?php if(!empty($_GET['sortBy']) && $_GET['sortBy']=='category'): ?> selected <?php endif; ?>>Category</option>
                                                <option value="brand" <?php if(!empty($_GET['sortBy']) && $_GET['sortBy']=='brand'): ?> selected <?php endif; ?>>Brand</option>
                                            </select>
                                        </div>
                                    </div>
                                    <ul class="view-mode">
                                        <li class="active"><a href="javascript:void(0)"><i class="fa fa-th-large"></i></a></li>
                                        <li><a href="<?php echo e(route('product-lists')); ?>"><i class="fa fa-th-list"></i></a></li>
                                    </ul>
                                </div> -->
                            <!--/ End Shop Top -->
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
                            <div class="col-md-12 justify-content-center d-flex">
                                <?php echo e($products->appends($_GET)->links()); ?>

                            </div>
                          </div>

                </div>
            </div>
        </div>
    </section>
</form>

<!--/ End Product Style 1  -->



<!-- Modal -->
<?php if($products): ?>
<?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="<?php echo e($product->id); ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close"
                        aria-hidden="true"></span></button>
            </div>
            <div class="modal-body">
                <div class="row no-gutters">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <!-- Product Slider -->
                        <div class="product-gallery">
                            <div class="quickview-slider-active">
                                <?php
                                $photo=explode(',',$product->photo);
                                // dd($photo);
                                ?>
                                <?php $__currentLoopData = $photo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="single-slider">
                                    <img src="<?php echo e($data); ?>" alt="<?php echo e($data); ?>">
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <!-- End Product slider -->
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <div class="quickview-content">
                            <h2><?php echo e($product->title); ?></h2>
                            <div class="quickview-ratting-review">
                                <div class="quickview-ratting-wrap">
                                    <div class="quickview-ratting">
                                        
                                        <?php
                                        $rate=DB::table('product_reviews')->where('product_id',$product->id)->avg('rate');
                                        $rate_count=DB::table('product_reviews')->where('product_id',$product->id)->count();
                                        ?>
                                        <?php for($i=1; $i<=5; $i++): ?> <?php if($rate>=$i): ?>
                                            <i class="yellow fa fa-star"></i>
                                            <?php else: ?>
                                            <i class="fa fa-star"></i>
                                            <?php endif; ?>
                                            <?php endfor; ?>
                                    </div>
                                    <a href="#"> (<?php echo e($rate_count); ?> customer review)</a>
                                </div>
                                <div class="quickview-stock">
                                    <?php if($product->stock >0): ?>
                                    <span><i class="fa fa-check-circle-o"></i> <?php echo e($product->stock); ?> in stock</span>
                                    <?php else: ?>
                                    <span><i class="fa fa-times-circle-o text-danger"></i> <?php echo e($product->stock); ?> out
                                        stock</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php
                            $after_discount=($product->price-($product->price*$product->discount)/100);
                            ?>
                            <h3><small><del class="text-muted">$<?php echo e(number_format($product->price,2)); ?></del></small>
                                $<?php echo e(number_format($after_discount,2)); ?> </h3>
                            <div class="quickview-peragraph">
                                <p><?php echo html_entity_decode($product->summary); ?></p>
                            </div>
                            <?php if($product->size): ?>
                            <div class="size">
                                <h4>Size</h4>
                                <ul>
                                    <?php
                                    $sizes=explode(',',$product->size);
                                    // dd($sizes);
                                    ?>
                                    <?php $__currentLoopData = $sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><a href="#" class="one"><?php echo e($size); ?></a></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                            <?php endif; ?>
                            <div class="size">
                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <h5 class="title">Size</h5>
                                        <select>
                                            <?php
                                            $sizes=explode(',',$product->size);
                                            // dd($sizes);
                                            ?>
                                            <?php $__currentLoopData = $sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option><?php echo e($size); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    
                                </div>
                            </div>
                            <form action="<?php echo e(route('single-add-to-cart')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="quantity">
                                    <!-- Input Order -->
                                    <div class="input-group">
                                        <div class="button minus">
                                            <button type="button" class="btn btn-primary btn-number" disabled="disabled"
                                                data-type="minus" data-field="quant[1]">
                                                <i class="ti-minus"></i>
                                            </button>
                                        </div>
                                        <input type="hidden" name="slug" value="<?php echo e($product->slug); ?>">
                                        <input type="text" name="quant[1]" class="input-number" data-min="1"
                                            data-max="1000" value="1">
                                        <div class="button plus">
                                            <button type="button" class="btn btn-primary btn-number" data-type="plus"
                                                data-field="quant[1]">
                                                <i class="ti-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!--/ End Input Order -->
                                </div>
                                <div class="add-to-cart">
                                    <button type="submit" class="btn">Add to cart</button>
                                    <a href="<?php echo e(route('add-to-wishlist',$product->slug)); ?>" class="btn min"><i
                                            class="ti-heart"></i></a>
                                </div>
                            </form>
                            <div class="default-social">
                                <!-- ShareThis BEGIN -->
                                <div class="sharethis-inline-share-buttons"></div><!-- ShareThis END -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<!-- Modal end -->

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