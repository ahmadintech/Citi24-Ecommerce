{{-- resources/views/shop/product_detail_app.blade.php --}}
@extends('layouts.shop_layout.master')
@section('content')

    <style>
        /* Modern Mobile App Styling */
        .app-container {
            max-width: 100%;
            margin: 0 auto;
            padding: 0;
            background: #f5f5f5;
            min-height: 100vh;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        /* Product Card */
        .product-card {
            background: white;
            border-radius: 0;
            box-shadow: none;
            margin-bottom: 0.5rem;
            position: relative;
        }

        .product-image {
            width: 100%;
            height: 320px;
            object-fit: cover;
            display: block;
        }

        .product-body {
            padding: 1.25rem;
        }

        .product-title {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .product-price {
            font-size: 1.6rem;
            font-weight: 700;
            color: #ff3b30;
            margin-bottom: 1rem;
        }

        .product-rating {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .rating-stars {
            color: #ffcc00;
            margin-right: 0.5rem;
            font-size: 1.1rem;
        }

        .rating-count {
            font-size: 0.9rem;
            color: #666;
        }

        .product-description {
            color: #555;
            line-height: 1.5;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 0.75rem;
            padding: 5px 7px;
        }

        .btn-primary {
            flex: 1;
            background: #07255e;
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-outline {
            flex: 1;
            background: white;
            color: #dd1c0e;
            border: 1px solid #07255e;
            padding: 1rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Sections */
        .section {
            background: white;
            margin-bottom: 0.75rem;
            padding: 1.25rem;
            border-radius: 0;
        }

        .section-header {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #333;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #eee;
        }

        /* Attributes */
        .attribute-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .attribute-item {
            background: #f5f5f7;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.9rem;
            color: #333;
        }

        /* Reviews */
        .review {
            padding: 1rem 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .review:last-child {
            border-bottom: none;
        }

        .review-meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            color: #666;
        }

        .review-content {
            color: #333;
            line-height: 1.4;
        }

        /* Related Products */
        .related-header {
            padding: 1.25rem 1.25rem 0.5rem;
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
        }

        .related-scroll {
            display: flex;
            overflow-x: auto;
            padding: 0 1rem 1rem;
            gap: 1rem;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
        }

        .related-item {
            width: 150px;
            scroll-snap-align: start;
            flex-shrink: 0;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .related-image {
            width: 100%;
            height: 120px;
            object-fit: cover;
        }

        .related-details {
            padding: 0.75rem;
        }

        .related-title {
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 0.25rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .related-price {
            font-size: 1rem;
            font-weight: 700;
            color: #ff3b30;
            margin-bottom: 0.5rem;
        }

        .related-btn {
            width: 100%;
            padding: 0.5rem;
            background: #07255e;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        /* Empty States */
        .empty-state {
            text-align: center;
            padding: 2rem;
            color: #999;
            font-size: 0.95rem;
        }

        /* Safe area for iPhone notches */
        @supports (padding: max(0px)) {
            .app-container {
                padding-left: max(0.75rem, env(safe-area-inset-left));
                padding-right: max(0.75rem, env(safe-area-inset-right));
                padding-bottom: max(5rem, env(safe-area-inset-bottom));
            }

            .action-buttons {
                padding-bottom: max(1rem, env(safe-area-inset-bottom));
            }
        }
    </style>

    <div class="app-container">

        {{-- Product Card --}}
        <div class="product-card">
            {{-- Main Image --}}
            <img id="mainProductImage" class="product-image"
                src="{{ $product->images->first()
                    ? asset('storage/product_images/medium/' . $product->images->first()->image)
                    : asset('no_image.png') }}"
                alt="{{ $product->product_name }}">

            {{-- Thumbnail Gallery --}}
            @if ($product->images->count() > 1)
                <div style="display:flex; gap:8px; padding:10px; overflow-x:auto;">
                    @foreach ($product->images as $img)
                        <img src="{{ asset('storage/product_images/small/' . $img->image) }}"
                            alt="{{ $product->product_name }}" class="thumb-img"
                            style="width:70px; height:70px; object-fit:cover; border-radius:8px; cursor:pointer;"
                            onclick="document.getElementById('mainProductImage').src=this.src;">
                    @endforeach
                </div>
            @endif

            <div class="product-body">
                <h1 class="product-title">{{ $product->product_name }}</h1>

                <div class="product-rating">
                    <div class="rating-stars">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="flaticon-star {{ $product->rating >= $i ? 'active' : '' }}"></i>
                        @endfor
                    </div>
                    <span class="rating-count">({{ $reviews->total() }} reviews)</span>
                </div>

                <div class="product-price">₦{{ number_format($product->price) }}</div>

                <p class="product-description">{{ $product->description }}</p>
            </div>

            {{-- Fixed Action Buttons --}}
            <div class="action-buttons">
                <button class="btn-outline">
                    <i class="fas fa-heart" style="margin-right: 8px;"></i> Wishlist
                </button>
                <button class="btn-primary addCart" data-product-id="{{ $product->id }}"
                    data-price="{{ $product->price }}">
                    <i class="fas fa-shopping-cart" style="margin-right: 8px;"></i> Add to Cart
                </button>
            </div>
        </div>


        {{-- Attributes --}}
        @if ($product->attributes->isNotEmpty())
            <div class="section">
                <h2 class="section-header">Options</h2>
                <div class="attribute-list">
                    @foreach ($product->attributes as $attr)
                        <span class="attribute-item">{{ $attr->name }}: {{ $attr->value }}</span>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Reviews --}}
        <div class="section">
            <h2 class="section-header">Customer Reviews</h2>

            @forelse($reviews as $r)
                <div class="review">
                    <div class="review-meta">
                        <span>{{ $r->user->firstname ?? 'Guest' }}</span>
                        <span>{{ $r->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="rating-stars">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="flaticon-star {{ $r->rating >= $i ? 'active' : '' }}"></i>
                        @endfor
                    </div>
                    <p class="review-content">{{ $r->comment }}</p>
                </div>
            @empty
                <div class="empty-state">No reviews yet. Be the first to review!</div>
            @endforelse

            {{ $reviews->links() }}
        </div>

        {{-- Related Products --}}
        <div class="related-header">You May Also Like</div>
        <div class="related-scroll">
            @foreach ($related as $rel)
                <div class="related-item">
                    <img class="related-image"
                        src="{{ optional($rel->images->first())->image
                            ? asset('storage/product_images/small/' . $rel->images->first()->image)
                            : asset('no_image.png') }}"
                        alt="{{ $rel->product_name }}">
                    <div class="related-details">
                        <div class="related-title">{{ $rel->product_name }}</div>
                        <div class="related-price">₦{{ number_format($rel->price) }}</div>
                        <button class="related-btn addCart" data-product-id="{{ $rel->id }}"
                            data-price="{{ $rel->price }}">
                            Add to Cart
                        </button>
                    </div>
                </div>
            @endforeach

        </div>



    </div>

@endsection
