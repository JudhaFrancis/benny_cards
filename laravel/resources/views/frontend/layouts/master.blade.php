<!DOCTYPE html>
<html lang="zxx">
<head>
	@include('frontend.layouts.head')	
 <link rel="icon" type="image/png" href="https://bennycards.com/storage/photos/1/Benny%20Round%20Logo.png">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>

    {{-- ✅ Extra page-specific CSS from @push('styles') --}}
    @stack('styles')
	
</head>
<body class="js">
	
	<!-- Preloader -->
	<div class="preloader">
		<div class="preloader-inner">
			<div class="preloader-icon">
				<span></span>
				<span></span>
			</div>
		</div>
	</div>
	<!-- End Preloader -->
	
	@include('frontend.layouts.notification')
	<!-- Header -->
	@include('frontend.layouts.header')
	<!--/ End Header -->
	@yield('main-content')
	
	@include('frontend.layouts.footer')

	 {{-- ✅ Slick Carousel JS --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    {{-- ✅ Extra scripts pushed from pages --}}
    @stack('scripts')

</body>
</html>