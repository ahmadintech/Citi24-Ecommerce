<style>
    .mobile-bottom-nav {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 60px;
    background-color: #fff;
    border-top: 1px solid #ddd;
    display: flex;
    justify-content: space-around;
    align-items: center;
    z-index: 9999;
    box-shadow: 0 -1px 5px rgba(0, 0, 0, 0.05);
}

.mobile-bottom-nav .nav-item {
    flex: 1;
    text-align: center;
    font-size: 12px;
    color: #333;
    text-decoration: none;
    position: relative;
}

.mobile-bottom-nav .nav-item i {
    font-size: 18px;
    display: block;
    line-height: 0.5;
}

.mobile-bottom-nav .nav-item.active,
.mobile-bottom-nav .nav-item:hover {
    color: #125686;
}

.cart-count-badge-2 {
    position: absolute;
    top: 2px;
    right: 20px;
    background-color: red;
    color: white;
    width: 18px;
    height: 18px;
    font-size: 10px;
    line-height: 18px;
    text-align: center;
    border-radius: 50%;
    z-index: 10;
}

    #searchModal .form-control {
        font-size: 14px;
        border-radius: 50rem;
        padding: 7px 12px;
    }

    #searchModal .btn-close {
        font-size: 0.8rem;
    }
    #searchModal .btn {
        margin-left: 7px;
    }
</style>
<div>

    <header class="header-area-v2 d-none d-lg-block">

        <div class="header-middle" style="padding-bottom: 2%">
            <div class="header-wrap">

                <div class="header-left">
                    <a href="{{ route('shop.product') }}" class="nav-logo" style="color: black">
                        <img src="{{ asset('logo.png') }}" alt="logo" width="80" class="">
                    </a>
                </div>
                <div class="header-bottom">
                    <nav class="menu-area">

                        <ul class="main-menu">
                            <span style="background-color: #023357;">
                                <li class="nav-item">
                                    <a class="button-3" href="{{ route('shop.product') }}" role="button">Shop</a>
                                </li>

                            </span>
                            <li class="menu-item menu-item-has-children active">
                                <a class="menu-link" href="#">About</a>
                            </li>
                            <li class="menu-item mega-menu-parent">
                                <a class="menu-link" href="#">More Products <i
                                        class="arrow-icon fas fa-angle-down"></i></a>
                                <div class="mega-menu-area">
                                    <div class="container">
                                        <ul class="mega-menu">
                                            <li class="mega-menu-item">
                                                <a class="mega-menu-title" href="#">Categories</a>
                                                <ul class="menu-items">
                                                    @forelse ($categories as $category)
                                                        {{-- <li class="mega-menu-items">
                                                            <a class="mega-menu-link"
                                                                href="{{ route('shop.category', ['name' => $category->name]) }}">{{ $category->name }}</a>
                                                        </li> --}}
                                                        <li class="mega-menu-items">
                                                            <a class="mega-menu-link"
                                                                href="{{ route('shop.category', ['name' => $category->name]) }}">{{ $category->name }}</a>
                                                        </li>
                                                    @empty
                                                        <p>No category yet</p>
                                                    @endforelse
                                                </ul>
                                            </li>
                                            <li class="mega-menu-item">
                                                <a class="mega-menu-banner" href="javascript:void(0)">

                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li class="menu-item">
                                <a class="menu-link" href="{{ route('privacy_policy') }}">Policy</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="header-right">
                    <ul class="btn-list">
                        <li class="single-item cart-area">
                            <a class="single-btn cart-btn" href="{{ route('shop.cart') }}">
                                <i class="btn-icon flaticon-shopping-bag">
                                    <span style="color: red;">
                                        {{ session('cartCount', 0) }}
                                    </span>
                                </i>
                            </a>
                        </li>

                        <li class="single-item cart-area">
                            @include('layouts.shop_layout.search')
                        </li>

                        @if (auth()->user())
                            <li class="single-item user-area">
                                <div class="account-switcher">
                                    <a class="single-btn user-btn" href="javascript:void(0)"><i
                                            class="btn-icon flaticon-user"></i></a>
                                    <ul class="account-list">
                                        <li class="single-lang"><a class="lang-text"
                                                href="{{ route('user.profile') }}">Profile</a>
                                        </li>
                                        <li class="single-lang"><a class="lang-text"
                                                href="{{ route('user.logout') }}">Logout</a></li>
                                    </ul>
                                </div>
                            </li>
                        @else
                            <li class="single-item user-area">
                                <a class="single-btn user-btn" href="{{ route('user.login') }}"><i
                                        class="btn-icon flaticon-user"></i></a>
                            </li>
                        @endif

                    </ul>
                </div>
            </div>
        </div>

    </header>
</div>

<!-- Mobile Bottom Navbar -->
<nav class="mobile-bottom-nav d-lg-none">
    <a class="nav-item {{ request()->routeIs('shop.product') ? 'active' : '' }}" href="{{ route('shop.product') }}">
        <i class="flaticon-bar-chart"></i>
        <span>Home</span>
    </a>
    <!-- Search Trigger Link -->
    <a href="javascript:void(0)" class="nav-item" data-bs-toggle="modal" data-bs-target="#searchModal">
        <i class="flaticon-search"></i>
        <span>Search</span>
    </a>

    <a href="{{ route('shop.cart') }}" class="nav-item position-relative d-flex flex-column align-items-center {{ request()->routeIs('shop.cart') ? 'active' : '' }}">
    <i class="flaticon-shopping-bag" style="font-size: 20px; position: relative;"></i>
    <span class="mt-1">Cart</span>
    <span class="cart-count-badge-2" id="cart-count">{{ session('cartCount', 0) }}</span>
</a>

   <a href="{{ auth()->check() ? route('user.profile') : route('user.login') }}" class="nav-item {{ request()->routeIs('user.login') || request()->routeIs('user.profile') ? 'active' : '' }}">
    <i class="flaticon-user" style="font-size: 20px;"></i>
    <small style="margin: 0; padding: 0">{{ auth()->check() ? 'Profile' : 'Login' }}</small>
</a>
</nav>


<div>
    <div class="mobile-header-area d-block d-lg-none">
        <div class="container">
            <div class="menu-wrap">
                <div class="header-left">
                    <a class="brand-logo" href="{{ route('shop.product') }}" style="color: black">
                        <img src="{{ asset('logo.png') }}" alt="" width="70" class="">
                    </a>
                </div>
                <div class="header-right">
                    <ul class="btn-list">
                        <li class="single-item user-area">
                            <a class="single-btn user-btn" href="{{ route('user.login') }}"><i
                                    class="btn-icon flaticon-user"></i></a>
                        </li>
                    </ul>
                    <button class="menu-bar" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasMobileMenu" aria-controls="offcanvasMobileMenu">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-start menu-offcanvas" tabindex="-1" id="offcanvasMobileMenu">
    <div class="mobile-menu-area">
        <div class="offcanvas-header">
            <a class="brand-logo" href="{{ route('shop.product') }}">
                {{-- <img class="brand-image"
                    src="uploaded_files/logo/656f2f7abc3861701785466.png" alt="." /> --}}
            </a>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>

        <nav class="main-menu">
            <ul class="menu-list">
                <li class="menu-item">
                    <a class="menu-link" href="{{ route('shop.product') }}">About</a>
                </li>
                <li class="menu-item">
                    <span class="menu-expand"></span>
                    <a class="menu-link" href="#">Categories</a>
                    <ul class="sub-menu">
                        @forelse ($categories as $category)
                            {{-- <li class="sub-menu-item">
                                <a class="sub-menu-link"
                                    href="{{ route('shop.category', ['name' => $category->name]) }}">{{ $category->name }}</a>
                            </li> --}}
                            <li class="sub-menu-item">
                                <a class="sub-menu-link"
                                    href="{{ route('shop.category', ['name' => $category->name]) }}">{{ $category->name }}</a>
                            </li>
                        @empty
                            <p>No category yet</p>
                        @endforelse

                    </ul>
                </li>
                <li class="menu-item">
                    <a class="menu-link" href="{{ route('privacy_policy') }}">Policy</a>
                </li>
                <li class="menu-item">
                    <a class="menu-link" href="{{ route('faq') }}">FAQ</a>
                </li>

            </ul>
        </nav>
        <div class="menu-bottom">
            <a class="account-btn" href="{{ route('user.login') }}"><i class="user-icon flaticon-user"></i> My
                Account
            </a>
        </div>
    </div>
</div>


<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('shop.search') }}" method="get">
                <div class="modal-body">
                    <div class="input-group">
                        <input type="text" name="product" class="form-control" placeholder="Search here..." required>
                        <button class="btn btn-dark rounded-pill me-2" type="submit">
                            <i class="flaticon-search"></i> Search
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>



{{-- @include('shop.include.cart_sidebar_menu') --}}

{{-- <div id="CartDeleteFromSession" data-url="cart/delete.json"></div>
<div id="CartIncrementFromSession" data-url="cart/increase.html"></div>
<div id="CartDecrementFromSession" data-url="cart/decrease.html"></div> --}}
<div class="featured-products-area-v2 section-bg-two section-top pb-100">
