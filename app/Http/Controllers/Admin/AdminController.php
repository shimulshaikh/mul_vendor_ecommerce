<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Auth;
use App\Models\Admin;
use Image;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AdminController extends Controller
{
    
	public function dashboard()
	{
		return view('admin.dashboard');
	}

	//update admin password
	public function updateAdminPassword(Request $request)
	{
		if ($request->isMethod('post')) {
			$data = $request->all();
			//Check current password with admin password
			if (Hash::check($data['current_password'],Auth::guard('admin')->user()->password)) {
				//Check new password with confirm password
				if ($data['new_password']==$data['confirm_password']) {
					Admin::where('id', Auth::guard('admin')->user()->id)->update(['password'=>bcrypt($data['new_password'])]);
					redirect()->back()->with('success_message', 'Password has been update successfully!');
				}else{
					redirect()->back()->with('error_message', 'New Password and confirm Password does not match!');
				}
			}else{
				redirect()->back()->with('error_message', 'Your Current Password Is Incorrect!');
			}
		}

		//dd(Auth::guard('admin')->user()->email);
		$adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first()->toArray();
		//dd($adminDetails);
		return view('admin.settings.update_admin_password', compact('adminDetails'));
	}

	//update admin details
	public function updateAdminDetails(Request $request)
	{
		if ($request->isMethod('post')) {
			$data = $request->all();

			$rules = [
				'name' => 'required|regex:/^[\pL\s\-]+$/u',
		        'mobile' => 'required|numeric',
		        'admin_image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp'
				];
			$this->validate($request, $rules);

			//update admin photo
			$image = $request->file('admin_image');
    		if(isset($image)){
	            //make unique name for image
	            $currentDate = Carbon::now()->toDateString();
	            $imageName = $currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
		            //check admin dir is exists
		            if (!Storage::disk('public')->exists('admin_image')) 
		            {
		                Storage::disk('public')->makeDirectory('admin_image');
		            }

		            //delete old admin image
		            if (Storage::disk('public')->exists('admin_image/'.Auth::guard('admin')->user()->image))
		            {
		                Storage::disk('public')->delete('admin_image/'.Auth::guard('admin')->user()->image);
		            }
	            //resize image for admin and upload
	            $img = Image::make($image)->resize(100,100)->save(storage_path('app/public/admin_image').'/'.$imageName);
	            Storage::disk('public')->put('admin_image/'.$imageName,$img);
        	}
        	else{
        		$imageName = Auth::guard('admin')->user()->image;
        	}

			//update admin details
			Admin::where('id', Auth::guard('admin')->user()->id)->update(['name'=> $data['name'], 'mobile'=>$data['mobile'], 'image'=>$imageName]);
			return redirect()->back()->with('success_message', 'Admin details updated successfully!');
		}
		return view('admin.settings.update_admin_details');
	}

	//check current password
	public function checkAdminPassword(Request $request)
	{
		$data = $request->all();
		if(Hash::check($data['current_password'], Auth::guard('admin')->user()->password)){
			return "true";
		}else{
			return "false";
		}
	}

	public function login(Request $request)
	{
		if ($request->isMethod('post')) {
			//dd($request->all());

			$rule = [
				'email' => 'required|email|max:255',
		        'password' => 'required',
				];

			$customMessage = [
			 	//Add custom Message here
			 	'email.required' => 'Email is required!',
			 	'email.email' => 'Valid email is required!',
			 	'password.required' => 'Password is required!',
			 	];
			$this->validate($request, $rule, $customMessage);

			$data = $request->all();

			if (Auth::guard('admin')->attempt(['email'=>$data['email'], 'password'=>$data['password'],'status'=>1])) {
				return redirect('admin/dashboard');
			}else{
				return redirect()->back()->with('error_message', 'Invalid Email Or Password');
			}
		}
		//Generate hash password
		//echo $password = Hash::make('12345'); die;
		return view('admin.login');
	}

	public function logout()
	{
		Auth::guard('admin')->logout();
		return redirect('admin/login');
	}

}
