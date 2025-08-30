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
                            <li class="breadcrumb-item active">Categories</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <form name="categoryform" id="categoryForm"
                @if (empty($categoryData['id'])) action="{{ url('admin/add-edit-category') }}"
      @else action="{{ url('admin/add-edit-category/' . $categoryData['id']) }}" @endif
                method="post" enctype="multipart/form-data">@csrf
                <div class="container-fluid">
                    {{-- display form validation errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top: 10px">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if (session::has('flash_message_success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert"
                            style="margin-top: 10px;">
                            {{ Session::get('flash_message_success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">{{ $title }}</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                        class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Category Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Enter Category Name"
                                            @if (!empty($categoryData['name'])) value=" {{ $categoryData['name'] }}" @endif>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        <label for="category_image">Category Image</label>
                                        <input type="file" class="form-control" id="category_image"
                                                    name="category_image">
                                        @if (!empty($categoryData['category_image']))
                                            <img src=" {{ asset('storage/category_images/' . $categoryData['category_image']) }} "style="margin-top:1%;"
                                                height="100px" width="100px">
                                            &nbsp; <a class="confirmDelete" record="category-image"
                                                recordid="{{ $categoryData->id }}" href="javascript:void(0)">Delete
                                                Image</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
        <!-- /.content -->
    </div>

@endsection
