<?php
use Illuminate\Support\Facades\Session; ?>
@extends('layouts.admin_layout.admin_layout')
@section('content')

    <div class="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Catalogues</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Product Images</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <form name="imagesform" id="imagesForm" action="{{ url('admin/add-images/' . $productData['id']) }}"
                method="post" enctype="multipart/form-data">@csrf
                <div class="container-fluid">
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
                    @if (session::has('Success_message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert"
                            style="margin-top: 10px;">
                            {{ Session::get('Success_message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if (session::has('Error_message'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert"
                            style="margin-top: 10px;">
                            {{ Session::get('Error_message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">product images</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                        class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="product_name">Product Name:
                                        </label>&nbsp;{{ $productData['product_name'] }}

                                    </div>

                                    <div class="form-group">
                                        <label for="product_code">Product Category: </label>&nbsp;Chek1234

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <img src=" {{ asset('storage/product_images/small/' . $productData['main_image']) }} "
                                        height="150px" width="150px">

                                </div>

                                <div class="col-md-8">
                                    <div class="field_wrapper">
                                        <div>
                                            <input multiple type="file" id="images" name="images[]" required />
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Add images</button>
                    </div>
            </form>


            <form name="editimageForm" id="editimageForm" method="post"
                action="{{ url('admin/edit-images/' . $productData['id']) }}" enctype="multipart/form-data">@csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Added Product images</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="products" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>IMAGE</th>
                                    <th>ACTIONS</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productData['images'] as $image)
                                    <input type="hidden" name="attrId[]" value="{{ $image['id'] }}">
                                    <tr>
                                        <td>{{ $image['id'] }}</td>
                                        <td>
                                            <img src=" {{ asset('storage/product_images/small/' . $image['image']) }} "
                                                height="150px" width="150px">
                                        </td>

                                        <td>
                                            @if ($image['status'] == 1)
                                                <a class="updateImagestatus" id="image-{{ $image['id'] }}"
                                                    image_id="{{ $image['id'] }}" href="javascript:void(0)">Active</a>
                                            @else
                                                <a class="updateImagestatus" id="image-{{ $image['id'] }}"
                                                    $image_id="{{ $image['id'] }}" href="javascript:void(0)">Inactive</a>
                                            @endif

                                            <a title="Delete image" href='javascript:void(0)' class="confirmDelete"
                                                record="image" recordid="{{ $image['id'] }}" <?php /*  href=" {{ urL('admin/delete-category/'.$image['id'])}} " */ ?>><i
                                                    class="fa fa-trash"></i></a>
                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>

                        </table>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update images</button>
                    </div>
                </div>

            </form>


        </section>
    </div>

@endsection
