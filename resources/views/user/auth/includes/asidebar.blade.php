@php
    $route = request()->route()->getName();
@endphp

<div class="col-xl-3 col-lg-4">
    <div class="account-sidebar card shadow-sm border-0 p-3 mb-4">
        <nav class="nav flex-column gap-2">
            <a href="{{ route('user.profile') }}"
               class="nav-link d-flex align-items-center {{ $route == 'user.profile' ? 'active' : '' }}">
                <i class="fas fa-user me-2"></i> My Profile
            </a>
            <a href="{{ route('user.order') }}"
               class="nav-link d-flex align-items-center {{ $route == 'user.order' ? 'active' : '' }}">
                <i class="fas fa-box-open me-2"></i> My Orders
            </a>
            <a href="{{ route('user.review') }}"
               class="nav-link d-flex align-items-center {{ $route == 'user.review' ? 'active' : '' }}">
                <i class="fas fa-user-edit me-2"></i> My Reviews
            </a>
        </nav>
    </div>
</div>
