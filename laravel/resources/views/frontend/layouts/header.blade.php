<header class="header shop">
    <!-- Topbar -->
    <div class="topbar">
        <div class="section-container">
            <div class="row align-items-center">
                <!-- Left Section -->
                <div class="aligncenter col-lg-6 col-md-12 col-6">
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

                <!-- Right Section -->
                <div class="right-bar-1 col-lg-4 col-md-8 col-8">
                    <div class="right-content">
                        <ul class="list-main">
                            <li><i class="ti-package"></i><a href="{{route('my.orders')}}">My Orders</a></li>
                            @auth
                                <!-- @if(Auth::user()->role == 'admin')
                                    <li><i class="ti-user"></i><a href="{{route('admin')}}" target="_blank">Dashboard</a></li>
                                @endif -->
                                <li><i class="ti-power-off"></i><a href="{{route('user.logout')}}">Logout</a></li>
                            @else
                                <li><i class="ti-power-off"></i>
                                    <a href="{{route('login.form')}}">Login</a>
                                </li>
                            @endauth
                        </ul>
                    </div>
                </div>

                <!-- Wishlist & Cart -->
                <div class="right-bar col-lg-2 col-md-4 col-4">
                    <!-- Wishlist -->
                    <div class="sinlge-bar shopping wishlist-border me-3">
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
                                            <a href="{{route('wishlist-delete', $data->id)}}" class="remove"><i
                                                    class="fa fa-remove"></i></a>
                                            <a class="cart-img" href="#"><img src="{{$photo[0]}}"
                                                    alt="{{$data->product['title']}}"></a>
                                            <h4><a href="{{route('product-detail', $data->product['slug'])}}"
                                                    target="_blank">{{$data->product['title']}}</a></h4>
                                            <p class="quantity">{{$data->quantity}} x - <span
                                                    class="amount">${{number_format($data->price, 2)}}</span></p>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="bottom">
                                    <div class="total">
                                        <span>Total</span>
                                        <span class="total-amount">${{number_format(Helper::totalWishlistPrice(), 2)}}</span>
                                    </div>
                                    <a href="{{route('cart')}}" class="btn animate">Cart</a>
                                </div>
                            </div>
                        @endauth
                    </div>

                    <!-- Cart -->
                    <div class="sinlge-bar shopping cart-border">
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
                                            <a href="{{route('cart-delete', $data->id)}}" class="remove"><i
                                                    class="fa fa-remove"></i></a>
                                            <a class="cart-img" href="#"><img src="{{$photo[0]}}"
                                                    alt="{{$data->product['title']}}"></a>
                                            <h4><a href="{{route('product-detail', $data->product['slug'])}}"
                                                    target="_blank">{{$data->product['title']}}</a></h4>
                                            <p class="quantity">{{$data->quantity}} x - <span
                                                    class="amount">${{number_format($data->price, 2)}}</span></p>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="bottom">
                                    <div class="total">
                                        <span>Total</span>
                                        <span class="total-amount">${{number_format(Helper::totalCartPrice(), 2)}}</span>
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
                <div class="row align-items-center" style="text-align-last: center;">

                    <!-- Logo -->
                    <div class="col-lg-1 col-md-3 col-3">
                        <div class="logo m-0">
                            <a href="{{route('home')}}">
                                <img src="https://bennycards.com/storage/photos/1/Benny%20Round%20Logo.png" width="100"
                                    alt="logo">
                            </a>
                        </div>
                    </div>

                    <!-- Menu -->
                    <div class="col-lg-8 col-md-6 col-2 d-none d-sm-block">
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
                                            <li
                                                class="{{ Request::is('product-grids') || Request::is('product-lists') ? 'active' : '' }}">
                                                <a href="{{ route('product-grids') }}">Products</a>
                                                <span class="new">New</span>
                                            </li>
                                            <li>{!! Helper::getHeaderCategory() !!}</li>
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
                    @php
                        $categories = DB::table('categories')
                            ->where('status', 'active')
                            ->where('is_parent', 1)
                            ->get()
                            ->toArray();
                    @endphp

                    <div class="search-bar search-wrapper col-7 col-lg-3">
                        @csrf
                        <input id="searchInput" name="search" type="search" autocomplete="off"
                            style="padding-left:12px;outline:none">
                        <span id="fakePlaceholder" class="fake-placeholder"></span>
                        <button class="btnn" type="submit"><i class="ti-search"></i></button>
                        <ul id="suggestions"
                            style="display:none;position:absolute;top:100%;left:0;right:0;background:#fff;border:1px solid #ccc;list-style:none;border-radius:8px;margin:3px 0;padding:10px 0;z-index:999;">
                        </ul>
                    </div>
                    <nav class="navbar d-block d-sm-none col-2">
                        <button class="navbar-toggler" type="button">
                            <i class="ti-menu"></i>
                        </button>

                        <div class="nav-inner" id="mainMenu">
                            <ul class="nav main-menu menu navbar-nav">
                                <li><a href="{{ route('home') }}">Home</a></li>
                                <li><a href="{{ route('about-us') }}">About Us</a></li>
                                <li><a href="{{ route('product-grids') }}">Products</a></li>
                                <li><a href="{{ route('gifts') }}">Gifts</a></li>
                                <li><a href="{{ route('corporate') }}">Corporate</a></li>
                                <li><a href="{{ route('contact') }}">Contact</a></li>
                                <li class="icon-space"><i class="fa fa-heart-o"></i><a href="{{route('wishlist')}}">View
                                        Wishlist</a></li>
                                <li class="icon-space"><i class="ti-shopping-cart"></i><a href="{{route('cart')}}">View
                                        Cart</a></li>
                                <li class="icon-space"><i class="ti-package"></i><a href="{{route('my.orders')}}">My
                                        Orders</a></li>
                                @auth
                                    @if(Auth::user()->role == 'admin')
                                        <li class="icon-space"><i class="ti-user"></i><a href="{{route('admin')}}"
                                                target="_blank">Dashboard</a></li>
                                    @endif
                                    <li class="icon-space"><i class="ti-power-off"></i><a
                                            href="{{route('user.logout')}}">Logout</a></li>
                                @else
                                    <li class="icon-space"><i class="ti-power-off"></i>
                                        <a href="{{route('login.form')}}">Login</a>
                                    </li>
                                @endauth
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggleBtn = document.querySelector(".navbar-toggler");
        const menu = document.getElementById("mainMenu");

        toggleBtn.addEventListener("click", function () {
            menu.classList.toggle("active");
            toggleBtn.classList.toggle("active");
        });

        // Close menu when clicking outside
        document.addEventListener("click", function (e) {
            if (!e.target.closest(".navbar") && menu.classList.contains("active")) {
                menu.classList.remove("active");
                toggleBtn.classList.remove("active");
            }
        });
    });

    document.addEventListener("DOMContentLoaded", () => {
        const cats = @json($categories);
        if (!cats.length) return;

        const input = document.getElementById("searchInput");
        const fake = document.getElementById("fakePlaceholder");
        const list = document.getElementById("suggestions");
        let i = 0,
            cycle;

        const update = () => {
            if (input.value) return;
            fake.classList.remove("slide-up");
            void fake.offsetWidth;
            fake.textContent = cats[i].title;
            fake.classList.add("slide-up");
            i = (i + 1) % cats.length;
        };

        const start = () => (cycle = setInterval(update, 3000), update());
        const stop = () => (clearInterval(cycle), fake.textContent = "");

        start();
        input.addEventListener("focus", stop);
        input.addEventListener("blur", () => !input.value.trim() && start());

        input.addEventListener("input", () => {
            const val = input.value.toLowerCase().trim();
            list.innerHTML = cats
                .filter(c => c.title.toLowerCase().includes(val)) // use c.title
                .map(c => `<li class="suggest-item" data-slug="${c.slug}">${c.title}</li>`)
                .join("");
            list.style.display = val && list.children.length ? "block" : "none";
        });

        list.addEventListener("click", e => {
            if (e.target.tagName === "LI") {
                const slug = e.target.getAttribute("data-slug");
                window.location.href = `/product-cat/${slug}`;
            }
        });

        document.addEventListener("click", e => {
            if (!e.target.closest(".search-bar")) list.style.display = "none";
        });
    });
</script>