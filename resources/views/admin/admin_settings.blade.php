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
            <h1 class="m-0 text-dark">Settings</h1>
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
                  <h3 class="card-title">Update Password</h3>
                </div>

                @if (session::has('error_message'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top: 10px;">
                    {{ Session::get('error_message')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
              @endif
                @if (session::has('Success_message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 10px;">
                    {{ Session::get('Success_message')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
              @endif
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="POST" action="{{ url('/admin/update-current-pwd') }}" id="updatePasswordForm" name="updatePasswordForm">@csrf
                    <div class="card-body">
                     <?php /* <div class="form-group">
                        <label for="exampleInputEmail1">Admin Name</label>
                        <input type="text" placeholder="Enter Admin/Sub Admin Name" class="form-control" value="{{ Auth::guard('admin')->user()->name }}" id="admin_name" name="admin_name">
                      </div>*/?>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Admin Email</label>
                        <input class="form-control" readonly value="{{ Auth::guard('admin')->user()->email }}">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Admin Type</label>
                        <input class="form-control" readonly value="{{ Auth::guard('admin')->user()->type }}">
                      </div>

                    <div class="form-group">
                      <label for="current_pwd">Current Password</label>
                      <input type="password" class="form-control" id="current_pwd" name="current_pwd" placeholder="Enter Current Password" required>
                      <span id="chkCurrentPass"></span>
                    </div>

                    <div class="form-group">
                      <label for="new_pwd">New Password</label>
                      <input type="password" class="form-control" id="new_pwd" name="new_pwd" placeholder="Enter New Password" required>
                    </div>

                    <div class="form-group">
                      <label for="confirm_pwd">Confirm Password</label>
                      <input type="password" class="form-control" id="confirm_pwd" name="confirm_pwd" placeholder="Confirm Password" required>
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
