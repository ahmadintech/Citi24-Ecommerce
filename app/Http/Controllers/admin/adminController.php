<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin;
use App\Models\product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;


class adminController extends Controller
{

    public function dashboard()
    {
        Session::put('page', 'dashboard');

        $userCount = User::get()->count();
        $productCount = product::get()->count();
        // $orderCount = DB::table('orders')->get()->count();
        // $cartCount = DB::table('cart')->get()->count();

        // return view('admin.admin_dashboard')->with(compact('userCount', 'orderCount', 'productCount', 'cartCount'));
        return view('admin.admin_dashboard')->with(compact('userCount',  'productCount',));
    }

    public function users()
    {
        Session::put('page', 'users');

        $users = DB::table('users')->get();
        return view('admin.users')->with(compact('users'));
    }

    public function manageAdmins()
    {
        Session::put('page', 'manage_admins');

        $users = DB::table('admins')->get();
        return view('admin.admins')->with(compact('users'));
    }

    public function addAdmin()
    {
        Session::put('page', 'add_admin');

        return view('admin.add_admin');
    }

    public function shipping()
    {
        Session::put('page', 'shipping');

        $shippings = DB::table('lagos_shipping')->get();
        return view('admin.shipping')->with(compact('shippings'));
    }

    public function editShipping(Request $request)
    {
        if ($request->ajax()) {

            $data = $request->all();

            DB::table('lagos_shipping')->where('id', $data['id'])->update(['cost' => $data['amount']]);
            return response()->json(['status' => 200, 'data' => $data]);
        }
    }

    public function deleteAdmin($id)
    {
        admin::where('id', $id)->delete();

        $message = "Admin has been successfully deleted";
        Session::flash('Success_message', $message);
        return redirect()->back();
    }

    public function addNewAdmin(Request $request)
    {
        $data = $request->all();
        $admin = new admin();

        $admin->name = $data['name'];
        $admin->email = $data['email'];
        $admin->mobile = $data['phone'];
        $admin->password = Hash::make($data['password']);
        $admin->type = 'admin';
        $admin->image = '';
        $admin->status = 1;
        $admin->save();

        Session::flash('Success_message', 'New admin added successfully');
        return redirect('admin/manage_admins');
    }

    public function login(Request $request)
    {
        // dd($request);
        if ($request->isMethod('post')) {
            $data = $request->all();

            //custom messages
            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required',
            ];
            $customMessages = [
                'email.required' => 'Email address is required',
                'email.email' => 'Enter a valid email address',
                'password.required' => 'Password field is required',
            ];

            $this->validate($request, $rules, $customMessages);

            if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
                return redirect('admin/dashboard');
            } else {
                Session::flash('error_message', 'invalid email or password');
                return redirect()->back();
            }
        }
        //echo $password = Hash::make('1234');die;
        return view('admin.admin_login');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }

    public function settings()
    {
        Session::put('page', 'settings');
        // echo "<pre>";print_r(Auth::guard('admin')->user());die;
        return view('admin.admin_settings');
    }

    public function checkCurrentPassword(Request $request)
    {
        $data = $request->all();
        //echo "<pre>";print_r($data);die;
        //echo "<pre>"; Auth::guard('admin')->user()->password();die;
        if (Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)) {
            echo "true";
        } else {
            echo "false";
        }

        //return view('admin.');
    }

    public function updateCurrentPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //check if current password is correct by comparing it with the one from the database
            if (Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)) {
                //check if new and confirm password matches
                if ($data['new_pwd'] == $data['confirm_pwd']) {
                    admin::where('id', Auth::guard('admin')->user()->id)->update(['password' => bcrypt($data['new_pwd'])]);
                    Session::flash('Success_message', 'Your password has been successfully updated');
                    return redirect()->back();
                } else {
                    Session::flash('error_message', 'Your new password and confirm password must match');
                    return redirect()->back();
                }
            } else {
                Session::flash('error_message', 'Your current password is wrong');
                return redirect()->back();
            }
        }
    }


    public function updateAdminDetails(Request $request)
    {
        Session::put('page', 'update-admin-details');
        if ($request->isMethod('post')) {
            $data = $request->all();
            $imageName = '';

            $rules = [
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile' => 'required|numeric',
                'admin_image' => 'image'
            ];
            $customMessages = [
                'admin_name.required' => 'Name is required',
                'admin_name.regex' => 'valid Name is required',
                'admin_mobile.required' => 'Mobile is required',
                'admin_mobile.numeric' => 'Please enter a valid phone number',
                'admin_image.image' => 'Valid Image is required',
            ];
            $this->validate($request, $rules, $customMessages);

            //here is the code to upload the image
            if ($request->hasFile('admin_image')) {
                $image_tmp = $request->file('admin_image');
                if ($image_tmp->isValid()) {
                    $extension = $image_tmp->getClientOriginalExtension();

                    //Generate new image name below
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $imagePath = 'images/admin_images/admin_photos/' . $imageName;

                    //upload the image
                    Image::make($image_tmp)->resize(250, 250)->save($imagePath);
                } elseif (!empty($data['current_admin_image'])) {
                    $imageName = $data['current_admin_image'];
                } else {
                    $imageName = "";
                }
            }

            //update Admin details here
            admin::where('id', Auth::guard('admin')->user()->id)->update(['name' => $data['admin_name'], 'mobile' => $data['admin_mobile'], 'image' => $imageName]);
            Session::flash('Success_message', 'Admin details have been successfully updated');
            return redirect()->back();
        }
        return view("admin.update_admin_details");
    }
}
