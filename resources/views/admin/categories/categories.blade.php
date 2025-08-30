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
                                <h3 class="card-title">Categories</h3>

                                <a class="btn btn-success float-right text-white"
                                    href="{{ url('admin/add-edit-category') }}">Add Category</a>

                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="categories" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>CATEGORY IMAGE</th>
                                            <th>CATEGORY</th>
                                            <th>STATUS</th>
                                            <th>ACTION</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @foreach ($categories as $index => $category)
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $category->name }}</td>
                                                <td>
                                                    @if (!empty($category->category_image))
                                                        <img src="{{ asset('storage/category_images/' . $category->category_image) }}"
                                                            width="60px" height="60px">
                                                    @else
                                                        <img src="{{ asset('no_image.png') }}"
                                                            width="60px" height="60px">
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($category->status == 1)
                                                        <a class="updateCategoryStatus" id="category-{{ $category->id }}"
                                                            category_id="{{ $category->id }}"
                                                            href="javascript:void(0)">Active</a>
                                                    @else
                                                        <a class="updateCategoryStatus" id="category-{{ $category->id }}"
                                                            category_id="{{ $category->id }}"
                                                            href="javascript:void(0)">Inactive</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href=" {{ urL('admin/add-edit-category/' . $category->id) }} "><button
                                                            class="btn btn-primary">Edit</button></a>
                                                    <a href='javascript:void(0)' class="confirmDelete" record="category"
                                                        recordid="{{ $category->id }}"><button
                                                            class="btn btn-danger">Delete</button></a>
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
