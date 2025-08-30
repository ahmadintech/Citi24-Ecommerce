@extends('layouts.shop_layout.master')

@section('content')
    <style>
        /* Mobile App Style */
        .profile-container {
            padding: 1rem;
        }

        .profile-card {
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 2.8rem;
            background: #fff;
            transition: 0.3s;
            margin-bottom: 3rem;
        }

        .profile-card h6 {
            font-weight: 600;
            color: #111;
            margin-bottom: 0.75rem;
            font-size: 1.2rem;
        }

        .profile-card ul {
            padding: 0;
            margin: 0;
            list-style: none;
            font-size: 0.95rem;
            line-height: 1.7;
        }

        .profile-card li {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.4rem;
        }

        .profile-card li i {
            color: #0d64a3;
            width: 18px;
        }

        .profile-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }

        .profile-header h5 {
            margin: 0;
            font-weight: 700;
        }

        .profile-alert {
            background-color: #fff3cd;
            color: #856404;
            border-left: 4px solid #ffc107;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            font-size: 1.2rem;
        }

        @media (max-width: 576px) {
            .profile-card {
                padding: 1rem;
            }

            .profile-header h5 {
                font-size: 1.4rem;
            }
        }
    </style>

    <div class="container profile-container">
        <div class="row g-4">
                @include('user.auth.includes.asidebar')

                <div class="col-xl-9 col-lg-8">
                <div class="profile-card">

                    {{-- Address alert --}}
                    @if (is_null(auth()->user()->addresses->address ?? null))
                        <div class="profile-alert mb-4">
                            <i class="fas fa-exclamation-circle"></i>
                            Please click on <strong>"Edit My Profile"</strong> to update your address.
                        </div>
                    @endif

                    {{-- Header --}}
                    <div class="profile-header">
                        <h5><i class="fas fa-user-circle me-1"></i>My Profile</h5>
                        <a href="{{ route('user.edit') }}" class="btn btn-outline-primary rounded-pill">
                            <i class="fas fa-edit me-1"></i> Edit My Profile
                        </a>
                    </div>

                    <div class="row g-3">

                        {{-- Personal Info --}}
                        <div class="col-12 col-sm-6 col-lg-4">
                            <div class="profile-card h-100">
                                <h6><i class="fas fa-user me-1"></i>Personal Information</h6>
                                <ul>
                                    <li><i class="fas fa-id-badge"></i> Name: {{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</li>
                                </ul>
                            </div>
                        </div>

                        {{-- Contact --}}
                        <div class="col-12 col-sm-6 col-lg-4">
                            <div class="profile-card h-100">
                                <h6><i class="fas fa-envelope me-1"></i>Contact</h6>
                                <ul>
                                    <li><i class="fas fa-envelope"></i> Email: {{ auth()->user()->email }}</li>
                                    <li><i class="fas fa-phone"></i> Phone: {{ auth()->user()->phone ?? 'Please add phone number' }}</li>
                                </ul>
                            </div>
                        </div>

                        {{-- Address --}}
                        <div class="col-12 col-lg-4">
                            <div class="profile-card h-100">
                                <h6><i class="fas fa-map-marker-alt me-1"></i>Billing Address</h6>
                                <ul>
                                    <li><i class="fas fa-home"></i> Address: {{ auth()->user()->addresses->address ?? '-' }}</li>
                                    <li><i class="fas fa-city"></i> City: {{ auth()->user()->addresses->city ?? '-' }}</li>
                                    <li><i class="fas fa-location-arrow"></i> State: {{ auth()->user()->addresses->state ?? '-' }}</li>
                                </ul>
                            </div>
                        </div>

                    </div> <!-- /.row -->
                </div> <!-- /.profile-card -->
            </div> <!-- /.col -->

        </div>
    </div>

    @push('post_script')
        <script src="{{ asset('frontend/assets/js/pages/cart.js') }}"></script>
    @endpush
@endsection
