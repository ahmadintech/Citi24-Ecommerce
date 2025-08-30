@extends('layouts.shop_layout.master')
@section('content')
    <div class="sign-in-page section">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 col-lg-5">
                    <div class="login-wrap">

                        <h1 class="text-center mb-4">Forgot Password</h1>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                <ul>
                                    <li>{{ session('success') }}</li>
                                </ul>

                            </div>
                        @endif

                        <form class="login-form" method="post" action="{{ route('forget.password.post') }}">
                            @csrf
                            <div class="form-group">
                                <input type="email" class="form-control rounded-left" placeholder="Email" name="email"
                                    value="{{ old('email') }}">
                                {{-- @error('email')
                                    <span class="text-red-500" style="color: red">{{ $message }}</span>
                                @enderror --}}
                            </div>

                            <div class="form-group">
                                <button type="submit"
                                    class="form-control btn btn-primary rounded submit px-3 primary-btn auth-btn">Send
                                    Password Reset Link</button>
                            </div>
                            <hr>

                            <div class="already-have-account">
                                Do you have an account?<a href="{{ route('user.register') }}"
                                    class="forget-password-link">Login</a>
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
