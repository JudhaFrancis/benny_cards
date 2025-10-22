
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
    <div class="section-container">
        <div class="section-title">
            <h2>Wedding Invitations by Religion</h2>
        </div>

        <!-- Use the same swiper class -->
        <div class="swiper latest-items-swiper">
            <div class="swiper-wrapper">
                <?php
                $category_lists = DB::table('categories')->where('status','active')->where('is_parent',1)->get();
                ?>
                <?php $__currentLoopData = $category_lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="swiper-slide" style="padding-bottom: 20px;">
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
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Navigation Arrows -->
            <div class="swiper-navigation text-center mt-3">
                <div class="swiper-button-prev d-inline-block me-2"></div>
                <div class="swiper-button-next d-inline-block"></div>
            </div>
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
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <button class="btn" style="background:white;color:black;" data-filter=".<?php echo e($cat->id); ?>">
                <?php echo e($cat->title); ?>

            </button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>

        <!-- Products Grid -->
        <div class="row trending-products-grid isotope-grid">
            <?php $__currentLoopData = $product_lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                        <?php if($product->stock <= 0): ?>
                            <span class="badge out-of-stock">Sold Out</span>
                            <?php elseif($product->condition == 'trending'): ?>
                            <span class="badge trending">Trending</span>
                            <?php elseif($product->condition == 'new'): ?>
                            <span class="badge new">New</span>
                            <?php elseif($product->condition == 'hot'): ?>
                            <span class="badge hot">Hot</span>
                            <?php endif; ?>

                            <a href="<?php echo e(route('add-to-wishlist', $product->slug)); ?>" class="btn-wishlist-top"><i class="ti-heart"></i></a>
                            <a href="<?php echo e(route('add-to-cart', $product->slug)); ?>" class="btn-add-cart-bottom">Add to Cart</a>
                    </div>

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
<?php
$trendingProducts = $product_lists->where('condition', 'trending');
?>

<?php if($trendingProducts->count() > 0): ?>
<section class="product-area most-popular section" style="padding-top:0px;">
    <div class="section-container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Trending Items</h2>

                    <div class="hot-slider-nav text-center mt-3">
                        <button class="hot-prev mx-2">&lt;</button>
                        <button class="hot-next mx-2">&gt;</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Swiper Slider -->
        <div class="swiper latest-items-swiper">
            <div class="swiper-wrapper">
                <?php $__currentLoopData = $trendingProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                $photo = explode(',', $product->photo);
                $after_discount = ($product->price - ($product->price * $product->discount) / 100);
                ?>

                <div class="swiper-slide">
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

                                <a href="<?php echo e(route('add-to-wishlist', $product->slug)); ?>" class="btn-wishlist-top"><i class="ti-heart"></i></a>
                                <a href="<?php echo e(route('add-to-cart', $product->slug)); ?>" class="btn-add-cart-bottom">Add to Cart</a>
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
            </div>

            <!-- Navigation Arrows BELOW the slider -->
            <div class="swiper-navigation text-center mt-3">
                <div class="swiper-button-prev d-inline-block me-2"></div>
                <div class="swiper-button-next d-inline-block"></div>
            </div>

        </div>

    </div>
</section>
<?php endif; ?>

<!-- Start New Items -->
<?php
$newProducts = $product_lists->where('condition', 'new');
?>

<?php if($newProducts->count() > 0): ?>
<section class="product-area most-popular section" style="padding-top:0px;">
    <div class="section-container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Latest Items</h2>
                </div>
            </div>
        </div>

        <!-- Swiper Slider -->
        <div class="swiper latest-items-swiper">
            <div class="swiper-wrapper">
                <?php $__currentLoopData = $newProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                $photo = explode(',', $product->photo);
                $after_discount = ($product->price - ($product->price * $product->discount) / 100);
                ?>

                <div class="swiper-slide">
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

                                <a href="<?php echo e(route('add-to-wishlist', $product->slug)); ?>" class="btn-wishlist-top"><i class="ti-heart"></i></a>
                                <a href="<?php echo e(route('add-to-cart', $product->slug)); ?>" class="btn-add-cart-bottom">Add to Cart</a>
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
            </div>

            <!-- Navigation Arrows BELOW the slider -->
            <div class="swiper-navigation text-center mt-3">
                <div class="swiper-button-prev d-inline-block me-2"></div>
                <div class="swiper-button-next d-inline-block"></div>
            </div>

        </div>
    </div>
</section>
<?php endif; ?>

<!-- Start Hot Items -->
<?php
$hotProducts = $product_lists->where('condition', 'hot');
?>

<?php if($hotProducts->count() > 0): ?>
<section class="product-area most-popular section" style="padding-top:0px;">
    <div class="section-container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Hot Items</h2>
                </div>
            </div>
        </div>

        <!-- Swiper Slider -->
        <div class="swiper latest-items-swiper">
            <div class="swiper-wrapper">
                <?php $__currentLoopData = $hotProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                $photo = explode(',', $product->photo);
                $after_discount = ($product->price - ($product->price * $product->discount) / 100);
                ?>

                <div class="swiper-slide">
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

                                <a href="<?php echo e(route('add-to-wishlist', $product->slug)); ?>" class="btn-wishlist-top"><i class="ti-heart"></i></a>
                                <a href="<?php echo e(route('add-to-cart', $product->slug)); ?>" class="btn-add-cart-bottom">Add to Cart</a>
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
            </div>

            <!-- Navigation Arrows BELOW the slider -->
            <div class="swiper-navigation text-center mt-3">
                <div class="swiper-button-prev d-inline-block me-2"></div>
                <div class="swiper-button-next d-inline-block"></div>
            </div>

        </div>
    </div>

</section>
<?php endif; ?>

<!-- End Shop Home List  -->

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
    document.addEventListener('DOMContentLoaded', () => {
        const filterButtons = document.querySelectorAll('.filter-tope-group .btn');
        const products = Array.from(document.querySelectorAll('.isotope-item'));
        const productsGrid = document.querySelector('.trending-products-grid');

        const filterProducts = (filterValue) => {
            let visibleCount = 0;

            products.forEach(product => {
                if (filterValue === '*' || product.classList.contains(filterValue.substring(1))) {
                    // Show only first 8 matching products
                    if (visibleCount < 8) {
                        product.style.display = 'block';
                        visibleCount++;
                    } else {
                        product.style.display = 'none';
                    }
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

        // Add click listeners
        filterButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                filterButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const filterValue = this.getAttribute('data-filter');
                filterProducts(filterValue);
            });
        });

        // Default: show first 8 products on page load
        filterProducts('*');
    });
    document.addEventListener('DOMContentLoaded', () => {
        new Swiper('.latest-items-swiper', {
            slidesPerView: 4,
            spaceBetween: 20,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                0: {
                    slidesPerView: 1.1
                },
                576: {
                    slidesPerView: 2.1
                },
                768: {
                    slidesPerView: 3.1
                },
                992: {
                    slidesPerView: 4.1
                },
            }
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