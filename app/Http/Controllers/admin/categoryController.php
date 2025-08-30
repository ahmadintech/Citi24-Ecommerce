<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class categoryController extends Controller
{
    public function categories()
    {
        Session::put('page', 'categories');
        $categories = category::get();
        return view('admin.categories.categories')->with(compact('categories'));
    }

    public function updateCategoryStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            //echo "<pre>";print_r($data);die;
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            category::where('id', $data['category_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'category_id' => $data['category_id']]);
        }
    }

    public function addEditCategory(Request $request, $id = null)
    {
        Session::put('page', 'add-edit-categories');
        if ($id == "") {
            //Add category functionalities
            $title = "Add Category";
            $category = new category;
            $categoryData = array();
            $categoryData['section_id'] = '';
            $getCategories = array();
            $message = 'Category added successfully';
        } else {
            //Edit category functionalities
            $title = "Edit Category";
            $categoryData = category::where('id', $id)->first();  //to get details from the id of the category you clicked
            $getCategories = category::get();
            // $categoryData = json_decode(json_encode($categoryData));
            //echo "<pre>";print_r($categoryData);die;
            $category = category::find($id);
            $message = 'Category updated successfully';
        }

        //get data from the form in add-edit-categories page
        if ($request->isMethod('post')) {
            $data = $request->all();

            //validating the form
            $rules = [
                'name' => 'required',
                'category_image' => 'image'
            ];
            $customMessages = [
                'name.required' => 'Category name is required',
                // 'name.regex' => 'Valid Name is required',
                'category_image.image' => 'Valid Image is required',
            ];
            $this->validate($request, $rules, $customMessages);

            //here is the code to upload category image
            if ($request->hasFile('category_image')) {
                $image_tmp = $request->file('category_image');
                if ($image_tmp->isValid()) {
                    $extension = $image_tmp->getClientOriginalExtension();

                    //Generate new image name below
                    $imageName = rand(111, 99999) . '.' . $extension;

                    //upload the image
                    $imagePath = 'category_images/' . $imageName;
                    Storage::disk('public')->put($imagePath, (string) Image::make($image_tmp)->resize(512, 512)->encode());


                    //save the image in category image column in database
                    $category->category_image = $imageName;
                }
            }

            $category->name = $data['name'];
            $category->status = 1;
            $category->save();

            Session::flash('Success_message', $message);
            return redirect('admin/categories');
        }

        return view('admin.categories.add_edit_categories')->with(compact('title', 'categoryData', 'getCategories'));
    }

    public function deleteCategoryImage($id)
    {
        //get the category image you wanna delete
        $categoryImage = category::select('category_image')->where('id', $id)->first();

        //get category image path
        $imagePath = 'category_images/' . $categoryImage->category_image;
        if (Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }

        //delete category image from categories table
        category::where('id', $id)->update(['category_image' => '']);
        return redirect()->back()->with('flash_message_success', 'Category image has been deleted successfully!');    
    }

    public function deleteCategory($id)
    {
        category::where('id', $id)->delete();

        $message = "Category has been successfully deleted";
        Session::flash('Success_message', $message);
        return redirect()->back();
    }
}
