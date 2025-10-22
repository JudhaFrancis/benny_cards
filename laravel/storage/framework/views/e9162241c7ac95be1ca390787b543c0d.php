
<?php $__env->startSection('title','BENNY CARDS || HOME PAGE'); ?>
<?php $__env->startSection('main-content'); ?>
<!-- Slider Area -->
<?php if(count($banners)>0): ?>
<section id="Gslider" class="carousel slide" data-ride="carousel" data-interval="3000">
    <ol class="carousel-indicators">
        <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li data-target="#Gslider" data-slide-to="<?php echo e($key); ?>" class="<?php echo e((($key==0)? 'active' : '')); ?>"></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </ol>
    <div class="carousel-inner" role="listbox">
        <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="carousel-item <?php echo e((($key==0)? 'active' : '')); ?>">
            <img class="first-slide" src="<?php echo e($banner->photo); ?>" alt="First slide">
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <a class="carousel-control-prev" href="#Gslider" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#Gslider" role="button" data-slide="next">
        <span class="carousel-control-ne    xt-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</section>
<?php endif; ?>
<!--/ End Slider Area -->

<!-- Wedding Cards by Religion Section -->
<section class="section">
    <div class="section-container ">
        <div class="section-title">
            <h2>Wedding Invitations by Religion</h2>
        </div>
        <div class="category-grid-modern">
            <?php
            $category_lists = DB::table('categories')->where('status','active')->where('is_parent',1)->get();
            ?>
            <?php $__currentLoopData = $category_lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="category-card-modern">
                <div class="category-image-modern">
                    <?php if($cat->photo): ?>
                    <img src="<?php echo e($cat->photo); ?>" alt="<?php echo e($cat->title); ?>">
                    <?php else: ?>
                    <img src="https://via.placeholder.com/400x400" alt="<?php echo e($cat->title); ?>">
                    <?php endif; ?>
                    <a href="<?php echo e(route('product-cat', $cat->slug)); ?>" class="view-more-text">
                        View More <span class="arrow">→</span>
                    </a>
                </div>
                <div class="category-content-modern">
                    <h4 class="category-title"><?php echo e($cat->title); ?></h4>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<!-- End Small Banner -->

<!-- All categories -->
<section class="trending-products-section section" style="padding-top: 0px;">
    <div class="section-container">
        <!-- Section Title -->
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>All Categories</h2>
                </div>
            </div>
        </div>

        <!-- Tab Nav -->
        <ul class="nav nav-tabs filter-tope-group mb-4" id="myTab" role="tablist">
            <?php
            $categories = DB::table('categories')->where('status','active')->where('is_parent',1)->get();
            ?>
            <?php if($categories): ?>
            <button class="btn active" style="background:white;color:black;" data-filter="*">All Categories</button>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <button class="btn" style="background:white;color:black;" data-filter=".<?php echo e($cat->id); ?>">
                <?php echo e($cat->title); ?>

            </button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </ul>

        <!-- Products Grid -->
        <div class="row trending-products-grid isotope-grid">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            $productsByCategory = $product_lists->where('cat_id', $cat->id)->take(8);
            ?>

            <?php $__currentLoopData = $productsByCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            $photo = explode(',', $product->photo);
            $after_discount = ($product->price - ($product->price * $product->discount) / 100);
            ?>
            <div class="col-sm-6 col-md-4 col-lg-3 isotope-item <?php echo e($product->cat_id); ?>">
                <div class="product-card-modern">
                    <div class="product-image-modern">
                        <a href="<?php echo e(route('product-detail', $product->slug)); ?>">
                            <img src="<?php echo e($photo[0]); ?>" alt="<?php echo e($product->title); ?>">
                        </a>

                        <!-- Badges -->
                        <?php if($product->stock <= 0): ?>
                            <span class="badge out-of-stock">Sold Out</span>
                            <?php elseif($product->condition == 'trending'): ?>
                            <span class="badge trending">Trending</span>
                            <?php elseif($product->condition == 'new'): ?>
                            <span class="badge new">New</span>
                            <?php elseif($product->condition == 'hot'): ?>
                            <span class="badge hot">Hot</span>
                            <?php endif; ?>

                            <!-- Wishlist -->
                            <a href="<?php echo e(route('add-to-wishlist', $product->slug)); ?>" class="btn-wishlist-top"><i class="ti-heart"></i></a>
                            <!-- Add to Cart -->
                            <a href="<?php echo e(route('add-to-cart', $product->slug)); ?>" class="btn-add-cart-bottom">Add to Cart</a>
                    </div>

                    <!-- Product Info -->
                    <div class="product-info-modern text-center">
                        <h3 class="product-title">
                            <a href="<?php echo e(route('product-detail', $product->slug)); ?>"><?php echo e($product->title); ?></a>
                        </h3>
                        <div class="product-price d-flex justify-content-center align-items-center gap-2">
                            <span class="current-price">₹<?php echo e(number_format($after_discount, 2)); ?></span>
                            <?php if($product->discount > 0): ?>
                            <del class="text-muted">₹<?php echo e(number_format($product->price, 2)); ?></del>
                            <span class="badge discount-badge"><?php echo e($product->discount); ?>% Off</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php if($productsByCategory->count() == 0): ?>
            <div class="col-12 text-center mt-4">
                <p class="text-muted fs-5">No products available in this category right now.</p>
            </div>
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<!-- Start Midium Banner  -->
<section class="midium-banner section" style="padding-top:0px;">
    <div class="section-container">
        <div class="row">
            <?php if($featured): ?>
            <?php $__currentLoopData = $featured; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <!-- Single Banner  -->
            <div class="col-lg-6 col-md-6 col-12">
                <div class="single-banner">
                    <?php $photo=explode(',',$data->photo); ?>
                    <img src="<?php echo e($photo[0]); ?>" alt="<?php echo e($photo[0]); ?>">
                    <div class="content-split">
                        <div class="text-left">
                            <p><?php echo e($data->cat_info['title']); ?></p>
                            <h3><?php echo e($data->title); ?> <br>Up to <span><?php echo e($data->discount); ?>%</span></h3>
                        </div>
                        <div class="button-right">
                            <a href="<?php echo e(route('product-detail',$data->slug)); ?>">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /End Single Banner  -->
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<!-- End Midium Banner -->


<!-- Start Price Range Section -->
<section class="price-range section">
    <div class="section-container">
        <div class="section-title">
            <h2>Price Range</h2>
        </div>
        <div class="price-grid-new">
            <?php
            $price_ranges = DB::table('price_ranges')->where('status','active')->get();
            ?>
            <?php $__currentLoopData = $price_ranges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $price): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="price-card-new">
                <div class="price-image-new">
                    <img src="<?php echo e($price->photo ?? 'https://via.placeholder.com/400x400'); ?>" alt="<?php echo e($price->title); ?>">
                    <div class="ribbon">Starting at ₹<?php echo e($price->min_price); ?></div>
                </div>
                <div class="price-content-new">
                    <h4 class="price-title-new"><?php echo e($price->title); ?></h4>
                    <a href="<?php echo e(route('price-range.products', $price->slug)); ?>" class="price-btn-new">Shop Now</a>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<!-- End Price Range Section -->

<!-- Start Trending Items -->
<section class="product-area most-popular section" style="padding-top:0px;">
    <div class="section-container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Trending Items</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <?php $hasTrending = false; ?>
            <?php $__currentLoopData = $product_lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($product->condition == 'trending'): ?>
            <?php
            $hasTrending = true;
            $photo = explode(',', $product->photo);
            $after_discount = ($product->price - ($product->price * $product->discount) / 100);
            ?>

            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="product-card-modern">
                    <div class="product-image-modern">
                        <a href="<?php echo e(route('product-detail', $product->slug)); ?>">
                            <img src="<?php echo e($photo[0]); ?>" alt="<?php echo e($product->title); ?>">
                        </a>

                        <!-- Badges (except discount) -->
                        <?php if($product->stock <= 0): ?>
                            <span class="badge out-of-stock">Sold Out</span>
                            <?php elseif($product->condition == 'new'): ?>
                            <span class="badge new">New</span>
                            <?php elseif($product->condition == 'hot'): ?>
                            <span class="badge hot">Hot</span>
                            <?php elseif($product->condition == 'trending'): ?>
                            <span class="badge trending">Trending</span>
                            <?php endif; ?>

                            <!-- Wishlist Top Right -->
                            <a href="<?php echo e(route('add-to-wishlist', $product->slug)); ?>" class="btn-wishlist-top">
                                <i class="ti-heart"></i>
                            </a>

                            <!-- Add to Cart Bottom Right -->
                            <a href="<?php echo e(route('add-to-cart', $product->slug)); ?>" class="btn-add-cart-bottom">
                                Add to Cart
                            </a>
                    </div>

                    <!-- Product Info -->
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
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<!-- Start Latest Items -->
<section class="product-area most-popular section" style="padding-top:0px;">
    <div class="section-container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Latest Items</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <?php $hasTrending = false; ?>
            <?php $__currentLoopData = $product_lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($product->condition == 'new'): ?>
            <?php
            $hasTrending = true;
            $photo = explode(',', $product->photo);
            $after_discount = ($product->price - ($product->price * $product->discount) / 100);
            ?>

            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="product-card-modern">
                    <div class="product-image-modern">
                        <a href="<?php echo e(route('product-detail', $product->slug)); ?>">
                            <img src="<?php echo e($photo[0]); ?>" alt="<?php echo e($product->title); ?>">
                        </a>

                        <!-- Badges (except discount) -->
                        <?php if($product->stock <= 0): ?>
                            <span class="badge out-of-stock">Sold Out</span>
                            <?php elseif($product->condition == 'new'): ?>
                            <span class="badge new">New</span>
                            <?php elseif($product->condition == 'hot'): ?>
                            <span class="badge hot">Hot</span>
                            <?php elseif($product->condition == 'trending'): ?>
                            <span class="badge trending">Trending</span>
                            <?php endif; ?>

                            <!-- Wishlist Top Right -->
                            <a href="<?php echo e(route('add-to-wishlist', $product->slug)); ?>" class="btn-wishlist-top">
                                <i class="ti-heart"></i>
                            </a>

                            <!-- Add to Cart Bottom Right -->
                            <a href="<?php echo e(route('add-to-cart', $product->slug)); ?>" class="btn-add-cart-bottom">
                                Add to Cart
                            </a>
                    </div>

                    <!-- Product Info -->
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
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<!-- Start Hot Items -->
<section class="product-area most-popular section" style="padding-top:0px;">
    <div class="section-container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Hot Items</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <?php $hasTrending = false; ?>
            <?php $__currentLoopData = $product_lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($product->condition == 'hot'): ?>
            <?php
            $hasTrending = true;
            $photo = explode(',', $product->photo);
            $after_discount = ($product->price - ($product->price * $product->discount) / 100);
            ?>

            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="product-card-modern">
                    <div class="product-image-modern">
                        <a href="<?php echo e(route('product-detail', $product->slug)); ?>">
                            <img src="<?php echo e($photo[0]); ?>" alt="<?php echo e($product->title); ?>">
                        </a>

                        <!-- Badges (except discount) -->
                        <?php if($product->stock <= 0): ?>
                            <span class="badge out-of-stock">Sold Out</span>
                            <?php elseif($product->condition == 'new'): ?>
                            <span class="badge new">New</span>
                            <?php elseif($product->condition == 'hot'): ?>
                            <span class="badge hot">Hot</span>
                            <?php elseif($product->condition == 'trending'): ?>
                            <span class="badge trending">Trending</span>
                            <?php endif; ?>

                            <!-- Wishlist Top Right -->
                            <a href="<?php echo e(route('add-to-wishlist', $product->slug)); ?>" class="btn-wishlist-top">
                                <i class="ti-heart"></i>
                            </a>

                            <!-- Add to Cart Bottom Right -->
                            <a href="<?php echo e(route('add-to-cart', $product->slug)); ?>" class="btn-add-cart-bottom">
                                Add to Cart
                            </a>
                    </div>

                    <!-- Product Info -->
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
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<!-- End Shop Home List  -->

<!-- Modal -->
<?php if($product_lists): ?>
<?php $__currentLoopData = $product_lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                            <h3><small><del class="text-muted">₹<?php echo e(number_format($product->price,2)); ?></del></small>
                                $<?php echo e(number_format($after_discount,2)); ?> </h3>
                            <div class="quickview-peragraph">
                                <p><?php echo html_entity_decode($product->summary); ?></p>
                            </div>
                            <?php if($product->size): ?>
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
                            <?php endif; ?>
                            <form action="<?php echo e(route('single-add-to-cart')); ?>" method="POST" class="mt-4">
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

<?php $__env->startPush('scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
    /*==================================================================
        [ Isotope ]*/
    var $topeContainer = $('.isotope-grid');
    var $filter = $('.filter-tope-group');

    // filter items on button click
    $filter.each(function() {
        $filter.on('click', 'button', function() {
            var filterValue = $(this).attr('data-filter');
            $topeContainer.isotope({
                filter: filterValue
            });
        });

    });

    // init Isotope
    $(window).on('load', function() {
        var $grid = $topeContainer.each(function() {
            $(this).isotope({
                itemSelector: '.isotope-item',
                layoutMode: 'fitRows',
                percentPosition: true,
                animationEngine: 'best-available',
                masonry: {
                    columnWidth: '.isotope-item'
                }
            });
        });
    });

    var isotopeButton = $('.filter-tope-group button');

    $(isotopeButton).each(function() {
        $(this).on('click', function() {
            for (var i = 0; i < isotopeButton.length; i++) {
                $(isotopeButton[i]).removeClass('how-active1');
            }

            $(this).addClass('how-active1');
        });
    });

    function setEqualHeight() {
        var maxHeight = 0;
        $('.product-card-modern').css('height', 'auto'); // reset

        $('.product-card-modern').each(function() {
            var cardHeight = $(this).outerHeight();
            if (cardHeight > maxHeight) {
                maxHeight = cardHeight;
            }
        });

        $('.product-card-modern').css('height', maxHeight + 'px');
    }

    // Run on page load and window resize
    $(document).ready(setEqualHeight);
    $(window).resize(setEqualHeight);
</script>
<script>
    function cancelFullScreen(el) {
        var requestMethod = el.cancelFullScreen || el.webkitCancelFullScreen || el.mozCancelFullScreen || el.exitFullscreen;
        if (requestMethod) { // cancel full screen.
            requestMethod.call(el);
        } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
            var wscript = new ActiveXObject("WScript.Shell");
            if (wscript !== null) {
                wscript.SendKeys("{F11}");
            }
        }
    }

    function requestFullScreen(el) {
        // Supports most browsers and their versions.
        var requestMethod = el.requestFullScreen || el.webkitRequestFullScreen || el.mozRequestFullScreen || el
            .msRequestFullscreen;

        if (requestMethod) { // Native full screen.
            requestMethod.call(el);
        } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
            var wscript = new ActiveXObject("WScript.Shell");
            if (wscript !== null) {
                wscript.SendKeys("{F11}");
            }
        }
        return false
    }
    document.addEventListener('DOMContentLoaded', () => {
        const filterButtons = document.querySelectorAll('.filter-tope-group .btn');
        const products = document.querySelectorAll('.isotope-item');
        const productsGrid = document.querySelector('.trending-products-grid');

        // Function to filter products
        const filterProducts = (filterValue) => {
            let visibleCount = 0;

            products.forEach(product => {
                if (filterValue === '*' || product.classList.contains(filterValue.substring(1))) {
                    product.style.display = 'block';
                    visibleCount++;
                } else {
                    product.style.display = 'none';
                }
            });

            // Handle "no products" message
            let message = productsGrid.querySelector('.no-products-message');
            if (visibleCount === 0) {
                if (!message) {
                    const msg = document.createElement('div');
                    msg.className = 'col-12 text-center no-products-message mt-2';
                    msg.innerHTML = `<p class="text-muted fs-5">No products available in this category right now.</p>`;
                    productsGrid.appendChild(msg);
                }
            } else if (message) {
                message.remove();
            }
        };

        // Add click listeners to buttons
        filterButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove 'active' from all buttons
                filterButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const filterValue = this.getAttribute('data-filter');
                filterProducts(filterValue);
            });
        });

        // Default filter on page load (show all)
        const defaultBtn = document.querySelector('.filter-tope-group .btn[data-filter="*"]');
        if (defaultBtn) {
            defaultBtn.classList.add('active');
            filterProducts('*');
        }
    });
</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\benny_cards\laravel\resources\views/frontend/index.blade.php ENDPATH**/ ?>