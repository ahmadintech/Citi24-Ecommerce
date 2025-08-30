@extends('layouts.shop_layout.master')
@section('content')
    <section class="thankyou-page-area section-top pb-100 py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-6">
                    <div class="thankyou-content text-center">
                        <img src="{{ asset('thankyou-img.png') }}" alt="img">
                        <h2>Thank you for your order!</h2>
                        <p>Your order has been placed and will be processed as soon as possible. You will be receiving an
                            email shortly with confirmation of your order.</p>
                        <a href="{{ route('shop.product') }}" class="primary-btn">View our products again</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
