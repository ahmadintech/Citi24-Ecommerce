@extends('layouts.shop_layout.master')
@section('content')

<style>
    .order-progress {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
    }

    .single-progress {
        flex: 1;
        padding: 1rem;
        text-align: center;
        background-color: #f2f2f2;
        border-radius: 8px;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .single-progress.active {
        background-color: #28a745;
        color: white;
    }

    .order-table .product-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
    }

    @media (max-width: 768px) {
        .order-table table thead {
            display: none;
        }

        .order-table table, .order-table table tbody, .order-table table tr {
            display: block;
            width: 100%;
        }

        .order-table table tr {
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            padding: 1rem;
            border-radius: 8px;
        }

        .order-table table td {
            display: flex;
            justify-content: space-between;
            padding: 0.25rem 0;
        }

        .order-table table td::before {
            content: attr(data-label);
            font-weight: bold;
            color: #555;
        }
    }
</style>

<div class="container my-4">
    <div class="card shadow-sm" style="margin-bottom: 20%">
        <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-truck-moving me-2 text-success"></i> Track My Order</h5>
            <span class="badge bg-warning">#{{ $track->order_number }}</span>
        </div>

        <div class="card-body">
            <!-- Order Progress -->
            <div class="order-progress mb-4">
                <div class="single-progress {{ $track->track_order >= 1 ? 'active' : '' }}">
                    <i class="fas fa-spinner fa-lg d-block mb-1"></i>
                    Processing
                </div>
                <div class="single-progress {{ $track->track_order >= 2 ? 'active' : '' }}">
                    <i class="fas fa-shipping-fast fa-lg d-block mb-1"></i>
                    Shipped
                </div>
                <div class="single-progress {{ $track->track_order == 4 ? 'active' : '' }}">
                    <i class="fas fa-box-open fa-lg d-block mb-1"></i>
                    Delivered
                </div>
            </div>

            <!-- Order Items -->
            <div class="order-table">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="bg-light text-uppercase small">
                            <tr>
                                <th>Product</th>
                                <th>Image</th>
                                @if ($track->track_order == 4)
                                    <th>Rating</th>
                                @endif
                                <th>Price</th>
                                <th>Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($track->items as $item)
                                <tr>
                                    <td data-label="Product">{{ $item->product->product_name ?? 'N/A' }}</td>
                                    <td data-label="Image">
                                        <img src="{{ !empty($item->product['main_image']) ? $item->product['main_image'] : asset('no_image.png') }}"
                                            alt="Product Image" class="product-img">
                                    </td>

                                    @if ($track->track_order == 4)
                                        <td data-label="Rating">
                                            @if ($item->is_rated)
                                                <button class="btn btn-sm btn-success" disabled><i class="fas fa-star me-1"></i> Reviewed</button>
                                            @else
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#writeReviewModal2" data-id="{{ $item->id }}">
                                                    <i class="fas fa-pen"></i> Review
                                                </button>
                                            @endif
                                        </td>
                                    @endif

                                    <td data-label="Price">₦{{ number_format($item->product->price ?? 0) }}</td>
                                    <td data-label="Qty">{{ $item->qty ?? 1 }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <a href="{{ route('user.order') }}" class="btn btn-outline-secondary mt-4">
                <i class="fas fa-arrow-left me-1"></i> Back to Orders
            </a>
        </div>
    </div>
</div>

<!-- Review Modal -->
<div class="modal fade" id="writeReviewModal2" tabindex="-1" aria-labelledby="reviewLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('user.review.action', ['order_id' => $track->id]) }}" class="modal-content p-4">
            @csrf
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="reviewLabel"><i class="fas fa-star-half-alt me-2 text-warning"></i>Write a Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-0">
                <div class="mb-3">
                    <label class="form-label">Rating</label>
                    <select class="form-select" name="rating" required>
                        <option value="">Select</option>
                        <option value="5">5 Stars</option>
                        <option value="4">4 Stars</option>
                        <option value="3">3 Stars</option>
                        <option value="2">2 Stars</option>
                        <option value="1">1 Star</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Comment</label>
                    <textarea class="form-control" name="comment" rows="3" required></textarea>
                </div>
                <button class="btn btn-primary w-100" type="submit">
                    <i class="fas fa-paper-plane me-1"></i> Submit Review
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
