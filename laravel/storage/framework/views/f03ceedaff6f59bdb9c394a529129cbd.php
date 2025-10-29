
<?php $__env->startSection('title', 'Cart Page'); ?>
<?php $__env->startSection('main-content'); ?>

<!-- Breadcrumbs -->
<div class="breadcrumbs">
	<div class="section-container">
		<div class="row">
			<div class="col-12">
				<div class="bread-inner">
					<ul class="bread-list">
						<li><a href="<?php echo e(route('home')); ?>">Home <i class="ti-arrow-right"></i></a></li>
						<li class="active">Shopping Cart</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Flipkart-style Cart Layout -->
<div class="shopping-cart section">
	<div class="section-container">
		<?php if(Helper::getAllProductFromCart()->count() > 0): ?>
		<div class="row">
			<!-- Cart Items -->
			<div class="col-lg-8">
				<form action="<?php echo e(route('cart.update')); ?>" method="POST">
					<?php echo csrf_field(); ?>
					<?php $__currentLoopData = Helper::getAllProductFromCart(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cart): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php $photo = explode(',', $cart->product['photo']); ?>

					<div class="cart-card shadow-sm mb-3 p-3 rounded d-flex align-items-center justify-content-between">
						<!-- Product Image -->
						<div class="cart-img me-3 flex-shrink-0">
							<img src="<?php echo e($photo[0]); ?>" class="img-fluid rounded" alt="<?php echo e($cart->product['title']); ?>" style="width: 80px; height: 80px; object-fit: cover;">
						</div>

						<!-- Product Info -->
						<div class="cart-details flex-grow-1 me-3" style="width: 50%; padding-left:15px">
							<h6 class="mb-1">
								<a href="<?php echo e(route('product-detail',$cart->product['slug'])); ?>" class="text-dark fw-bold">
									<?php echo e($cart->product['title']); ?>

								</a>
							</h6>
							<!-- <p class="small text-muted mb-1"><?php echo $cart->product['summary']; ?></p> -->
							<?php if($cart->product['discount'] > 0): ?>
							<span class="badge bg-danger"><?php echo e($cart->product['discount']); ?>% OFF</span>
							<?php endif; ?>
						</div>

						<!-- Quantity Selector -->
						<div class="input-group quantity-wrapper">
							<!-- Minus Button -->
							<button type="button" class="btn btn-outline-primary btn-number minus" data-type="minus" data-field="quant[<?php echo e($key); ?>]">
								<i class="ti-minus"></i>
							</button>

							<!-- Quantity Input -->
							<input type="text" name="quant[<?php echo e($key); ?>]" class="input-number text-center" data-min="50" data-max="100000" value="50">

							<!-- Plus Button -->
							<button type="button" class="btn btn-outline-primary btn-number plus" data-type="plus" data-field="quant[<?php echo e($key); ?>]">
								<i class="ti-plus"></i>
							</button>

							<!-- Hidden ID -->
							<input type="hidden" name="qty_id[]" value="<?php echo e($cart->id); ?>">
						</div>

						<!-- Price -->
						<div class="cart-price text-center me-3" style="min-width: 100px;">
							<strong>₹<?php echo e(number_format($cart['amount'],2)); ?></strong>
						</div>

						<!-- Remove -->
						<div class="cart-remove text-center flex-shrink-0">
							<a href="<?php echo e(route('cart-delete',$cart->id)); ?>" class="text-danger fs-5"><i class="ti-trash" style="font-size: 20px;"></i></a>
						</div>
					</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

					<!-- Update Cart Button -->
					<div class="d-flex justify-content-end mt-3">
						<button type="submit" class="btn checkout-btn px-4">Update Cart</button>
					</div>
				</form>
			</div>


			<!-- Price Details & Coupon -->
			<div class="col-lg-4">
				<div class="card shadow-sm p-3 sticky-top price-card" style="z-index:1;">
					<h5 class="mb-3 text-uppercase fw-bold">Price Details</h5>

					<!-- Coupon Section -->
					<div class="coupon-section mb-3">
						<form action="<?php echo e(route('coupon-store')); ?>" method="POST" class="d-flex">
							<?php echo csrf_field(); ?>
							<input type="text" name="code" class="form-control me-2 px-3" placeholder="Enter Coupon Code">
							<button class="btn btn-primary">Apply</button>
						</form>
					</div>

					<!-- Price Summary -->
					<div class="price-summary-section">
						<div class="d-flex justify-content-between mb-2">
							<span>Price (<?php echo e(Helper::cartCount()); ?> items)</span>
							<span>₹<?php echo e(number_format(Helper::totalCartPrice(),2)); ?></span>
						</div>
						<?php if(session()->has('coupon')): ?>
						<div class="d-flex justify-content-between mb-2 text-success">
							<span>Discount</span>
							<span>- ₹<?php echo e(number_format(Session::get('coupon')['value'],2)); ?></span>
						</div>
						<?php endif; ?>

						<?php
						$total_amount = Helper::totalCartPrice();
						if(session()->has('coupon')) $total_amount -= Session::get('coupon')['value'];
						?>

						<div class="d-flex justify-content-between fw-bold fs-5 border-top pt-2 mt-2">
							<span>Total Payable</span>
							<span>₹<?php echo e(number_format($total_amount,2)); ?></span>
						</div>
					</div>

					<!-- Buttons -->
					<div class="cart-buttons mt-3">
						<a href="<?php echo e(route('checkout')); ?>" class="btn btn-primary checkout-btn w-100 mb-2">
							<i class="ti-shopping-cart me-2"></i> Proceed to Checkout
						</a>
						<a href="<?php echo e(route('product-grids')); ?>" class="btn btn-outline-dark continue-btn w-100">
							<i class="ti-arrow-left me-2"></i> Continue Shopping
						</a>
					</div>

				</div>
			</div>

		</div>
		<?php else: ?>
		<div class="text-center py-5">
			<h5>Your cart is empty!</h5>
			<a href="<?php echo e(route('product-grids')); ?>" class="price-btn-new mt-4">Shop Now</a>
		</div>
		<?php endif; ?>
	</div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('frontend/js/nice-select/js/jquery.nice-select.min.js')); ?>"></script>
<script src="<?php echo e(asset('frontend/js/select2/js/select2.min.js')); ?>"></script>
<script>
	$(document).ready(function() {
		$("select.select2").select2();
	});
	$('select.nice-select').niceSelect();

	$(document).ready(function() {
		$('.shipping select[name=shipping]').change(function() {
			let cost = parseFloat($(this).find('option:selected').data('price')) || 0;
			let subtotal = parseFloat($('.order_subtotal').data('price'));
			let coupon = parseFloat($('.coupon_price').data('price')) || 0;
			// alert(coupon);
			$('#order_total_price span').text('$' + (subtotal + cost - coupon).toFixed(2));
		});

	});

	$(document).on('click', '.btn-number', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        var fieldName = $(this).attr('data-field');
        var type = $(this).attr('data-type');
        var input = $("input[name='" + fieldName + "']");
        var currentVal = parseFloat(input.val()) || 0;
        var step = 49;

        var min = parseFloat(input.attr('data-min')) || 50;
        var max = parseFloat(input.attr('data-max')) || 10000;

        if (type === 'minus') {
            let newVal = currentVal - step;
            if (newVal < min) newVal = min;
            input.val(newVal);
        } else if (type === 'plus') {
            let newVal = currentVal + step;
            if (newVal > max) newVal = max;
            input.val(newVal);
        }
    });

</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\benny_cards\laravel\resources\views/frontend/pages/cart.blade.php ENDPATH**/ ?>