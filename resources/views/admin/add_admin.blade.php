<?php
use Illuminate\Support\Facades\Session;
?>
@extends('layouts.admin_layout.admin_layout')
@section('content')
    <div class="content-wrapper">


        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Add new admin</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Admin Settings</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-6">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Add Admin</h3>
                            </div>

                            @if (session::has('error_message'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert"
                                    style="margin-top: 10px;">
                                    {{ Session::get('error_message') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            @if (session::has('Success_message'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert"
                                    style="margin-top: 10px;">
                                    {{ Session::get('Success_message') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            {{-- display form validation errors --}}
                            @if ($errors->any())
                                <div class="alert alert-danger" style="margin-top: 10px">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" method="POST" action="{{ url('/admin/add-new-admin') }}"
                                name="updateAdminDetails" enctype="multipart/form-data">@csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="current_pwd">Admin Name</label>
                                        <input type="text" class="form-control" name="name"
                                            placeholder="Enter Admin Name" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Admin Email</label>
                                        <input class="form-control" name="email" placeholder="Enter Admin Email" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Admin Mobile</label>
                                        <input class="form-control" name="phone" placeholder="Enter Admin number"
                                            required>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Default password</label>
                                        <input class="form-control" name="password" placeholder="Enter default password"
                                            required>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->

                        <!-- Form Element sizes -->

                        <!--/.col (right) -->
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>



@endsection
