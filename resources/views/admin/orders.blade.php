@extends('layouts.admin_layout.admin_layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <h5><i class="fas fa-shopping-cart mr-2"></i>Orders</h5>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href=""><i class="fas fa-home"></i> Home</a></li>
                <li class="breadcrumb-item active">Orders</li>
            </ol>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            @if (session('Success_message'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle mr-1"></i> {{ session('Success_message') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped text-nowrap align-middle">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Order</th>
                                <th>User</th>
                                <th>Address</th>
                                <th>Items</th>
                                <th>Payment</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($orders as $index => $order)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>#{{ $order->id }}</strong><br>
                                        <small>{{ $order->created_at->format('d M, Y') }}</small>
                                    </td>
                                    <td>
                                        {{ $order->user->addresses->fullname ?? 'N/A' }}<br>
                                        <small>{{ $order->user->addresses->phone ?? '' }}</small>
                                    </td>
                                    <td>
                                        {{ $order->user->addresses->address ?? 'N/A' }}<br>
                                        {{ $order->user->addresses->city ?? '' }}, {{ $order->user->addresses->state ?? '' }}
                                    </td>
                                    <td>
                                        @foreach ($order->items as $item)
                                            <div class="d-flex align-items-center mb-2">

                                                <img src="{{ !empty($item->product['main_image']) ? $item->product['main_image'] : asset('no_image.png') }}"
                                                     class="img-thumbnail mr-2" width="50" height="50" alt="Product">
                                                <div>
                                                    <strong>{{ $item->product->product_name ?? 'N/A' }}</strong><br>
                                                    <small>{{ $item->qty }} x ₦{{ number_format($item->price, 2) }}</small>
                                                </div>
                                            </div>
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" class="updateOrderStatus text-{{ $order->payment_status == 'paid' ? 'success' : 'danger' }}"
                                           order_id="{{ $order->id }}" id="order-{{ $order->id }}">
                                            <i class="fas fa-money-bill-wave"></i> {{ ucfirst($order->payment_status) }}
                                        </a>
                                    </td>
                                    <td><strong>₦{{ number_format($order->grand_total, 2) }}</strong></td>
                                    <td>
                                        @php
                                            $statuses = ['1' => 'Order confirmed', '2' => 'Driver assigned', '3' => 'In transit', '4' => 'Completed'];
                                        @endphp
                                        <span class="badge badge-info">{{ $statuses[$order->track_order] ?? 'Pending' }}</span>
                                    </td>
                                    <td>
                                        <form action="{{ url('/admin/update-order-status/' . $order->id) }}" method="POST">
                                            @csrf
                                            <div class="d-flex flex-column gap-2">
                                                <select name="order_status" class="form-control form-control-sm">
                                                    @foreach ($statuses as $key => $label)
                                                        <option value="{{ $key }}" @selected($order->track_order == $key)>
                                                            {{ $label }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <button class="btn btn-sm btn-primary mt-2 w-100"><i class="fas fa-sync-alt"></i> Update</button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            @if($orders->isEmpty())
                                <tr>
                                    <td colspan="9" class="text-center text-muted">No orders available.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection
