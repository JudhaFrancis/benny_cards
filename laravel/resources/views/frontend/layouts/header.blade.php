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
                    <div class="right-content topbar-menu">
                        <ul class="list-main">
                            <li class="profile-wrapper">
                                <a href="javascript:void(0)" class="profile-toggle">
                                    <i class="ti-user"></i>
                                </a>

                                <div class="profile-dropdown">
                                    @auth
                                        <div class="profile-header profile-header-flex">

                                            {{-- AVATAR --}}
                                            <div class="profile-avatar-small">
                                                @if(Auth::user()->photo)
                                                    <img src="{{ Auth::user()->photo }}" alt="User Avatar">
                                                @else
                                                    <img src="https://bennycards.com/storage/photos/1/Benny%20Round%20Logo.png"
                                                        alt="Default Avatar">
                                                @endif
                                            </div>

                                            {{-- NAME + PHONE --}}
                                            <div class="profile-user-text">
                                                <strong>{{ Auth::user()->name }}</strong><br>
                                                <small>
                                                    {{ Auth::user()->phone ?? Auth::user()->mobile ?? Auth::user()->phone_no }}
                                                </small>
                                            </div>

                                        </div>

                                        <ul class="profile-menu">
                                            <li>
                                                <a href="{{ route('admin') }}">
                                                    <i class="ti-dashboard"></i> Dashboard
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ route('my.orders') }}">
                                                    <i class="ti-package"></i> Order History
                                                </a>
                                            </li>



                                            <li>
                                                <a href="{{ route('user.account') }}">
                                                    <i class="ti-user"></i> Account Info
                                                </a>
                                            </li>


                                            <li>
                                                <a href="{{ route('register.form') }}">
                                                    <i class="ti-lock"></i> Change Password
                                                </a>
                                            </li>




                                            <li class="divider"></li>

                                            <li>
                                                <a href="{{ route('user.logout') }}">
                                                    <i class="ti-power-off"></i> Logout
                                                </a>
                                            </li>
                                        </ul>
                                    @else
                                        <div class="guest-auth-box">
                                            <a href="{{ route('register.form') }}" class="btn-register">
                                                Register your account
                                            </a>

                                            <div class="or-text">OR</div>

                                            <a href="{{ route('login.form') }}" class="btn-login">
                                                Login to your account
                                            </a>
                                        </div>
                                    @endauth

                                </div>

                            </li>

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
                                        <span
                                            class="total-amount">${{number_format(Helper::totalWishlistPrice(), 2)}}</span>
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
<style>
    /* PROFILE HEADER FLEX */
    .profile-header-flex {
        display: flex;
        align-items: center;
        /* avatar center */
        gap: 12px;
        padding: 14px 16px;
    }

    /* AVATAR – SIZE CHANGE PANNA KUDADHU */
    .profile-avatar-small {
        width: 42px;
        height: 42px;
        flex-shrink: 0;
    }

    /* ADMIN AVATAR – PERFECT ROUND FIX */
    .profile-avatar-small img {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        /* FULL ROUND */
        object-fit: cover;
        /* IMAGE STRETCH AAGADHU */
        display: block;
    }

    /* TEXT CONTAINER – CENTER FIX */
    .profile-user-text {
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 42px;
    }



    /* NAME */
    .profile-user-text strong {
        font-size: 14px;
        line-height: 1.1;
        margin: 0;
    }

    /* PHONE */
    .profile-user-text small {
        font-size: 12px;
        line-height: 1.1;
        margin: 0;
        color: #666;
    }

    .profile-wrapper {
        display: flex;
        align-items: center;
        height: 100%;
            position: relative; /* 🔥 ADD THIS LINE */

    }


.profile-dropdown.show {
    display: block;
}

    .profile-toggle {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 6px 8px;
    }

    .profile-toggle i {
        font-size: 20px;
        /* wishlist/cart size */
        line-height: 1;
        color: #333;
    }


   .profile-dropdown {
    position: absolute;
    right: 0;
    top: 40px;
    width: 240px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, .15);
    display: none;
    z-index: 9999;
}

.profile-dropdown.show {
    display: block;
}


    .profile-header {
        padding: 15px;
        border-bottom: 1px solid #eee;
    }

    .profile-dropdown ul,
    .profile-dropdown .profile-menu {
        display: block !important;
    }

    .profile-dropdown ul li {
        display: block !important;
        width: 100%;
    }

    .profile-dropdown ul li a {
        display: flex !important;
        flex-direction: row;
        align-items: center;
        width: 100%;
        white-space: nowrap;
    }

    .profile-dropdown ul li a:hover {
        background: #f5f5f5;
    }

    .profile-header {
        padding: 16px 18px;
    }

    .profile-dropdown ul {
        padding: 10px 0;
    }

    .profile-dropdown ul li {
        margin-bottom: 6px;
    }

    .profile-dropdown ul li:last-child {
        margin-bottom: 0;
    }

    .profile-dropdown ul li a {
        padding: 10px 14px;
        border-radius: 8px;
        gap: 10px;
        font-size: 14px;
    }

    .profile-dropdown .divider {
        height: 1px;
        background: #eee;
        margin: 8px 0;
    }

    .guest-auth-box {
        padding: 20px;
        text-align: center;
    }

    .btn-register {
        display: block;
        background: rgba(236, 17, 118, 0.15);
        color: #ec1176;
        padding: 12px;
        border-radius: 30px;
        font-weight: 600;
        margin-bottom: 12px;
        transition: all 0.3s ease;
    }

    .btn-register:hover {
        background: rgba(236, 17, 118, 0.25);
        color: #ec1176;
    }

    .btn-login {
        display: block;
        background: #ec1176;
        color: #fff;
        padding: 12px;
        border-radius: 30px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-login:hover {
        background: #c60f62;
        color: #fff;
    }

    .or-text {
        font-size: 13px;
        margin: 8px 0 12px;
        color: #ec1176;
        font-weight: 500;
    }

    .guest-auth-box .btn-login,
    .guest-auth-box .btn-login:visited,
    .guest-auth-box .btn-login:hover,
    .guest-auth-box .btn-login:focus {
        color: #ffffff !important;
        text-decoration: none;
    }

    .or-text {
        color: #000000 !important;
        font-weight: 500;
    }

    .btn-register,
    .btn-register:visited,
    .btn-register:hover,
    .btn-register:focus {
        color: #ec1176 !important;
        text-decoration: none;
    }


   /* =========================
   MOBILE TOPBAR FIX
========================= */
@media (max-width: 576px) {

    .topbar .row {
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }

    .topbar .aligncenter {
        display: none !important;
    }

    .right-bar-1,
    .right-bar {
        flex: 0 0 auto;
        width: auto !important;
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }

    .right-bar-1 {
        margin-left: auto;
    }

    .profile-wrapper,
    .sinlge-bar {
        margin-left: 10px;
    }

    .profile-wrapper {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .profile-toggle {
        width: 36px;
        height: 40px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .profile-dropdown {
        position: fixed;        
        top: 60px;              
        right: 8px;
        left: auto;

        width: calc(100vw - 16px);
        max-width: 340px;

        z-index: 99999;
    }
}


    


    
</style>


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
<script>
document.addEventListener("DOMContentLoaded", function () {
    const profileToggle = document.querySelector(".profile-toggle");
    const profileDropdown = document.querySelector(".profile-dropdown");

    if (!profileToggle || !profileDropdown) return;

    profileToggle.addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        profileDropdown.classList.toggle("show");
    });

    document.addEventListener("click", function (e) {
        if (!e.target.closest(".profile-wrapper")) {
            profileDropdown.classList.remove("show");
        }
    });
});
</script>
