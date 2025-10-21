<header class="header shop">
    <!-- Topbar -->
    <div class="topbar">
        <div class="section-container">
            <div class="row align-items-center">
                <!-- Left Section -->
                <div class="aligncenter col-lg-6 col-md-12 col-12">
                    <div class="top-left">
                        <ul class="list-main">
                            @php
                            $settings = DB::table('settings')->get();
                            @endphp
                            @foreach($settings as $data)
                            <li><i class="ti-mobile"></i><a href="tel:{{$data->phone}}">{{$data->phone}}</a></li>
                            <li><i class="ti-email"></i><a href="mailto:{{$data->email}}">{{$data->email}}</a></li>
                              @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Right Section (Existing) -->
                <div class="col-lg-4 col-md-12 col-12">
                    <div class="right-content">
                        <ul class="list-main">
                            <li><i class="ti-package"></i><a href="{{route('order.track')}}">My Orders</a></li>
                            @auth
                            @if(Auth::user()->role=='admin')
                            <li><i class="ti-user"></i><a href="{{route('admin')}}" target="_blank">Dashboard</a></li>
                            @endif
                            <li><i class="ti-power-off"></i><a href="{{route('user.logout')}}">Logout</a></li>
                            @else
                            <li><i class="ti-power-off"></i><a href="{{route('login.form')}}">Login /</a> <a href="{{route('register.form')}}">Register</a></li>
                            @endauth
                        </ul>
                    </div>
                </div>

                <div class="right-bar d-flex align-items-center">
                    <!-- Wishlist -->
                    <div class="sinlge-bar shopping me-3" style="border-left: 1px solid #f0f0f0;">
                        <a href="{{route('wishlist')}}" class="single-icon">
                            <i class="fa fa-heart-o"></i>
                            <span class="total-count">{{Helper::wishlistCount()}}</span>
                        </a>
                        @auth
                        <div class="shopping-item">
                            <div class="dropdown-cart-header">
                                <span>{{count(Helper::getAllProductFromWishlist())}} Items</span>
                                <a href="{{route('wishlist')}}">View Wishlist</a>
                            </div>
                            <ul class="shopping-list">
                                @foreach(Helper::getAllProductFromWishlist() as $data)
                                @php $photo = explode(',', $data->product['photo']); @endphp
                                <li>
                                    <a href="{{route('wishlist-delete',$data->id)}}" class="remove"><i class="fa fa-remove"></i></a>
                                    <a class="cart-img" href="#"><img src="{{$photo[0]}}" alt="{{$data->product['title']}}"></a>
                                    <h4><a href="{{route('product-detail',$data->product['slug'])}}" target="_blank">{{$data->product['title']}}</a></h4>
                                    <p class="quantity">{{$data->quantity}} x - <span class="amount">${{number_format($data->price,2)}}</span></p>
                                </li>
                                @endforeach
                            </ul>
                            <div class="bottom">
                                <div class="total">
                                    <span>Total</span>
                                    <span class="total-amount">${{number_format(Helper::totalWishlistPrice(),2)}}</span>
                                </div>
                                <a href="{{route('cart')}}" class="btn animate">Cart</a>
                            </div>
                        </div>
                        @endauth
                    </div>

                    <!-- Cart -->
                    <div class="sinlge-bar shopping" style="border-left: 1px solid #f0f0f0;">
                        <a href="{{route('cart')}}" class="single-icon">
                            <i class="ti-shopping-cart"></i>
                            <span class="total-count">{{Helper::cartCount()}}</span>
                        </a>
                        @auth
                        <div class="shopping-item">
                            <div class="dropdown-cart-header">
                                <span>{{count(Helper::getAllProductFromCart())}} Items</span>
                                <a href="{{route('cart')}}">View Cart</a>
                            </div>
                            <ul class="shopping-list">
                                @foreach(Helper::getAllProductFromCart() as $data)
                                @php $photo = explode(',', $data->product['photo']); @endphp
                                <li>
                                    <a href="{{route('cart-delete',$data->id)}}" class="remove"><i class="fa fa-remove"></i></a>
                                    <a class="cart-img" href="#"><img src="{{$photo[0]}}" alt="{{$data->product['title']}}"></a>
                                    <h4><a href="{{route('product-detail',$data->product['slug'])}}" target="_blank">{{$data->product['title']}}</a></h4>
                                    <p class="quantity">{{$data->quantity}} x - <span class="amount">${{number_format($data->price,2)}}</span></p>
                                </li>
                                @endforeach
                            </ul>
                            <div class="bottom">
                                <div class="total">
                                    <span>Total</span>
                                    <span class="total-amount">${{number_format(Helper::totalCartPrice(),2)}}</span>
                                </div>
                                <a href="{{route('checkout')}}" class="btn animate">Checkout</a>
                            </div>
                        </div>
                        @endauth
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
                            @php
                            $settings = DB::table('settings')->get();
                            @endphp
                            <!-- <a href="{{route('home')}}"><img src="@foreach($settings as $data) {{$data->logo}} @endforeach" width="110" alt="logo"></a> -->
                            <a href="{{route('home')}}">
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
                                            <li class="{{ Request::is('/') ? 'active' : '' }}">
                                                <a href="{{ route('home') }}">Home</a>
                                            </li>
                                            <li class="{{ Request::is('about-us') ? 'active' : '' }}">
                                                <a href="{{ route('about-us') }}">About Us</a>
                                            </li>
                                            <li class="{{ Request::is('product-grids') || Request::is('product-lists') ? 'active' : '' }}">
                                                <a href="{{ route('product-grids') }}">Products</a>
                                                <span class="new">New</span>
                                            </li>
                                            <li>
                                                {!! Helper::getHeaderCategory() !!}
                                            </li>
                                            <li class="{{ Request::is('gifts') ? 'active' : '' }}">
                                                <a href="{{ route('gifts') }}">Gifts</a>
                                            </li>
                                            <li class="{{ Request::is('corporate') ? 'active' : '' }}">
                                                <a href="{{ route('corporate') }}">Corporate</a>
                                            </li>
                                            <li class="{{ Request::is('contact') ? 'active' : '' }}">
                                                <a href="{{ route('contact') }}">Contact Us</a>
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
                                <form method="POST" action="{{route('product.search')}}">
                                    @csrf
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
</header>