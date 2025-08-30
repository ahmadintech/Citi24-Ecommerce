@extends('layouts.shop_layout.master')
@section('content')

    <style>
        /* App-style UI */
        .checkout-card {
            background-color: #fff;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
        }

        .checkout-title {
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 1rem;
            color: #333;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-control,
        .form-select {
            border-radius: 0.5rem;
            height: 45px;
        }

        .checkout-btn {
            background-color: #0d6efd;
            color: white;
            padding: 0.75rem 1.5rem;
            font-weight: bold;
            border-radius: 0.5rem;
            border: none;
            transition: 0.3s ease;
        }

        .checkout-btn:hover {
            background-color: #084298;
        }

        .cart-summary {
            background: #f8f9fa;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.04);
        }

        .cart-product-list {
            max-height: 300px;
            overflow-y: auto;
            margin-bottom: 1rem;
        }

        .single-cart-product {
            border-bottom: 1px solid #eee;
            padding: 0.75rem 0;
        }

        .summary-list {
            padding-left: 0;
            list-style: none;
            margin-bottom: 1rem;
        }

        .summary-list li {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
            font-weight: 500;
        }

        .total-amount h3 {
            font-size: 1.2rem;
            font-weight: bold;
            border-top: 1px solid #ccc;
            padding-top: 1rem;
            display: flex;
            justify-content: space-between;
        }

        @media (max-width: 768px) {

            .checkout-card,
            .cart-summary {
                padding: 1.5rem;
            }

            .checkout-title {
                font-size: 1.1rem;
            }
        }
    </style>

    <div class="container py-4">
        <div class="text-center mb-4">
            <h2 class="fw-bold">🛒 Checkout</h2>
        </div>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="checkout-card">
                    <form id="checkoutForm">
                        @csrf
                        @if (auth()->user())
                            <div class="mb-3">
                                <h5 class="text-success fw-bold">Hello, {{ auth()->user()->firstname }}</h5>
                            </div>
                        @else
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold">Returning buyer?</h5>
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#loginModal">Login</button>
                            </div>
                        @endif

                        <h6 class="checkout-title">Shipping Address</h6>

                        <div class="form-group">
                            <input type="text" class="form-control" name="fullname" placeholder="Your Full Name"
                                value="{{ auth()->user()->addresses->fullname ?? '' }}" required>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" name="address" placeholder="Street Address"
                                value="{{ auth()->user()->addresses->address ?? '' }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="state" placeholder="Delivery City" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select class="form-select" name="city" required>
                                        <option value="">{{ __('Select Delivery State') }}</option>
                                        @foreach ($shipping_price as $shipping_price)
                                            <option value="{{ $shipping_price->city }}"
                                                {{ $shipping_price->city == (auth()->user()->addresses->city ?? '') ? 'selected' : '' }}>
                                                {{ $shipping_price->city }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" name="phone" placeholder="Phone Number"
                                value="{{ auth()->user()->addresses->phone ?? '' }}" required>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" name="additionalPhone"
                                placeholder="Additional Phone Number"
                                value="{{ auth()->user()->addresses->additionalPhone ?? '' }}">
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="agree" required>
                            <label class="form-check-label" for="agree">
                                I agree to the
                                <a href="{{ route('terms_condition') }}" target="_blank">Terms & Conditions</a>
                            </label>
                        </div>

                        @if (!auth()->user())
                            <button type="button" class="checkout-btn w-100" data-bs-toggle="modal"
                                data-bs-target="#loginModal">Login to Place Order</button>
                        @else
                           <button type="button"
                                    class="checkout-btn w-100"
                                    onclick="initiatePaystack()">
                            Pay ₦{{ number_format($finalPrice,2) }} with Paystack
                            </button>
                        @endif
                    </form>

                </div>
            </div>


            <div class="col-lg-6">
                <div class="cart-summary">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="checkout-title mb-0">Cart Summary</h5>
                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('shop.cart') }}">Edit</a>
                    </div>

                    <ul class="cart-product-list">
                        @if (!empty($cart))
                            @foreach ($cart as $item)
                                <li class="single-cart-product">
                                    <div>
                                        <h6 class="mb-1">{{ $item['name'] }}</h6>
                                        <small>Qty: {{ $item['quantity'] }}</small>
                                    </div>
                                    <div class="text-end">
                                        <span>&#8358;{{ number_format($item['itemTotalPrice']) }}</span>
                                    </div>
                                </li>
                            @endforeach
                        @endif
                    </ul>

                    <ul class="summary-list">
                        <li>Subtotal <span>&#8358;{{ number_format($totalCartPrice, 2) }}</span></li>
                        <li>Shipping
                            <span>&#8358;{{ number_format($shippingPrice ?? 0, 2) }}</span>
                        </li>
                    </ul>

                    <div class="total-amount">
                        <h3>Total
                            <span>
                                &#8358;
                                @if (auth()->user() && !empty(auth()->user()->addresses->state))
                                    {{ number_format($finalPrice, 2) }}
                                @else
                                    {{ number_format($totalCartPrice, 2) }}
                                @endif
                            </span>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login Modal -->
    <div class="modal fade common-modal" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id>Login</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('user.login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Password">
                        </div>
                        <div class="modal-btn-wrap text-end">
                            <button type="button" class="checkout-btn" onclick="payWithPaystack()">Pay with
                                Paystack</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
