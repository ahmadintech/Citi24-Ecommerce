<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\product;
use App\Models\productsImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

class productController extends Controller
{
    public function products()
    {
        Session::put('page', 'products');

        $products = product::with(['category:id,name', 'images'])->get();

        return view('admin.products.products')->with(compact('products'));
    }


    public function updateProductStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            product::where('id', $data['product_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'product_id' => $data['product_id']]);
        }
    }

    public function deleteProduct($id)
    {
        product::where('id', $id)->delete();

        $message = "product has been successfully deleted";
        Session::flash('Success_message', $message);
        return redirect()->back();
    }

    // public function addEditProduct(Request $request, $id = null)
    // {
    //     if ($id == "") {
    //         $title = "Add Product";
    //         $product = new product;  //this line is to create a new product
    //         $productData = array();
    //         $message = 'Product added successfully !';
    //     } else {
    //         $title = "Edit Product";
    //         $productData = product::find($id);
    //         $productData = json_decode(json_encode($productData), true);
    //         $product = product::find($id);  //this line is to update the details
    //         $message = 'Product updated successfully !';
    //     }

    //     if ($request->isMethod('post')) {
    //         $data = $request->all();
    //         //validating the form
    //         $rules = [
    //             'category_id' => 'required',
    //             'product_name' => 'required',
    //             'price' => 'required|numeric',
    //         ];
    //         $customMessages = [
    //             'category_id.required' => 'Category is required',
    //             'product_name.required' => 'Product name is required',
    //             // 'product_name.regex' => 'Valid Product name is required',
    //             'price.required' => 'Product price is required',
    //             'price.numeric' => 'Valid Product price is required',
    //         ];
    //         $this->validate($request, $rules, $customMessages);
    //         //Upload product image
    //         if ($request->hasFile('main_image')) {
    //             $image_tmp = $request->file('main_image');

    //             if ($image_tmp->isValid()) {
    //                 $imageName = Str::slug(pathinfo($image_tmp->getClientOriginalName(), PATHINFO_FILENAME));
    //                 $extension = $image_tmp->getClientOriginalExtension();
    //                 $imageName = $imageName . '-' . rand(111, 999) . '.' . $extension;

    //                 // Paths relative to storage/app/public
    //                 $mediumPath = 'product_images/medium/' . $imageName;
    //                 $smallPath = 'product_images/small/' . $imageName;

    //                 // Save image using Intervention and Laravel Storage
    //                 Storage::disk('public')->put($mediumPath, (string) Image::make($image_tmp)->resize(520, 590)->encode());
    //                 Storage::disk('public')->put($smallPath, (string) Image::make($image_tmp)->resize(260, 270)->encode());

    //                 $product->main_image = $imageName;
    //             }
    //         }
    //         //save product details into the product table in the database
    //         $categoryDetails = category::find($data['category_id']);
    //         $product->category_id = $data['category_id'];
    //         $product->product_name = $data['product_name'];
    //         $product->price = $data['price'];
    //         $product->quantity = $data['quantity'];
    //         $product->unit = $data['unit'] ? $data['unit'] : 'kg';
    //         $product->product_weight = $data['product_weight'] ? $data['product_weight'] : 0;
    //         $product->product_discount = $data['product_discount'] ? $data['product_discount'] : 0;
    //         $product->description = $data['description'];

    //         if (!empty($data['is_featured'])) {
    //             $product->is_featured = $data['is_featured'];
    //         }
    //         $product->status = 1;
    //         $product->save();

    //         //send notifications to all users here
    //         // $client = new Client();
    //         // $endpoint = 'https://app.farmersmarketplace.ng/products/notify';

    //         // $postData = [
    //         //     'prod_name' => $data['product_name'],
    //         //     'status'   => $id == "" ? "add" : "update"

    //         // ];

    //         // Make a POST request to the external endpoint with the data
    //         // $response = $client->post($endpoint, [
    //         //     'json' => $postData,
    //         // ]);
    //         // $body = $response->getBody()->getContents();

    //         Session::flash('Success_message', $message);
    //         return redirect('admin/products');
    //     }

    //     //sections with categories and subCategories
    //     $categories = category::get();
    //     return view('admin.products.add_edit_product')->with(compact('title', 'categories', 'productData'));
    // }


    public function addEditProduct(Request $request, $id = null)
    {
        if ($id == "") {
            $title = "Add Product";
            $product = new product;  // create new
            $productData = [];
            $message = 'Product added successfully!';
        } else {
            $title = "Edit Product";
            $productData = product::with('images')->find($id);  // eager load images
            $product = $productData; // use same model for saving
            $message = 'Product updated successfully!';
        }

        if ($request->isMethod('post')) {
            $data = $request->all();

            $rules = [
                'category_id'   => 'required',
                'product_name'  => 'required',
                'price'         => 'required|numeric',
            ];
            $customMessages = [
                'category_id.required'  => 'Category is required',
                'product_name.required' => 'Product name is required',
                'price.required'        => 'Product price is required',
                'price.numeric'         => 'Valid Product price is required',
            ];
            $this->validate($request, $rules, $customMessages);

            $product->category_id       = $data['category_id'];
            $product->product_name      = $data['product_name'];
            $product->price             = $data['price'];
            $product->quantity          = $data['quantity'];
            $product->unit              = $data['unit'] ?? 'kg';
            $product->product_weight    = $data['product_weight'] ?? 0;
            $product->product_discount  = $data['product_discount'] ?? 0;
            $product->description       = $data['description'] ?? null;
            $product->is_featured       = !empty($data['is_featured']) ? $data['is_featured'] : 'No';
            $product->status            = 1;
            $product->save();

            if ($request->hasFile('product_images')) {
                foreach ($request->file('product_images') as $image) {
                    if ($image->isValid()) {
                        $imageName = Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME));
                        $extension = $image->getClientOriginalExtension();
                        $imageName = $imageName . '-' . rand(111, 999) . '.' . $extension;

                        // Save resized versions
                        $mediumPath = 'product_images/medium/' . $imageName;
                        $smallPath  = 'product_images/small/' . $imageName;

                        Storage::disk('public')->put($mediumPath, (string) Image::make($image)->resize(520, 590)->encode());
                        Storage::disk('public')->put($smallPath, (string) Image::make($image)->resize(260, 270)->encode());

                        // Save into DB
                        $productImage = new productsImage();
                        $productImage->product_id = $product->id;
                        $productImage->image = $imageName;
                        $productImage->status = 1;
                        $productImage->save();
                    }
                }
            }

            Session::flash('Success_message', $message);
            return redirect('admin/products');
        }

        // get all categories
        $categories = category::get();
        $productImages = !empty($productData) ? $productData->images : [];

        return view('admin.products.add_edit_product')
            ->with(compact('title', 'categories', 'productData', 'productImages'));
    }

    public function deleteProductImage($id)
    {
        //get the category image you wanna delete

        $productImage = productsImage::where('id', $id)->first();

        if ($productImage) {
            Storage::disk('public')->delete('product_images/small/' . $productImage->main_image);
            Storage::disk('public')->delete('product_images/medium/' . $productImage->main_image);
            //delete category image from categories table
            product::where('id', $id)->update(['main_image' => '']);
        }
        return redirect()->back()->with('flash_message_success', 'Product image has been deleted successfully!');
    }

    public function addImages(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            if ($request->hasFile('images')) {
                $images = $request->file('images');

                foreach ($images as $image) {
                    $productImage = new productsImage();

                    $imageName = rand(111, 999) . time() . '.' . $image->getClientOriginalExtension();

                    $mediumPath = 'product_images/medium/' . $imageName;
                    $smallPath = 'product_images/small/' . $imageName;

                    Storage::disk('public')->put($mediumPath, (string) Image::make($image)->resize(520, 590)->encode());
                    Storage::disk('public')->put($smallPath, (string) Image::make($image)->resize(260, 270)->encode());

                    $productImage->image = $imageName;
                    $productImage->product_id = $id;
                    $productImage->status = 1;
                    $productImage->save();
                }
            }
            $message = "Product Image has been successfully Added";
            Session::flash('Success_message', $message);
            return redirect()->back();
        }

        $productData = product::with('images')->select('id', 'product_name', 'main_image')->find($id);
        $productData = json_decode(json_encode($productData), true);
        //echo "<pre>";print_r($productData);die;
        return view('admin.products.add_images')->with(compact('productData'));
    }

    public function deleteImage($id)
    {
        //get the category image to be deleted
        $productImage = productsImage::select('image')->where('id', $id)->first();
        if ($productImage) {
            Storage::disk('public')->delete('product_images/small/' . $productImage->image);
            Storage::disk('public')->delete('product_images/medium/' . $productImage->image);

            productsImage::where('id', $id)->delete();
        }

        return redirect()->back()->with('flash_message_success', 'Product image has been deleted successfully!');
    }
}
