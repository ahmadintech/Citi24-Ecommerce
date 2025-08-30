@extends('layouts.shop_layout.master')
@section('content')

    <div class="sign-in-page sign-up-page section">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 col-lg-5">
                    <div class="login-wrap">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="far fa-user"></span>
                        </div>
                        <h1 class="text-center mb-4">Sign Up</h1>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form class="login-form" action="{{ route('user.register.action') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control rounded-left" placeholder="First name"
                                    name="firstname" value="{{ old('firstname') }}">
                                {{-- @error('firstname')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror --}}
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control rounded-left" placeholder="Last name"
                                    name="lastname" value="{{ old('lastname') }}">
                                {{-- @error('lastname')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror --}}
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control rounded-left" placeholder="Email" name="email"
                                    value="{{ old('email') }}">
                                {{-- @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror --}}
                            </div>
                            <div class="form-group d-flex">
                                <input type="password" class="form-control rounded-left" placeholder="Password"
                                    name="password">
                            </div>
                            <div class="form-group d-flex">
                                <input type="password" class="form-control rounded-left" placeholder="Confirm Password"
                                    name="password_confirmation">
                            </div>
                            <div class="form-group">
                                <button type="submit"
                                    class="form-control btn btn-success rounded submit px-3 p-4 fs-2">Sign
                                    Up</button>
                                {{-- <button type="submit"
                                    class="form-control btn btn-primary rounded submit px-3 primary-btn auth-btn">Sign
                                    Up</button> --}}
                            </div>
                            <hr>

                            <div class="already-have-account">
                                Already have an account?<a href="{{ route('user.login') }}"
                                    class="forget-password-link">Sign In</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('post_script')
        <script src="{{ asset('frontend/assets/js/pages/cart.js') }}"></script>
    @endpush
@endsection
