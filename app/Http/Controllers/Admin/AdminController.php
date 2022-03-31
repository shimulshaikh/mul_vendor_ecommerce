<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Auth;
use App\Models\Admin;

class AdminController extends Controller
{
    
	public function dashboard()
	{
		return view('admin.dashboard');
	}

	//update admin password
	public function updateAdminPassword()
	{
		//dd(Auth::guard('admin')->user()->email);
		$adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first()->toArray();
		//dd($adminDetails);
		return view('admin.settings.update_admin_password', compact('adminDetails'));
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
