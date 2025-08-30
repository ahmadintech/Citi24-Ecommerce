@extends('layouts.shop_layout.master')
@section('content')
    <div class="profile-page-area section">
        <div class="container">
            <div class="row">
                @include('user.auth.includes.asidebar')


                <div class="col-xl-9 col-lg-8">
                    <div class="user-profile-right-part">
                        <div class="user-profile-content-box my-reviwe-list-box">
                            <div class="d-flex justify-content-between align-items-center text-black mb-5">
                                <h2 class="user-profile-content-title">My Review</h2>
                            </div>
                            @forelse ($review as $review)
                                <div class="single-review-item bg-white d-flex align-items-center">
                                    <div class="review-left flex-shrink-0">
                                        <a href="#">
                                            <img class="product-thumbnail"
                                                src="{{ !empty($review['main_image']) ? $review['main_image'] : asset('no_image.png') }}"
                                                alt="product">
                                        </a>
                                    </div>
                                    <div class="review-right flex-grow-1">
                                        <h4 class="product-name"><a
                                                href="{{ 'product details' }}">{{ $review->product->product_name }}</a>
                                        </h4>
                                        <ul class="product-review">
                                            <li class="review-item {{ $review->rating >= 1 ? 'active' : '' }} "><i
                                                    class="flaticon-star"></i></li>
                                            <li class="review-item {{ $review->rating >= 2 ? 'active' : '' }}"><i
                                                    class="flaticon-star"></i></li>
                                            <li class="review-item {{ $review->rating >= 3 ? 'active' : '' }}"><i
                                                    class="flaticon-star"></i></li>
                                            <li class="review-item {{ $review->rating >= 4 ? 'active' : '' }}"><i
                                                    class="flaticon-star"></i></li>
                                            <li class="review-item {{ $review->rating >= 5 ? 'active' : '' }}"><i
                                                    class="flaticon-star"></i></li>
                                        </ul>
                                        <p>{{ $review->comment }}</p>
                                    </div>
                                </div>
                            @empty
                                <td colspan="4" class="text-center">
                                    <h1>No Reviwe yet!</h1>
                                </td>
                            @endforelse

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
