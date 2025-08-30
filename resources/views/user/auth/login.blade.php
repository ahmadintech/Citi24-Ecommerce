@extends('layouts.shop_layout.master')
@section('content')
    <div class="sign-in-page section">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 col-lg-5">
                    <div class="login-wrap">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="far fa-user"></span>
                        </div>
                        <h1 class="text-center mb-4">Sign In</h1>


                        <form class="login-form" method="post" action="{{ route('user.login.action') }}">
                            @csrf
                            <div class="form-group">
                                <input type="email" class="form-control rounded-left" placeholder="Email" name="email"
                                    value="{{ old('email') }}">
                                {{-- @error('email')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror --}}
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control rounded-left" placeholder="Password"
                                    name="password">
                                {{-- @error('password')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror --}}
                            </div>
                            <div class="form-group">
                                <button type="submit"
                                    class="form-control btn btn-success rounded submit p-4 fs-2 ">Login</button>
                                {{-- <button type="submit"
                                    class="form-control btn btn-success rounded submit px-3 primary-btn auth-btn">Login</button> --}}
                            </div>
                            <hr>
                            <div class="remember-box form-group d-md-flex justify-content-between mb-0">
                                <div>
                                    <label class="checkbox-wrap">Remember Me
                                        <input type="checkbox" name="remember">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="text-md-end text-lg-end">
                                    <a href="{{ route('forget.password.get') }}" class="forget-password-link">Forget
                                        Password?</a>
                                </div>
                            </div>
                            <div class="already-have-account">
                                Don't have an account?<a href="{{ route('user.register') }}"
                                    class="forget-password-link">Sign Up</a>
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
