@extends('layouts.shop_layout.master')
@section('content')
    <style>
        /* Mobile-App Style Order Page */
        .section {
            background-color: #f5f5f5;
            min-height: 100vh;
        }

        .nav-pills .nav-link {
            border-radius: 30px;
            padding: 10px 20px;
            font-weight: 500;
            display: flex;
            align-items: center;
            color: #023357;
            transition: background-color 0.3s ease;
        }

        .nav-pills .nav-link i {
            font-size: 14px;
        }

        .nav-pills .nav-link.active {
            background-color: #023357;
            color: white;
        }

        .card {
            border-radius: 12px;
            border: none;
            background-color: #ffffff;
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: scale(1.01);
        }

        .card-body {
            padding: 1.25rem;
        }

        .card h6 {
            font-size: 16px;
            font-weight: 600;
        }

        .card small {
            font-size: 12px;
            color: #6c757d;
        }

        .card img {
            border-radius: 8px;
        }

        .card .fw-bold {
            font-size: 16px;
        }

        .btn-outline-primary,
        .btn-outline-success {
            border-radius: 30px;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            transition: background-color 0.3s ease, color 0.3s ease;
            border-color: #023357;
            color: #023357;
        }

        .btn-outline-primary i,
        .btn-outline-success i {
            font-size: 14px;
        }

        .text-muted {
            color: #888 !important;
        }

        @media (max-width: 768px) {
            .nav-pills {
                flex-wrap: nowrap;
                overflow-x: auto;
                white-space: nowrap;
                -webkit-overflow-scrolling: touch;
            }

            .nav-pills .nav-item {
                flex-shrink: 0;
                margin-right: 8px;
            }

            .d-flex.flex-md-row {
                flex-direction: column !important;
            }

            .d-flex.align-items-center {
                flex-direction: column;
                text-align: center;
            }

            .d-flex.align-items-center img {
                margin-bottom: 10px;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
    <div class="section py-4">
        <div class="container">
            <div class="row g-4">
                @include('user.auth.includes.asidebar')

                <div class="col-xl-9 col-lg-8">
                    <div class="bg-white p-3 rounded shadow-sm">
                        <ul class="nav nav-pills mb-3" id="orderTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="active-tab" data-bs-toggle="pill"
                                    data-bs-target="#active-orders" type="button" role="tab">
                                    <i class="fas fa-shopping-bag me-1"></i> Active
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="delivered-tab" data-bs-toggle="pill"
                                    data-bs-target="#delivered-orders" type="button" role="tab">
                                    <i class="fas fa-box-open me-1"></i> Delivered
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="cancelled-tab" data-bs-toggle="pill"
                                    data-bs-target="#cancelled-orders" type="button" role="tab">
                                    <i class="fas fa-times-circle me-1"></i> Cancelled
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content mt-4" id="orderTabsContent">

                            {{-- ACTIVE ORDERS --}}
                            <div class="tab-pane fade show active" id="active-orders" role="tabpanel">
                                @forelse($pending_order as $order)
                                    <div class="card mb-3 shadow-sm border-0">
                                        <div class="card-body">
                                            <div class="d-flex flex-column flex-md-row justify-content-between mb-3">
                                                <div>
                                                    <h6 class="mb-1">Order #{{ $order->order_number }}</h6>
                                                    <small class="text-muted">
                                                        Placed: {{ $order->created_at->format('M d, Y h:i A') }}
                                                    </small>
                                                </div>
                                                <a href="{{ route('user.track', ['order_id' => $order->order_number]) }}"
                                                    class="btn btn-outline-primary mt-2 mt-md-0 px-3 py-3 align-items-center justify-content-center">
                                                    <i class="fas fa-map-marker-alt me-1"></i> Track
                                                </a>
                                            </div>

                                            @if ($order->items->count())
                                                @foreach ($order->items as $item)
                                                    @php
                                                        $product = $item->product;
                                                    @endphp

                                                    @if ($product)
                                                        <div class="d-flex align-items-center mb-3">
                                                            <img src="{{ !empty($product['main_image']) ? $product['main_image'] : asset('no_image.png') }}"
                                                                class="rounded me-3"
                                                                style="width:60px;height:60px;object-fit:cover;"
                                                                alt="{{ $product->product_name }}">
                                                            <div class="flex-grow-1">
                                                                <h6 class="mb-1">{{ $product->product_name }}</h6>
                                                                <div class="text-muted">Qty: {{ $item->qty }}</div>
                                                                <div class="fw-bold text-dark">
                                                                    ₦{{ number_format($item->qty * $product->price) }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <p class="text-muted">Product not found for one of the items.</p>
                                                    @endif
                                                @endforeach
                                            @else
                                                <p class="text-muted">No items found in this order.</p>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-5">
                                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No active orders.</p>
                                    </div>
                                @endforelse

                                {{-- paginate --}}
                                <div class="d-flex justify-content-center">
                                    {{ $pending_order->links() }}
                                </div>
                            </div>

                            {{-- DELIVERED ORDERS --}}
                            <div class="tab-pane fade" id="delivered-orders" role="tabpanel">
                                @forelse($completed_order as $order)
                                    @php
                                        $firstItem = $order->items->first();
                                        $product = $firstItem?->product;
                                    @endphp
                                    <div class="card mb-3 shadow-sm border-0">
                                        <div class="card-body">
                                            <div class="d-flex flex-column flex-md-row justify-content-between mb-3">
                                                <div>
                                                    <h6 class="mb-1">Order #{{ $order->order_number }}</h6>
                                                    <small class="text-muted">
                                                        Delivered: {{ $order->updated_at->format('M d, Y h:i A') }}
                                                    </small>
                                                </div>
                                                <a href="{{ route('user.track', ['order_id' => $order->order_number]) }}"
                                                    class="btn btn-sm btn-outline-success mt-2 mt-md-0">
                                                    <i class="fas fa-star me-1"></i> Review
                                                </a>
                                            </div>

                                            @if ($product)
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ !empty($product['main_image']) ? $product['main_image'] : asset('no_image.png') }}"
                                                        class="rounded me-3"
                                                        style="width:60px;height:60px;object-fit:cover;"
                                                        alt="{{ $product->product_name }}">
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">{{ $product->product_name }}</h6>
                                                        <div class="fw-bold text-dark">
                                                            ₦{{ number_format($firstItem->qty * $product->price) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <p class="text-muted">No items found in this order.</p>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-5">
                                        <i class="fas fa-check-circle fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No delivered orders.</p>
                                    </div>
                                @endforelse

                                <div class="d-flex justify-content-center">
                                    {{ $completed_order->links() }}
                                </div>
                            </div>

                            {{-- CANCELLED ORDERS --}}
                            <div class="tab-pane fade text-center py-5" id="cancelled-orders" role="tabpanel">
                                <i class="fas fa-times-circle fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No cancelled orders found.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('post_script')
        <script src="{{ asset('frontend/assets/js/pages/cart.js') }}"></script>
    @endpush
@endsection
