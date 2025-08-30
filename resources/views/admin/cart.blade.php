<?php
use Illuminate\Support\Facades\Session;
?>
@extends('layouts.admin_layout.admin_layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Catalogues</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Cart items</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        @if (session::has('Success_message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert"
                                style="margin-top: 10px;">
                                {{ Session::get('Success_message') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Cart items</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="categories" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>IMAGE</th>
                                            <th>USER DETAILS</th>
                                            <th>PRODUCT</th>
                                            <th>AMOUNT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cart as $index => $cart)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    @if (!empty($cart->product->main_image ?? ''))
                                                        <img src="{{ !empty($cart->product['main_image']) ? $cart->product['main_image'] : asset('no_image.png') }}"
                                                            width="60px" height="60px">
                                                    @else
                                                        <img src="{{ asset('no_image.png') }}"
                                                            width="60px" height="60px">
                                                    @endif
                                                </td>
                                                <td>{{ $cart->product->product_name ?? 'No product name' }}</td>

                                                <td>
                                                    <p>
                                                        {{ $cart->addresses->fullname ?? 'Nil' }}
                                                    </p>
                                                    <p>
                                                        {{ $cart->addresses->phone ?? 'Nil' }}
                                                    </p>
                                                </td>

                                                <td>₦{{ $cart->qty * ($cart->product->price ?? '1') }} ({{ $cart->qty }}
                                                    Item{{ $cart->qty > 1 ? 's' : '' }})
                                                </td>
                                            </tr>
                                        @endforeach


                                    </tbody>

                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
