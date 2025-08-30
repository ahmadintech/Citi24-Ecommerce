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
                            <li class="breadcrumb-item active">Products</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <form name="productform" id="productForm"
                @if (empty($productData['id'])) action="{{ url('admin/add-edit-product') }}"
      @else action="{{ url('admin/add-edit-product/' . $productData['id']) }}" @endif
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
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Select Category</label>
                                        <select name="category_id" id="category_id" class="form-control select2"
                                            style="width: 100%;">
                                            <option value="">Select</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category['id'] }}"
                                                    @if (!empty($productData['category_id']) && $productData['category_id'] == $category['id']) selected @endif>
                                                    {{ $category['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="product_name">Product Name</label>
                                        <input type="text" class="form-control" id="product_name" name="product_name"
                                            placeholder="Enter product Name" required
                                            @if (!empty($productData['product_name'])) value="{{ $productData['product_name'] }}" @else value="{{ old('product_name') }}" @endif>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="price">Product Price</label>
                                        <input type="number" class="form-control" id="price" name="price"
                                            placeholder="Enter product Price" step="0.01" required
                                            @if (!empty($productData['price'])) value="{{ $productData['price'] }}" @else value="{{ old('price') }}" @endif>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="unit">Weight Unit</label>
                                        <select name="unit" id="unit" class="form-control select2"
                                            style="width: 100%;">
                                            <option value="">Select</option>
                                            {{-- @php $units = ['kG', 'L', 'CL']; @endphp --}}
                                            <option value="kg">Kilograms (Kg)</option>
                                            <option value="l">Litre (L)</option>
                                            <option value="cl">Centilitres (CL)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="product_weight">Product Weight</label>
                                        <input type="number" class="form-control" id="product_weight" name="product_weight"
                                            step="0.01" placeholder="Enter product Weight"
                                            @if (!empty($productData['product_weight'])) value="{{ $productData['product_weight'] }}" @else value="{{ old('product_weight') }}" @endif>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="product_discount">Product Discount (%)</label>
                                        <input type="number" class="form-control" id="product_discount"
                                            name="product_discount" placeholder="Enter product Discount"
                                            @if (!empty($productData['product_discount'])) value="{{ $productData['product_discount'] }}" @else value="{{ old('product_discount') }}" @endif>
                                    </div>
                                </div>

                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="main_image">Product Main Image</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="main_image"
                                                    name="main_image">
                                                <label class="custom-file-label" for="main_image">Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="">Upload</span>
                                            </div>
                                        </div>
                                        <div style="color: grey;">Recommended Image size: Width:1040px Height:1180px
                                        </div>
                                        @if (!empty($productData['main_image']))
                                            <img src=" {{ asset('storage/product_images/small/' . $productData['main_image']) }} "style="margin-top:1%;"
                                                height="100px" width="100px">
                                            &nbsp;<a class="confirmDelete" record="product-image"
                                                recordid="{{ $productData['id'] }}" href="javascript:void(0)">Delete
                                                Image</a>
                                        @endif
                                    </div>
                                </div> --}}

                                <div class="col-md-12">
    <div class="form-group">
        <label for="product_images">Product Images</label>
        <div>
                <input
                    type="file"
                    class="form-control"
                    id="product_images"
                    name="product_images[]"
                    multiple
                    accept="image/*"
                >
        </div>
        <small class="text-primary py-2">Recommended Image size: Width:1040px Height:1180px</small>

        {{-- Show uploaded images if available --}}
        @if (!empty($productImages) && count($productImages) > 0)
            <div class="row mt-2">
                @foreach ($productImages as $image)
                    <div class="col-md-2 text-center mb-2">
                        <img
                            src="{{ asset('storage/product_images/small/' . $image->image) }}"
                            alt="Product Image"
                            class="img-thumbnail"
                            style="height: 100px; width: 100px; object-fit: cover;"
                        >
                        <br>
                        <a href="javascript:void(0)"
                           class="confirmDelete text-danger"
                           record="product-image"
                           recordid="{{ $image->id }}">
                           Delete
                        </a>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Preview newly selected images before upload --}}
        <div id="preview-container" class="row mt-3"></div>
    </div>
</div>

{{-- Preview Script --}}
<script>
document.getElementById('product_images').addEventListener('change', function(event) {
    let previewContainer = document.getElementById('preview-container');
    previewContainer.innerHTML = ""; // clear previous preview

    [...event.target.files].forEach(file => {
        let reader = new FileReader();
        reader.onload = e => {
            let col = document.createElement("div");
            col.className = "col-md-2 mb-2";
            col.innerHTML = `
                <img src="${e.target.result}" class="img-thumbnail"
                     style="height:100px;width:100px;object-fit:cover;" />
            `;
            previewContainer.appendChild(col);
        };
        reader.readAsDataURL(file);
    });
});
</script>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="product_description">Product Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter ..." required>
@if (!empty($productData['description']))
{{ $productData['description'] }}
@endif
</textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="quantity">Product Quantity</label>
                                        <input type="number" class="form-control" id="quantity" name="quantity"
                                            placeholder="Enter product Quantity" required
                                            @if (!empty($productData['quantity'])) value="{{ $productData['quantity'] }}" @else value="{{ old('quantity') }}" @endif>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="meta_keywords">Featured Item</label>
                                    <?php $is_featured = 'Yes'; ?>
                                    <input type="checkbox" name="is_featured" id="is_featured" value="Yes"
                                        @if (!empty($productData['is_featured']) && $productData['is_featured'] == $is_featured) checked @endif>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer mb-4">
                        <button type="submit" class="btn btn-success px-4">Save</button>
                    </div>
                </div>

    </div>
    </form>
    </section>
    </div>

@endsection
