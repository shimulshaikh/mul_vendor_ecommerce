<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function(){
	//Admin Login route
	Route::match(['get','post'], 'login', 'AdminController@login');
	Route::group(['middleware'=>['admin']], function(){
		//Admin dashboard route
		Route::get('dashboard', 'AdminController@dashboard');
		//Update admin password
		Route::match(['get','post'], 'update-admin-password', 'AdminController@updateAdminPassword');
		//Update admin details
		Route::match(['get','post'], 'update-admin-details', 'AdminController@updateAdminDetails');
		//update vendor details
		Route::match(['get','post'], 'update-vendor-details/{slug}', 'AdminController@updateVendorDetails');
		Route::post('/check-admin-password', 'AdminController@checkAdminPassword');
		//View Admin/Subadmin/vendors
		Route::get('admins/{type?}', 'AdminController@admins');
		//view vendor details
		Route::get('view-vendor-details/{id}', 'AdminController@viewVendorDetails');
		//Admin logout
		Route::get('logout', 'AdminController@logout');
	});
	
});

