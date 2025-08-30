@extends('layouts.shop_layout.master')
@section('content')
    <section class="thankyou-page-area section-top pb-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-6">
                    <div class="thankyou-content text-center">
                        <img src="{{ asset('thankyou-img.png') }}" alt="img">
                        <h2>Thanks, your accaunt has been verified!</h2>
                        <p>Click on the link below to loggin to your account or click <a href="{{ route('shop.product') }}">here</a> to shop our products.</p>
                        <a href="{{ route('user.login') }}" class="primary-btn">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
