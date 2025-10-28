

<?php $__env->startSection('title', 'Checkout page'); ?>

<?php $__env->startSection('main-content'); ?>

<!-- Breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="<?php echo e(route('home')); ?>">Home<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="javascript:void(0)">Checkout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->

<!-- Start Checkout -->
<section class="shop checkout section">
    <div class="container">
        <form class="form" method="POST" action="<?php echo e(route('cart.order')); ?>">
            <?php echo csrf_field(); ?>
            <div class="row">

                <div class="col-lg-8 col-12">
                    <div class="checkout-form">
                        <h2>Make Your Checkout Here</h2>
                        <p>Please register in order to checkout more quickly</p>
                        <!-- Form -->
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Name<span>*</span></label>
                                    <input type="text" name="name" placeholder="" value="<?php echo e(old('name')); ?>">
                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class='text-danger'><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Email Address<span>*</span></label>
                                    <input type="email" name="email" placeholder="" value="<?php echo e(old('email')); ?>">
                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class='text-danger'><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Phone Number <span>*</span></label>
                                    <input type="number" name="phone" placeholder="" required value="<?php echo e(old('phone')); ?>">
                                    <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class='text-danger'><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Country<span>*</span></label>
                                    <select name="country" id="country">
                                        <option value="IND">India</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Address Line 1<span>*</span></label>
                                    <input type="text" name="address_1" placeholder="" value="<?php echo e(old('address_1')); ?>">
                                    <?php $__errorArgs = ['address_1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class='text-danger'><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Address Line 2</label>
                                    <input type="text" name="address_2" placeholder="" value="<?php echo e(old('address_2')); ?>">
                                    <?php $__errorArgs = ['address_2'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class='text-danger'><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Postal Code</label>
                                    <input type="text" name="post_code" placeholder="" value="<?php echo e(old('post_code')); ?>">
                                    <?php $__errorArgs = ['post_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class='text-danger'><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Remarks</label>
                                    <textarea name="remarks" rows="1" placeholder=""
                                        class="form-control"><?php echo e(old('remarks')); ?></textarea>
                                    <?php $__errorArgs = ['remarks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class='text-danger'><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="col-12 mt-3 text-center">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>


                            </div>


                        </div>
                        <!--/ End Form -->
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="order-details">
                        <!-- Order Widget -->
                        <div class="single-widget">
                            <h2>CART TOTALS</h2>
                            <div class="content">
                                <ul>
                                    <li class="order_subtotal" data-price="<?php echo e(Helper::totalCartPrice()); ?>">Cart
                                        Subtotal<span>₹<?php echo e(number_format(Helper::totalCartPrice(), 2)); ?></span></li>
                                    <li class="shipping">
                                        Shipping Cost
                                        <?php if(count(Helper::shipping()) > 0 && Helper::cartCount() > 0): ?>
                                        <select name="shipping" class="nice-select">
                                            <option value="">Select your address</option>
                                            <?php $__currentLoopData = Helper::shipping(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shipping): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($shipping->id); ?>" class="shippingOption"
                                                data-price="<?php echo e($shipping->price); ?>"><?php echo e($shipping->type); ?>:
                                                ₹<?php echo e($shipping->price); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php else: ?>
                                        <span>Free</span>
                                        <?php endif; ?>
                                    </li>

                                    <?php if(session('coupon')): ?>
                                    <li class="coupon_price" data-price="<?php echo e(session('coupon')['value']); ?>">You
                                        Save<span>₹<?php echo e(number_format(session('coupon')['value'], 2)); ?></span></li>
                                    <?php endif; ?>
                                    <?php
                                    $total_amount = Helper::totalCartPrice();
                                    if (session('coupon')) {
                                    $total_amount = $total_amount - session('coupon')['value'];
                                    }
                                    ?>
                                    <?php if(session('coupon')): ?>
                                    <li class="last" id="order_total_price">
                                        Total<span>₹<?php echo e(number_format($total_amount, 2)); ?></span></li>
                                    <?php else: ?>
                                    <li class="last" id="order_total_price">
                                        Total<span>₹<?php echo e(number_format($total_amount, 2)); ?></span></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<!--/ End Checkout -->
<?php $__env->stopSection(); ?>
<?php $__env->startPush('styles'); ?>
<style>
li.shipping {
    display: inline-flex;
    width: 100%;
    font-size: 14px;
}

li.shipping .input-group-icon {
    width: 100%;
    margin-left: 10px;
}

.input-group-icon .icon {
    position: absolute;
    left: 20px;
    top: 0;
    line-height: 40px;
    z-index: 3;
}

.form-select {
    height: 30px;
    width: 100%;
}

.form-select .nice-select {
    border: none;
    border-radius: 0px;
    height: 40px;
    background: #f6f6f6 !important;
    padding-left: 45px;
    padding-right: 40px;
    width: 100%;
}

.list li {
    margin-bottom: 0 !important;
}

.list li:hover {
    background: #F7941D !important;
    color: white !important;
}

.form-select .nice-select::after {
    top: 14px;
}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('frontend/js/nice-select/js/jquery.nice-select.min.js')); ?>"></script>
<script src="<?php echo e(asset('frontend/js/select2/js/select2.min.js')); ?>"></script>
<script>
$(document).ready(function() {
    $("select.select2").select2();
});
$('select.nice-select').niceSelect();
</script>
<script>
function showMe(box) {
    var checkbox = document.getElementById('shipping').style.display;
    // alert(checkbox);
    var vis = 'none';
    if (checkbox == "none") {
        vis = 'block';
    }
    if (checkbox == "block") {
        vis = "none";
    }
    document.getElementById(box).style.display = vis;
}
</script>
<script>
$(document).ready(function() {
    $('.shipping select[name=shipping]').change(function() {
        let cost = parseFloat($(this).find('option:selected').data('price')) || 0;
        let subtotal = parseFloat($('.order_subtotal').data('price'));
        let coupon = parseFloat($('.coupon_price').data('price')) || 0;
        // alert(coupon);
        $('#order_total_price span').text('$' + (subtotal + cost - coupon).toFixed(2));
    });

});
</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\benny_cards\laravel\resources\views/frontend/pages/checkout.blade.php ENDPATH**/ ?>