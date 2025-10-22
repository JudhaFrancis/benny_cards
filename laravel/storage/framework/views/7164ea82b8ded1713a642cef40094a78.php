

<?php $__env->startSection('title','BENNY CARDS || PRODUCT PAGE'); ?>
<?php
use App\Models\Category;
use Illuminate\Support\Facades\DB;

$categories = Category::getAllParentWithChild();
$price_ranges = DB::table('price_ranges')->where('status', 'active')->orderBy('min_price', 'ASC')->get();
$brands = DB::table('brands')->where('status', 'active')->orderBy('title', 'ASC')->get();
?>
<?php $__env->startSection('main-content'); ?>
<!-- Breadcrumbs -->
<div class="breadcrumbs">
    <div class="section-container">
        <div class="row">
            <div class="col-12" style="padding: 0px;">
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
<div class="section-container mt-5 mb-3">
    <h3 class="text-start text-uppercase">
        <?php if(request('category')): ?>
        <?php
        $catSlug = request('category');
        $cat = $allCategories->firstWhere('slug', $catSlug);
        ?>
        <?php echo e($cat ? $cat->title : $category_name); ?>

        <?php else: ?>
        <?php echo e($category_name); ?>

        <?php endif; ?>
    </h3>
</div>

<section class="product-area shop-sidebar shop">
    <div class="section-container">
        <div class="row">
            <div class="col-12" style="padding: 0px;">
                <!-- Horizontal Filter Bar -->
                <div class="d-flex flex-wrap justify-content-between align-items-center my-3">
                    <!-- Left Filters -->
                    <div class="d-flex flex-wrap gap-2">
                        <!-- Ratings Filter -->
                        <div class="dropdown">
                            <button class="btn btn-outline-dark dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                                Ratings
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?php echo e(request()->fullUrlWithQuery(['rating' => 5])); ?>">5
                                        Stars</a></li>
                                <li><a class="dropdown-item" href="<?php echo e(request()->fullUrlWithQuery(['rating' => 4])); ?>">4
                                        Stars & Up</a></li>
                                <li><a class="dropdown-item" href="<?php echo e(request()->fullUrlWithQuery(['rating' => 3])); ?>">3
                                        Stars & Up</a></li>
                            </ul>
                        </div>

                        <!-- Categories Filter -->
                        <div class="dropdown">
                            <button class="btn btn-outline-dark dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                                Categories
                            </button>
                            <ul class="dropdown-menu">
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                <li>
                                    <a class="dropdown-item"
                                        href="<?php echo e(request()->fullUrlWithQuery(['category' => $cat->slug])); ?>">
                                        <?php echo e($cat->title); ?>

                                    </a>
                                </li>

                                </li>
                                <?php if($cat->child_cat->count()): ?>
                                <?php $__currentLoopData = $cat->child_cat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a class="dropdown-item ps-4"
                                        href="<?php echo e(request()->fullUrlWithQuery(['category' => $sub->slug])); ?>">—
                                        <?php echo e($sub->title); ?></a></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>

                        <!-- Brands Filter -->
                        <div class="dropdown">
                            <button class="btn btn-outline-dark dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                                Brands
                            </button>
                            <ul class="dropdown-menu">
                                <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a class="dropdown-item"
                                        href="<?php echo e(request()->fullUrlWithQuery(['brand' => $brand->slug])); ?>">
                                        <?php echo e($brand->title); ?>

                                    </a>
                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>

                        <!-- Price Filter -->
                        <div class="dropdown">
                            <button class="btn btn-outline-dark dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                                Price
                            </button>
                            <ul class="dropdown-menu">
                                <?php $__currentLoopData = $price_ranges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $range): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                <li><a class="dropdown-item"
                                        href="<?php echo e(request()->fullUrlWithQuery(['price_range' => $range->slug])); ?>">
                                        <?php echo e($range->title); ?>

                                    </a></li>

                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Right: Sort by -->
                    <div class="dropdown">
                        <button class="btn btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Sort by
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo e(route('product-grids', ['sort' => 'default'])); ?>">
                                    Default sorting
                                </a>
                            </li>
                            <li><a class="dropdown-item" href="<?php echo e(route('product-grids', ['sortBy' => 'price_asc'])); ?>">
                                    Price: Low to High
                                </a></li>

                            <li><a class="dropdown-item"
                                    href="<?php echo e(route('product-grids', ['sortBy' => 'price_desc'])); ?>">
                                    Price: High to Low
                                </a></li>
                            <li><a class="dropdown-item" href="<?php echo e(route('product-grids', ['sortBy' => 'latest'])); ?>">
                                    Newest
                                </a></li>
                            <li><a class="dropdown-item" href="<?php echo e(route('product-grids', ['sortBy' => 'trending'])); ?>">
                                    Trending
                                </a></li>
                        </ul>
                    </div>
                    <?php
                    // Flatten categories + child categories to find titles by slug
                    $allCategories = collect();
                    foreach ($categories as $cat) {
                    $allCategories->push($cat);
                    if ($cat->child_cat->count()) {
                    $allCategories = $allCategories->merge($cat->child_cat);
                    }
                    }

                    $selectedFilters = [];

                    // Get selected category title
                    if ($categorySlug = request('category')) {
                    $cat = $allCategories->firstWhere('slug', $categorySlug);
                    if ($cat) {
                    $selectedFilters['category'] = [
                    'slug' => $categorySlug,
                    'title' => $cat->title,
                    ];
                    }
                    }

                    // Get selected brand title
                    if ($brandSlug = request('brand')) {
                    $brand = $brands->firstWhere('slug', $brandSlug);
                    if ($brand) {
                    $selectedFilters['brand'] = [
                    'slug' => $brandSlug,
                    'title' => $brand->title,
                    ];
                    }
                    }

                    // Get selected price range title
                    if ($priceSlug = request('price_range')) {
                    $price = $price_ranges->firstWhere('slug', $priceSlug);
                    if ($price) {
                    $selectedFilters['price_range'] = [
                    'slug' => $priceSlug,
                    'title' => $price->title,
                    ];
                    }
                    }

                    // Get rating (just display the number, you can customize text)
                    if ($rating = request('rating')) {
                    $selectedFilters['rating'] = [
                    'slug' => $rating,
                    'title' => "{$rating} Stars & Up",
                    ];
                    }

                    // Sort filter (optional, show name)
                    if ($sort = request('sort')) {
                    $sortTitles = [
                    'default' => 'Default sorting',
                    'price_asc' => 'Price: Low to High',
                    'price_desc' => 'Price: High to Low',
                    'latest' => 'Newest',
                    ];
                    $selectedFilters['sort'] = [
                    'slug' => $sort,
                    'title' => $sortTitles[$sort] ?? $sort,
                    ];
                    }
                    ?>

                    <?php if(count($selectedFilters) > 0): ?>
                    <div class="w-100 mt-2 d-flex align-items-center gap-2 flex-wrap">
                        <a href="<?php echo e(route('product-grids')); ?>" class="clear_filter small">
                            ✕ Clear All Filters
                        </a>

                        <?php $__currentLoopData = $selectedFilters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filterKey => $filter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        // Prepare URL that removes only this filter
                        $query = request()->query();
                        unset($query[$filterKey]);
                        $urlWithoutFilter = url()->current() . (count($query) ? '?' . http_build_query($query) : '');
                        ?>
                        <span class="badge small d-flex align-items-center gap-1">
                            <?php echo e($filter['title']); ?>

                            <a href="<?php echo e($urlWithoutFilter); ?>" class="text-decoration-none fw-bold"
                                style="line-height:1;">&times;</a>
                        </span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php endif; ?>

                </div>
            </div>

            <!-- Products Section -->
            <div class="col-lg-12 col-md-8 col-12 section" style="padding-top: 40px;">
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

                                <!-- Badges -->
                                <?php if($product->stock <= 0): ?> <span class="badge out-of-stock">Sold Out</span>
                                    <?php elseif($product->condition == 'new'): ?>
                                    <span class="badge new">New</span>
                                    <?php elseif($product->condition == 'hot'): ?>
                                    <span class="badge hot">Hot</span>
                                    <?php elseif($product->condition == 'trending'): ?>
                                    <span class="badge trending">Trending</span>
                                    <?php endif; ?>

                                    <!-- Wishlist & Add to Cart -->
                                    <a href="<?php echo e(route('add-to-wishlist', $product->slug)); ?>" class="btn-wishlist-top">
                                        <i class="ti-heart"></i>
                                    </a>
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
                                    <span
                                        class="current-price fw-bold text-dark">₹<?php echo e(number_format($after_discount, 2)); ?></span>

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

                <!-- Pagination -->
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-center">
                        <?php echo e($products->appends(request()->query())->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


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