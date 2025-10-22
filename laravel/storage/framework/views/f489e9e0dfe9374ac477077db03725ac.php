<header class="header shop">
    <!-- Topbar -->
    <div class="topbar">
        <div class="section-container">
            <div class="row align-items-center" style="flex-wrap: nowrap;">
                <!-- Left Section -->
                <div class="aligncenter col-lg-6 col-md-6 col-6">
                    <div class="top-left">
                        <ul class="list-main">
                            <?php
                            $settings = DB::table('settings')->get();
                            ?>
                            <?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><i class="ti-mobile"></i><a href="tel:<?php echo e($data->phone); ?>"><?php echo e($data->phone); ?></a></li>
                            <li><i class="ti-email"></i><a href="mailto:<?php echo e($data->email); ?>"><?php echo e($data->email); ?></a></li>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>

                <!-- Right Section (Existing) -->
                <div class="col-lg-4 col-md-4 col-4">
                    <div class="right-content">
                        <ul class="list-main">
                            <li><i class="ti-package"></i><a href="<?php echo e(route('order.track')); ?>">My Orders</a></li>
                            <?php if(auth()->guard()->check()): ?>
                            <?php if(Auth::user()->role=='admin'): ?>
                            <li><i class="ti-user"></i><a href="<?php echo e(route('admin')); ?>" target="_blank">Dashboard</a></li>
                            <?php endif; ?>
                            <li><i class="ti-power-off"></i><a href="<?php echo e(route('user.logout')); ?>">Logout</a></li>
                            <?php else: ?>
                            <li><i class="ti-power-off"></i><a href="<?php echo e(route('login.form')); ?>">Login /</a> <a href="<?php echo e(route('register.form')); ?>">Register</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>

                <div class="right-bar d-flex align-items-center">
                    <!-- Wishlist -->
                    <div class="sinlge-bar shopping me-3" style="border-left: 1px solid #f0f0f0;">
                        <a href="<?php echo e(route('wishlist')); ?>" class="single-icon">
                            <i class="fa fa-heart-o"></i>
                            <span class="total-count"><?php echo e(Helper::wishlistCount()); ?></span>
                        </a>
                        <?php if(auth()->guard()->check()): ?>
                        <div class="shopping-item">
                            <div class="dropdown-cart-header">
                                <span><?php echo e(count(Helper::getAllProductFromWishlist())); ?> Items</span>
                                <a href="<?php echo e(route('wishlist')); ?>">View Wishlist</a>
                            </div>
                            <ul class="shopping-list">
                                <?php $__currentLoopData = Helper::getAllProductFromWishlist(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $photo = explode(',', $data->product['photo']); ?>
                                <li>
                                    <a href="<?php echo e(route('wishlist-delete',$data->id)); ?>" class="remove"><i class="fa fa-remove"></i></a>
                                    <a class="cart-img" href="#"><img src="<?php echo e($photo[0]); ?>" alt="<?php echo e($data->product['title']); ?>"></a>
                                    <h4><a href="<?php echo e(route('product-detail',$data->product['slug'])); ?>" target="_blank"><?php echo e($data->product['title']); ?></a></h4>
                                    <p class="quantity"><?php echo e($data->quantity); ?> x - <span class="amount">$<?php echo e(number_format($data->price,2)); ?></span></p>
                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <div class="bottom">
                                <div class="total">
                                    <span>Total</span>
                                    <span class="total-amount">$<?php echo e(number_format(Helper::totalWishlistPrice(),2)); ?></span>
                                </div>
                                <a href="<?php echo e(route('cart')); ?>" class="btn animate">Cart</a>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Cart -->
                    <div class="sinlge-bar shopping" style="border-left: 1px solid #f0f0f0;">
                        <a href="<?php echo e(route('cart')); ?>" class="single-icon">
                            <i class="ti-shopping-cart"></i>
                            <span class="total-count"><?php echo e(Helper::cartCount()); ?></span>
                        </a>
                        <?php if(auth()->guard()->check()): ?>
                        <div class="shopping-item">
                            <div class="dropdown-cart-header">
                                <span><?php echo e(count(Helper::getAllProductFromCart())); ?> Items</span>
                                <a href="<?php echo e(route('cart')); ?>">View Cart</a>
                            </div>
                            <ul class="shopping-list">
                                <?php $__currentLoopData = Helper::getAllProductFromCart(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $photo = explode(',', $data->product['photo']); ?>
                                <li>
                                    <a href="<?php echo e(route('cart-delete',$data->id)); ?>" class="remove"><i class="fa fa-remove"></i></a>
                                    <a class="cart-img" href="#"><img src="<?php echo e($photo[0]); ?>" alt="<?php echo e($data->product['title']); ?>"></a>
                                    <h4><a href="<?php echo e(route('product-detail',$data->product['slug'])); ?>" target="_blank"><?php echo e($data->product['title']); ?></a></h4>
                                    <p class="quantity"><?php echo e($data->quantity); ?> x - <span class="amount">$<?php echo e(number_format($data->price,2)); ?></span></p>
                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <div class="bottom">
                                <div class="total">
                                    <span>Total</span>
                                    <span class="total-amount">$<?php echo e(number_format(Helper::totalCartPrice(),2)); ?></span>
                                </div>
                                <a href="<?php echo e(route('checkout')); ?>" class="btn animate">Checkout</a>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Topbar -->

    <!-- Header Inner -->
    <div class="header-inner">
        <div class="container">
            <div class="cat-nav-head">
                <div class="row align-items-center">
                    <!-- Logo -->
                    <div class="col-lg-1 col-md-3 col-12">
                        <div class="logo m-0">
                            <?php
                            $settings = DB::table('settings')->get();
                            ?>
                            <!-- <a href="<?php echo e(route('home')); ?>"><img src="<?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($data->logo); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>" width="110" alt="logo"></a> -->
                            <a href="<?php echo e(route('home')); ?>">
                                <img src="https://bennycards.com/storage/photos/1/Benny%20Round%20Logo.png" width="100" alt="logo">
                            </a>
                        </div>
                    </div>

                    <!-- Menu -->
                    <div class="col-lg-8 col-md-6 col-12">
                        <div class="menu-area">
                            <nav class="navbar navbar-expand-lg">
                                <div class="navbar-collapse">
                                    <div class="nav-inner">
                                        <ul class="nav main-menu menu navbar-nav">
                                            <li class="<?php echo e(Request::is('/') ? 'active' : ''); ?>">
                                                <a href="<?php echo e(route('home')); ?>">Home</a>
                                            </li>
                                            <li class="<?php echo e(Request::is('about-us') ? 'active' : ''); ?>">
                                                <a href="<?php echo e(route('about-us')); ?>">About Us</a>
                                            </li>
                                            <li class="<?php echo e(Request::is('product-grids') || Request::is('product-lists') ? 'active' : ''); ?>">
                                                <a href="<?php echo e(route('product-grids')); ?>">Products</a>
                                                <span class="new">New</span>
                                            </li>
                                            <li>
                                                <?php echo Helper::getHeaderCategory(); ?>

                                            </li>
                                            <li class="<?php echo e(Request::is('gifts') ? 'active' : ''); ?>">
                                                <a href="<?php echo e(route('gifts')); ?>">Gifts</a>
                                            </li>
                                            <li class="<?php echo e(Request::is('corporate') ? 'active' : ''); ?>">
                                                <a href="<?php echo e(route('corporate')); ?>">Corporate</a>
                                            </li>
                                            <li class="<?php echo e(Request::is('contact') ? 'active' : ''); ?>">
                                                <a href="<?php echo e(route('contact')); ?>">Contact Us</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>

                    <!-- Search Bar -->
                    <div class="col-lg-3 col-md-3 col-12">
                        <div class="search-bar-top">
                            <div class="search-bar">
                                <form method="POST" action="<?php echo e(route('product.search')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <input name="search" placeholder="Search Products Here....." type="search">
                                    <button class="btnn" type="submit"><i class="ti-search"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--/ End Header Inner -->
</header><?php /**PATH C:\xampp\htdocs\benny_cards\laravel\resources\views/frontend/layouts/header.blade.php ENDPATH**/ ?>