<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Auth;
use App\Models\Admin;
use App\Models\Vendor;
use App\Models\vendorsBusinessDetails;
use App\Models\vendorsBankDetails;
use Image;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AdminController extends Controller
{
    
	public function dashboard()
	{
		return view('admin.dashboard');
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


	//update vendor details
	public function updateVendorDetails($slug, Request $request)
	{
		if ($slug == "personal") {
			if ($request->isMethod('post')) {
				$data = $request->all();
				$rules = [
					'vendor_name' => 'required|regex:/^[\pL\s\-]+$/u',
			        'vendor_mobile' => 'required|numeric',
			        'vendor_image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp'
				];
				$this->validate($request, $rules);

				//update vendor photo
				$image = $request->file('vendor_image');
	    		if(isset($image)){
		            //make unique name for image
		            $currentDate = Carbon::now()->toDateString();
		            $imageName = $currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
			            //check admin dir is exists
			            if (!Storage::disk('public')->exists('vendor_image')) 
			            {
			                Storage::disk('public')->makeDirectory('vendor_image');
			            }

			            //delete old admin image
			            if (Storage::disk('public')->exists('vendor_image/'.Auth::guard('admin')->user()->image))
			            {
			                Storage::disk('public')->delete('vendor_image/'.Auth::guard('admin')->user()->image);
			            }
		            //resize image for admin and upload
		            $img = Image::make($image)->resize(100,100)->save(storage_path('app/public/vendor_image').'/'.$imageName);
		            Storage::disk('public')->put('vendor_image/'.$imageName,$img);
	        	}
	        	else{
	        		$imageName = Auth::guard('admin')->user()->image;
	        	}

				//update admin table
				Admin::where('id', Auth::guard('admin')->user()->id)->update(['name'=> $data['vendor_name'], 'mobile'=>$data['vendor_mobile'], 'image'=>$imageName]);
				//update vendor table
				Vendor::where('id', Auth::guard('admin')->user()->vendor_id)->update(['name'=> $data['vendor_name'], 'address'=>$data['vendor_address'], 'city'=>$data['vendor_city'], 'state'=>$data['vendor_state'], 'country'=>$data['vendor_country'], 'pincode'=>$data['vendor_pincode'], 'mobile'=>$data['vendor_mobile']]);
				return redirect()->back()->with('success_message', 'Vendor details updated successfully!');
			}
			$vendorDetails = Vendor::where('id', Auth::guard('admin')->user()->vendor_id)->first()->toArray();

		}elseif ($slug == "business") {
			if ($request->isMethod('post')) {
				$data = $request->all();
				$rules = [
					'shop_name' => 'required|regex:/^[\pL\s\-]+$/u',
					'shop_city' => 'required|regex:/^[\pL\s\-]+$/u',
			        'shop_mobile' => 'required|numeric',
			        'address_proof' => 'required',
			        'address_proof_image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp'
				];
				$this->validate($request, $rules);

				//update vendor photo
				$image = $request->file('address_proof_image');
	    		if(isset($image)){
	    			$old_img = vendorsBusinessDetails::findorFail($data['id']);
		            //make unique name for image
		            $currentDate = Carbon::now()->toDateString();
		            $imageName = $currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
			            //check admin dir is exists
			            if (!Storage::disk('public')->exists('address_proof_image')) 
			            {
			                Storage::disk('public')->makeDirectory('address_proof_image');
			            }

			            //delete old admin image
			            if (Storage::disk('public')->exists('address_proof_image/'.$old_img['address_proof_image']))
			            {
			                Storage::disk('public')->delete('address_proof_image/'.$old_img['address_proof_image']);
			            }
		            //resize image for admin and upload
		            $img = Image::make($image)->resize(100,100)->save(storage_path('app/public/address_proof_image').'/'.$imageName);
		            Storage::disk('public')->put('address_proof_image/'.$imageName,$img);
	        	}
	        	else{
	        		$old_img = vendorsBusinessDetails::findorFail($data['id']);
	        		$imageName = $old_img['address_proof_image'];
	        	}

				//update is vendor details business table
				vendorsBusinessDetails::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->update(['shop_name'=> $data['shop_name'], 'shop_address'=>$data['shop_address'], 'shop_city'=>$data['shop_city'], 'shop_state'=>$data['shop_state'], 'shop_country'=>$data['shop_country'], 'shop_pincode'=>$data['shop_pincode'], 'shop_mobile'=>$data['shop_mobile'], 'business_license_number'=>$data['business_license_number'], 'gst_number'=>$data['gst_number'], 'pan_number'=>$data['pan_number'], 'address_proof'=>$data['address_proof'], 'address_proof_image'=>$imageName]);
				return redirect()->back()->with('success_message', 'Vendor details updated successfully!');
			}
			$vendorDetails = vendorsBusinessDetails::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->first()->toArray();
		}elseif ($slug == "bank") {
			if ($request->isMethod('post')) {
				$data = $request->all();
				$rules = [
					'account_holder_name' => 'required|regex:/^[\pL\s\-]+$/u',
					'bank_name' => 'required',
					'account_number' => 'required',
					'bank_ifsc_code' => 'required'
				];
				$this->validate($request, $rules);

				//update vendor table
				vendorsBankDetails::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->update(['account_holder_name'=> $data['account_holder_name'], 'bank_name'=>$data['bank_name'], 'account_number'=>$data['account_number'], 'bank_ifsc_code'=>$data['bank_ifsc_code']]);
				return redirect()->back()->with('success_message', 'Vendor details updated successfully!');
			}
			$vendorDetails = vendorsBankDetails::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->first()->toArray();
			//dd($vendorDetails);
		}
		return view('admin.settings.update_vendor_details')->with(compact('slug','vendorDetails'));
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
