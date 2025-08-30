@extends('layouts.shop_layout.master')
@section('content')
<style>
    .profile-card {
        border-radius: 16px;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 25px;
    }

    .form-group label {
        margin-bottom: .5rem;
        display: flex;
        align-items: center;
    }

    .form-group label i {
        margin-right: 8px;
        color: #0d64a3;
        font-size: 1.2rem;
    }

    .form-control {
        border-radius: 4px;
        height: 45px;
        padding: 10px 15px;
        font-size: 1.2rem;
    }

    .form-btn {
        background-color: #0d64a3;
        color: white;
        border: none;
        padding: 7px 30px;
        margin-top: 14px;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .form-btn:hover {
        background-color: #084298;
    }

    .nav-pills .nav-link.active {
        background-color: #0d64a3;
        color: white;
        border-radius: 7px;
    }

    .nav-pills .nav-link {
        border-radius: 7px;
        font-size: 1.2rem;
    }

    .invalid-feedback {
        display: block;
    }
</style>

<div class="container py-4">
    <div class="row">
        @include('user.auth.includes.asidebar')

        <div class="col-xl-9 col-lg-8">
            <div class="profile-card">
                <ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" id="pills-profile-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-profile" type="button" role="tab">
                            <i class="fas fa-user-edit me-1"></i> Edit Profile
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="pills-password-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-password" type="button" role="tab">
                            <i class="fas fa-lock me-1"></i> Change Password
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="pills-tabContent">
                    <!-- Profile Update Tab -->
                    <div class="tab-pane fade show active" id="pills-profile" role="tabpanel">
                        <form method="POST" action="{{ route('user.edit.action') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row gy-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><i class="fas fa-user"></i> First Name</label>
                                        <input type="text" class="form-control" name="firstname" value="{{ auth()->user()->firstname }}">
                                        @error('firstname') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><i class="fas fa-user"></i> Last Name</label>
                                        <input type="text" class="form-control" name="lastname" value="{{ auth()->user()->lastname }}">
                                        @error('lastname') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><i class="fas fa-phone-alt"></i> Phone</label>
                                        <input type="text" class="form-control" name="phone" value="{{ auth()->user()->phone }}">
                                        @error('phone') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><i class="fas fa-map-marker-alt"></i> Street Address</label>
                                        <input type="text" class="form-control" name="address" value="{{ auth()->user()->addresses->address ?? '' }}">
                                        @error('address') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><i class="fas fa-city"></i> City</label>
                                        <select class="form-control" name="city">
                                            <option disabled selected>-- Select City --</option>
                                            @foreach ($shipping_price as $shipping)
                                                <option value="{{ $shipping->city }}"
                                                    {{ $shipping->city == (auth()->user()->addresses->city ?? '') ? 'selected' : '' }}>
                                                    {{ $shipping->city }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><i class="fas fa-flag"></i> State</label>
                                        <input type="text" class="form-control" name="state" value="Borno">
                                    </div>
                                </div>
                                <div class="col-12 text-center">
                                    <button class="form-btn"><i class="fas fa-save me-1"></i> Update Profile</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Password Update Tab -->
                    <div class="tab-pane fade" id="pills-password" role="tabpanel">
                        <form method="POST" action="{{ route('password.change') }}" class="mt-3">
                            @csrf
                            <div class="row gy-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><i class="fas fa-key"></i> Current Password</label>
                                        <input type="password" class="form-control" name="current_password" placeholder="Current Password">
                                        @error('current_password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><i class="fas fa-unlock-alt"></i> New Password</label>
                                        <input type="password" class="form-control" name="password" placeholder="New Password">
                                        @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><i class="fas fa-check-double"></i> Confirm Password</label>
                                        <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
                                    </div>
                                </div>
                                <div class="col-12 text-center">
                                    <button class="form-btn"><i class="fas fa-lock"></i> Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div> <!-- /.tab-content -->
            </div>
        </div>
    </div>
</div>

@push('post_script')
<script src="{{ asset('frontend/assets/js/pages/cart.js') }}"></script>
@endpush
@endsection
