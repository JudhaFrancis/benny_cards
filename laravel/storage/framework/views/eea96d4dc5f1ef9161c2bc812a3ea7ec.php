

<?php $__env->startSection('title','BENNY CARDS || About Us'); ?>

<?php $__env->startSection('main-content'); ?>

	<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="section-container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="index1.html">Home<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="blog-single.html">About Us</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->

	<!-- About Us -->
	<section class="about-us section">
			<div class="section-container">
				<div class="row">
					<div class="col-lg-6 col-12">
						<div class="about-content">
							<?php
								$settings=DB::table('settings')->get();
							?>
							<h3>Welcome To <span>Eshop</span></h3>
							<p><?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($data->description); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></p>
							<div class="button">
								<a href="<?php echo e(route('product-grids')); ?>" class="btn">Our Now</a>
								<a href="<?php echo e(route('contact')); ?>" class="btn primary">Contact Us</a>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-12">
						<div class="about-img overlay">
							
							<img src="<?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($data->photo); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>" alt="<?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($data->photo); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>">
						</div>
					</div>
				</div>
			</div>
	</section>
	<!-- End About Us -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\benny_cards\laravel\resources\views/frontend/pages/about-us.blade.php ENDPATH**/ ?>