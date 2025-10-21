<!-- Start Footer Area -->
<footer class="footer">
	<!-- Footer Top -->
	<div class="footer-top section" style="padding-bottom: 60px;">
		<div class="container">
			<div class="row">
				<div class="col-lg-5 col-md-6 col-12">
					<!-- Single Widget -->
					<div class="single-footer about">
						<div class="logo">
							<a href="index.php"><img src="<?php echo e(asset('frontend/img/benny_cards_logo.png')); ?>" alt="#"></a>
						</div>
						<?php
							$settings = DB::table('settings')->get();
						?>
						<p class="text"><?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($data->short_des); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></p>
						<p class="call">Got Question? Call us 24/7<span>
							<?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <a href="tel:<?php echo e($data->phone); ?>"><?php echo e($data->phone); ?></a>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></span></p>

					</div>
					<!-- End Single Widget -->
				</div>
				<div class="col-lg-2 col-md-6 col-12">
					<!-- Single Widget -->
					<div class="single-footer links">
						<h4>Information</h4>
						<ul>
							<li><a href="<?php echo e(route('about-us')); ?>">About Us</a></li>
							<li><a href="#">Privacy Policy</a></li>
							<li><a href="#">Terms & Conditions</a></li>
							<li><a href="<?php echo e(route('contact')); ?>">Contact Us</a></li>
							<li><a href="#">Help</a></li>
						</ul>
					</div>
					<!-- End Single Widget -->
				</div>
				<div class="col-lg-2 col-md-6 col-12">
					<!-- Single Widget -->
					<div class="single-footer links">
						<h4>Customer Service</h4>
						<ul>
							<ul>

								<li
									class="<?php if(Request::path() == 'product-grids' || Request::path() == 'product-lists'): ?> active <?php endif; ?>">
									<a href="<?php echo e(route('product-grids')); ?>">Products</a>
								</li>
								<li>
									<a href="#">Category</a>
								</li>
								<li>
									<a href="#">Gifts</a>
								</li>
								<li>
									<a href="#">Corporate</a>
								</li>
							</ul>
						</ul>
					</div>
					<!-- End Single Widget -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Single Widget -->
					<div class="single-footer social">
						<h4>Get In Touch</h4>
						<!-- Single Widget -->
						<div class="contact">
							<ul>
								<li><?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($data->address); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></li>
								<li><?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($data->email); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></li>
								<li><?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($data->phone); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></li>
							</ul>
						</div>
						<!-- End Single Widget -->
						<div class="single-footer social">
							<ul class="social-links">
								<li><a href="#" target="_blank"><i class="fa fa-facebook"></i></a></li>
								<li><a href="https://www.instagram.com/bennycards_invitations/" target="_blank"><i
											class="fa fa-instagram"></i></a></li>
							</ul>
						</div>
					</div>
					<!-- End Single Widget -->
				</div>
			</div>
		</div>
	</div>
	<!-- End Footer Top -->
	<div class="copyright">
		<div class="container">
			<div class="inner">
				<div class="row">
					<div class="col-lg-6 col-12">
						<div class="left">
							<p>Copyright © <?php echo e(date('Y')); ?> <a href="#" target="_blank">Benny Cards</a> - All Rights
								Reserved.</p>
						</div>
					</div>
					<div class="col-lg-6 col-12">
						<div class="right">
							<img src="<?php echo e(asset('frontend/img/payments.png')); ?>" alt="#">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
<!-- /End Footer Area -->

<style>
	.social-links {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
}

.social-links li a {
    display: inline-block;
    width: 32px;    
    height: 32px;
    border-radius: 50%;
    color: #fff;
    font-size: 14px; 
    line-height: 32px;  
    text-align: center;
    text-decoration: none;
}

/* Hover effect */
.social-links li a:hover {
    transform: scale(1.1);
    opacity: 0.9;
}

/* Brand colors */
.social-links li:nth-child(1) a { background: #3b5998; }   /* Facebook */
.social-links li:nth-child(2) a { background: #E4405F; }   /* Instagram */

</style>
<!-- Jquery -->
<script src="<?php echo e(asset('frontend/js/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('frontend/js/jquery-migrate-3.0.0.js')); ?>"></script>
<script src="<?php echo e(asset('frontend/js/jquery-ui.min.js')); ?>"></script>
<!-- Popper JS -->
<script src="<?php echo e(asset('frontend/js/popper.min.js')); ?>"></script>
<!-- Bootstrap JS -->
<script src="<?php echo e(asset('frontend/js/bootstrap.min.js')); ?>"></script>
<!-- Color JS -->
<script src="<?php echo e(asset('frontend/js/colors.js')); ?>"></script>
<!-- Slicknav JS -->
<script src="<?php echo e(asset('frontend/js/slicknav.min.js')); ?>"></script>
<!-- Owl Carousel JS -->
<script src="<?php echo e(asset('frontend/js/owl-carousel.js')); ?>"></script>
<!-- Magnific Popup JS -->
<script src="<?php echo e(asset('frontend/js/magnific-popup.js')); ?>"></script>
<!-- Waypoints JS -->
<script src="<?php echo e(asset('frontend/js/waypoints.min.js')); ?>"></script>
<!-- Countdown JS -->
<script src="<?php echo e(asset('frontend/js/finalcountdown.min.js')); ?>"></script>
<!-- Nice Select JS -->
<script src="<?php echo e(asset('frontend/js/nicesellect.js')); ?>"></script>
<!-- Flex Slider JS -->
<script src="<?php echo e(asset('frontend/js/flex-slider.js')); ?>"></script>
<!-- ScrollUp JS -->
<script src="<?php echo e(asset('frontend/js/scrollup.js')); ?>"></script>
<!-- Onepage Nav JS -->
<script src="<?php echo e(asset('frontend/js/onepage-nav.min.js')); ?>"></script>

<script src="<?php echo e(asset('frontend/js/isotope/isotope.pkgd.min.js')); ?>"></script>
<!-- Easing JS -->
<script src="<?php echo e(asset('frontend/js/easing.js')); ?>"></script>

<!-- Active JS -->
<script src="<?php echo e(asset('frontend/js/active.js')); ?>"></script>


<?php echo $__env->yieldPushContent('scripts'); ?>
<script>
	setTimeout(function () {
		$('.alert').slideUp();
	}, 5000);
	$(function () {
		// ------------------------------------------------------- //
		// Multi Level dropdowns
		// ------------------------------------------------------ //
		$("ul.dropdown-menu [data-toggle='dropdown']").on("click", function (event) {
			event.preventDefault();
			event.stopPropagation();

			$(this).siblings().toggleClass("show");


			if (!$(this).next().hasClass('show')) {
				$(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
			}
			$(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function (e) {
				$('.dropdown-submenu .show').removeClass("show");
			});

		});
	});
</script>

<?php /**PATH C:\xampp\htdocs\benny_cards\laravel\resources\views/frontend/layouts/footer.blade.php ENDPATH**/ ?>