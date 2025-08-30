@extends('layouts.shop_layout.master')
@section('content')

    <style>
        /* Main Cart Container */
        .cart-page-area {
            padding: 0;
            margin: 0 auto;

        }

        .cart-header-mobile {
            padding: 1rem 1.2rem;
            background-color: #fff;
            border-bottom: 1px solid #eaeaea;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border-radius: 10px;
        }

        .cart-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
            color: #333;
        }

        .cart-subtitle {
            font-size: 1.2rem;
            color: #666;
            margin-top: 0.3rem;
        }


        /* Cart Item Card */
        .cart-card-item {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }

        .cart-card-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
        }

        .cart-card-item .card-body {
            padding: 0;
            display: flex;
            flex-direction: row;
            align-items: stretch;
            height: 150px;
        }

        /* Image Section */
        .cart-card-item .product-image-wrapper {
            width: 150px;
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
        }

        .cart-card-item .product-image-wrapper img {
            max-height: 120px;
            width: auto;
            object-fit: contain;
        }

        /* Details Section */
        .cart-card-item .product-details {
            flex: 1;
            padding: 15px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .cart-card-item .product-name {
            font-size: 1.6rem;
            font-weight: 600;
            margin-bottom: 5px;
            color: #333;
        }

        .cart-card-item .product-link {
            color: inherit;
            text-decoration: none;
        }

        .cart-card-item .product-link:hover {
            color: #104418;
        }

        .cart-card-item .price {
            font-size: 1.8rem;
            font-weight: 700;
            color: #306607;
            margin-bottom: 5px;
        }

        .cart-card-item .item-total-price {
            font-size: 1.4rem;
            color: #cd1b15;
        }

        /* Quantity Controls */
        .cart-card-item .quantity-control {
            display: flex;
            align-items: center;
            margin: 10px 0;
        }

        .cart-card-item .quantity-control .btn {
            width: 30px;
            height: 30px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-color: #dee2e6;
            background: #f8f9fa;
            color: #495057;
            font-size: 1rem;
        }

        .cart-card-item .quantity-control .btn:hover {
            background: #e9ecef;
            color: #0d6efd;
            border-color: #ced4da;
        }

        .cart-card-item .quantity-control .form-control {
            width: 40px;
            height: 30px;
            text-align: center;
            font-weight: 600;
            border-color: #dee2e6;
            margin: 0 5px;
        }

        /* Delete Button Section */
        .cart-card-item .delete-section {
            width: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
        }

        .cart-card-item .deleteItemCart {
            background: none;
            border: none;
            color: #dc3545;
            font-size: 1.2rem;
            padding: 10px;
            cursor: pointer;
            transition: color 0.2s;
        }

        .cart-card-item .deleteItemCart:hover {
            color: #a71d2a;
        }

        /* Empty Cart Message */
        .alert-info {
            background-color: #f8f9fa;
            border-color: #dee2e6;
            color: #6c757d;
            text-align: center;
            padding: 20px;
            border-radius: 8px;
        }

        /* Total Box */
        .cart-page-bottom-box {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            margin-top: 30px;
        }

        .sub-total-inner-box {
            padding-bottom: 15px;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .bottom-box-title {
            font-size: 2.2rem;
            font-weight: 600;
        }

        .cart-page-final-total {
            color: #0d6efd;
        }

        .proceed-to-checkout-btn {
            background: #0d6efd;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s;
            width: 100%;
        }

        .proceed-to-checkout-btn:hover {
            background: #0b5ed7;
            transform: translateY(-2px);
        }
    </style>

    <!-- wish-list area start here  -->
    <div class="wish-list-area cart-page-area section">
        <div class="container-fluid">
            <div class="cart-header-mobile mb-2">
                <h2 class="cart-title">🛒 Cart</h2>
                <p class="cart-subtitle">Review your selected products before checkout.</p>
            </div>

            <div class="row">
                <div class="col-12 wish-list-table">
                    <div id="cardItem">
                        <div id="cart_ajax_load">
                            @php
                                $cart = session('cart');
                                $totalCartPrice = 0;
                            @endphp

                            @if (is_array($cart) || is_object($cart))
                                <div class="row">
                                    @foreach ($cart as $item)
                                        @php
                                            $itemTotal = $item['price'] * $item['quantity'];
                                            $totalCartPrice += $itemTotal;
                                        @endphp
                                        <div class="col-12 mb-4">
                                            <div class="card cart-card-item" data-price="{{ $item['price'] }}">
                                                <div class="card-body">
                                                    <div class="product-image-wrapper">
                                                        <img class="img img-fluid rounded"
                                                            src="{{ !empty($item['main_image']) ? $item['main_image'] : asset('no_image.png') }}"
                                                            alt="{{ $item['name'] }}">
                                                    </div>
                                                    <div class="product-details">
                                                        <div>
                                                            <h4 class="product-name">
                                                                <a class="product-link"
                                                                    href="#">{{ $item['name'] }}</a>
                                                            </h4>
                                                        </div>
                                                        <div class="product-price">
                                                            <div class="price">
                                                                <span class="mainPrice">₦
                                                                    {{ number_format($item['price']) }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="quantity-control">
                                                            <button class="btn decrease-quantity-btn"
                                                                data-product-id="{{ $item['product_id'] }}"><i
                                                                    class="fas fa-minus"></i></button>
                                                            <input class="form-control text-center quantity-input"
                                                                type="text" value="{{ $item['quantity'] }}"
                                                                min="1" readonly />
                                                            <button class="btn increase-quantity-btn"
                                                                data-product-id="{{ $item['product_id'] }}"><i
                                                                    class="fas fa-plus"></i></button>
                                                        </div>

                                                        <div class="item-total-price">₦ {{ number_format($itemTotal, 2) }}
                                                        </div>
                                                    </div>
                                                    <div class="delete-section">
                                                        <button class="deleteItemCart"
                                                            data-product-id="{{ $item['product_id'] }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info">Your cart is empty</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cart Page Bottom box area Start -->
            <div class="row cart-page-bottom-box-wrap">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-4">
                    <div class="cart-page-bottom-box cart-page-sub-total-box">
                        <div class="sub-total-inner-box d-flex justify-content-between align-items-center">
                            <h2 class="bottom-box-title m-0">{{ __('Total') }}</h2>
                            <h2 class="bottom-box-title cart-page-final-total m-0" id="total-cart-price">
                                ₦ {{ number_format($totalCartPrice, 2) }}
                            </h2>
                        </div>
                        <div class="form-button text-center">
                            <a href="{{ route('checkout.index') }}"
                                class="form-btn proceed-to-checkout-btn">{{ __('Proceed To Checkout') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Cart Page Bottom box area End -->
        </div>
    </div>

@endsection
