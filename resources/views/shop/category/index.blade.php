@extends('layouts.shop_layout.master')
@section('content')
    <style>
        .product-card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 15px;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .product-image-container {
            position: relative;
            padding-top: 100%;
            /* 1:1 square aspect ratio */
            overflow: hidden;
        }

        .product-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-info {
            padding: 12px;
        }

        .product-title a {
            font-size: 15px;
            font-weight: 800;
            color: #222;
            margin-bottom: 6px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 36px;
            line-height: 1.3;
        }

        .product-price {
            font-size: 14px;
            font-weight: 600;
            color: #fd9309;
            margin-bottom: 8px;
        }

        .add-to-cart-btn {
            width: 100%;
            border: none;
            background-color: #000;
            color: white;
            padding: 5px 5px;
            /* Reduced padding-x */
            border-radius: 6px;
            font-weight: 500;
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .add-to-cart-btn i {
            margin-left: 5px;
            font-size: 12px;
        }

        .wishlist-icon {
            position: absolute;
            top: 8px;
            right: 8px;
            background: rgba(255, 255, 255, 0.9);
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Mobile-specific styles */
        @media (max-width: 767.98px) {
            .product-card {
                margin-bottom: 12px;
            }

            .product-info {
                padding: 10px;
            }

            .product-title {
                font-size: 13px;
                height: 34px;
            }

            .product-price {
                font-size: 14px;
            }

            .add-to-cart-btn {
                padding: 2px 4px;
                /* Even more compact on mobile */
                font-size: 12px;
            }
        }

        .categories-section {
            padding: 60px 0;
            background-color: #f9fafb;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 28px;
            font-weight: 700;
            color: #111827;
            margin: 0;
            position: relative;
            padding-bottom: 10px;
        }

        .section-title:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #0d206c, #4257e3);
        }

        .view-all-btn {
            display: inline-flex;
            align-items: center;
            padding: 3px 20px;
            background-color: #023357;
            color: white;
            font-size: 12px;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(32, 38, 220, 0.2);
        }

        .view-all-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(11, 10, 88, 0.3);
            color: white;
            background-color: #07255e;
        }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 20px;
        }

        .category-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            text-align: center;
            padding: 25px 15px;
            position: relative;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .category-card:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #0a065d, #00b4d8);
        }

        .category-name {
            font-size: 16px;
            font-weight: 600;
            color: #374151;
            margin: 15px 0 10px;
            transition: color 0.3s ease;
        }

        .category-link {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
        }

        .category-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, rgba(32, 220, 166, 0.1), rgba(0, 180, 216, 0.1));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #20dca6;
            font-size: 20px;
            transition: all 0.3s ease;
        }

        .category-card:hover .category-icon {
            transform: scale(1.1);
            background: linear-gradient(135deg, #20dca6, #00b4d8);
            color: white;
        }

        .category-arrow {
            margin-top: 10px;
            color: #9ca3af;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .category-card:hover .category-arrow {
            color: #076b20;
            transform: translateX(3px);
        }

        @media (max-width: 767px) {
            .section-header {
                align-items: flex-end;
            }

            .section-title {
                margin-bottom: 20px;
            }

            .categories-grid {
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
                gap: 15px;
            }

            .category-card {
                padding: 20px 10px;
            }

            .category-name {
                font-size: 14px;
            }
        }
    </style>
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">{{ $category->name }}</h2>

            <div class="d-flex">
                <button class="btn btn-lg p-1" data-view="grid" title="Grid View">
                    <i class="fas fa-th-large"></i>
                </button>

                <button class="btn btn-lg p-1" data-view="list" title="List View">
                    <i class="fas fa-list"></i>
                </button>
            </div>
        </div>

        <div class="row">
            @foreach ($products as $row)
                <div class="col-lg-3 col-md-4 col-6"> <!-- Changed col-sm-6 to col-6 for consistent 2-column on mobile -->
                    <div class="product-card">
                        <div class="product-image-container">
                            <a href="{{ route('shop.product.details', ['product_name' => $row->product_name]) }}">
                                <img class="product-image"
                                    src="{{ $row->images->first()
                                        ? asset('storage/product_images/medium/' . $row->images->first()->image)
                                        : asset('no_image.png') }}"
                                    alt="{{ $row->product_name }}" loading="lazy"> <!-- Added lazy loading -->
                            </a>
                            <div class="wishlist-icon">
                                <i class="far fa-heart"></i>
                            </div>
                        </div>

                        <div class="product-info">
                            <h3 class="product-title">
                                <a href="{{ route('shop.product.details', ['product_name' => $row->product_name]) }}">
                                    {{ $row->product_name }}
                                </a>
                            </h3>

                            <div class="product-price">
                                &#8358; {{ number_format($row->price) }}
                            </div>

                            <button class="add-to-cart-btn addCart" data-product-id="{{ $row->id }}"
                                data-price="{{ $row->price }}">
                                Add to cart <i class="fas fa-plus-circle"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>



    <div class="categories-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Popular Categories</h2>
                <a href="#" class="view-all-btn">
                    View all
                </a>
            </div>

            <div class="categories-grid">
                @foreach ($categories as $category)
                    <div class="category-card">
                        <a href="{{ route('shop.category', ['name' => $category->name]) }}" class="category-link">
                            <div class="category-icon">
                                <i class="fas fa-seedling"></i> <!-- Default icon, you can customize per category -->
                            </div>
                            <h3 class="category-name">{{ $category->name }}</h3>
                            <div class="category-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


    <div class="hero-section-v2">
        <div class="hero-section-wrap">
            <div class="hero-banner-image text-center">
                <a href="#">
                    <img class="hero-image" width="100%" src="{{ asset('banner.png') }}" alt="wa" />
                </a>
            </div>
        </div>
    </div>


    <div class="featured-products-area-v2 section-bg-two section-top pb-100">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Featured Products</h2>

                <div class="d-flex">
                    <button class="btn btn-lg p-1" data-view="grid" title="Grid View">
                        <i class="fas fa-th-large"></i>
                    </button>

                    <button class="btn btn-lg p-1" data-view="list" title="List View">
                        <i class="fas fa-list"></i>
                    </button>
                </div>
            </div>


            <div class="row">
                @foreach ($featuredProducts as $row)
                    <div class="col-lg-3 col-md-4 col-6">
                        <!-- Changed col-sm-6 to col-6 for consistent 2-column on mobile -->
                        <div class="product-card">
                            <div class="product-image-container">
                                <a href="{{ route('shop.product.details', ['product_name' => $row->product_name]) }}">
                                    <img class="product-image"
                                        src="{{ $row->images->first()
                                            ? asset('storage/product_images/medium/' . $row->images->first()->image)
                                            : asset('no_image.png') }}"
                                        alt="{{ $row->product_name }}" loading="lazy"> <!-- Added lazy loading -->
                                </a>
                                <div class="wishlist-icon">
                                    <i class="far fa-heart"></i>
                                </div>
                            </div>

                            <div class="product-info">
                                <h3 class="product-title">
                                    <a href="{{ route('shop.product.details', ['product_name' => $row->product_name]) }}">
                                        {{ $row->product_name }}
                                    </a>
                                </h3>

                                <div class="product-price">
                                    &#8358; {{ number_format($row->price) }}
                                </div>

                                <button class="add-to-cart-btn addCart" data-product-id="{{ $row->id }}"
                                    data-price="{{ $row->price }}">
                                    Add to cart <i class="fas fa-plus-circle"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
