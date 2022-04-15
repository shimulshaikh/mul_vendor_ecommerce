@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
   <div class="content-wrapper">
      <div class="row">
         <div class="col-md-12 grid-margin">
            <div class="row">
               <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Update Vendor Details</h3>
               </div>
               <div class="col-12 col-xl-4">
                  <div class="justify-content-end d-flex">
                     <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                        <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                           <a class="dropdown-item" href="#">January - March</a>
                           <a class="dropdown-item" href="#">March - June</a>
                           <a class="dropdown-item" href="#">June - August</a>
                           <a class="dropdown-item" href="#">August - November</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      
      @if($slug == "personal")
      <div class="row">
	      <div class="col-md-6 grid-margin stretch-card">
	              <div class="card">
	                <div class="card-body">
	                  <h4 class="card-title">Update Personal Information</h4>

	                  @if(Session::has('error_message'))
		                <div class="alert alert-danger alert-dismissible fade show" role="alert">
		                  <strong>Error : </strong> {{ Session::get('error_message') }}
		                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		                    <span aria-hidden="true">&times;</span>
		                  </button>
		                </div>
		              @endif  

		              @if(Session::has('success_message'))
		                <div class="alert alert-success alert-dismissible fade show" role="alert">
		                  <strong>Success : </strong> {{ Session::get('success_message') }}
		                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		                    <span aria-hidden="true">&times;</span>
		                  </button>
		                </div>
		              @endif 

		              @if ($errors->any())
		                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
		                      @foreach ($errors->all() as $error)
		                        <li>{{ $error }}</li>
		                      @endforeach
		                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		                      	<span aria-hidden="true">&times;</span>
		                    </button>
		                  </div>
		              @endif

	                  <form class="forms-sample" method="post" enctype="multipart/form-data" action="{{ url('admin/update-vendor-details/personal') }}">@csrf
	                    <div class="form-group">
	                      <label for="exampleInputUsername1">Vendor Username/Email</label>
	                      <input type="text" class="form-control" value="{{ Auth::guard('admin')->user()->email }}" readonly="">
	                    </div>
	                    <div class="form-group">
	                      <label for="exampleInputEmail1">Admin Type</label>
	                      <input class="form-control" value="{{ Auth::guard('admin')->user()->type }}" readonly="">
	                    </div>
	                    <div class="form-group">
	                      <label for="vendor_name">Name</label>
	                      <input type="text" class="form-control" id="vendor_name" placeholder="Enter Current Name" name="vendor_name" value="{{ Auth::guard('admin')->user()->name }}" required="">
	                    </div>
	                    <div class="form-group">
	                      <label for="vendor_address">Address</label>
	                      <input type="text" class="form-control" id="vendor_address" placeholder="Enter Current Address" name="vendor_address" value="{{ $vendorDetails['address'] }}" required="">
	                    </div>
	                    <div class="form-group">
	                      <label for="vendor_city">City</label>
	                      <input type="text" class="form-control" id="vendor_city" placeholder="Enter Current City" name="vendor_city" value="{{ $vendorDetails['city'] }}" required="">
	                    </div>
	                    <div class="form-group">
	                      <label for="vendor_state">State</label>
	                      <input type="text" class="form-control" id="vendor_state" placeholder="Enter Current State" name="vendor_state" value="{{ $vendorDetails['state'] }}" required="">
	                    </div>
	                    <div class="form-group">
	                      <label for="vendor_country">Country</label>
	                      <input type="text" class="form-control" id="vendor_country" placeholder="Enter Current Country" name="vendor_country" value="{{ $vendorDetails['country'] }}" required="">
	                    </div>
	                    <div class="form-group">
	                      <label for="vendor_pincode">Pincode</label>
	                      <input type="text" class="form-control" id="vendor_pincode" placeholder="Enter Current Pincode" name="vendor_pincode" value="{{ $vendorDetails['pincode'] }}" required="">
	                    </div>
	                    <div class="form-group">
	                      <label for="vendor_mobile">Mobile</label>
	                      <input type="text" class="form-control" id="vendor_mobile" placeholder="Enter 11 Digit Mobile Number" name="vendor_mobile" value="{{ $vendorDetails['mobile'] }}" maxlength="11" minlength="11" required="">
	                    </div>
	                    <div class="form-group">
	                      <label for="vendor_image">Photo</label>
	                      <input type="file" class="form-control" id="vendor_image" name="vendor_image" accept = 'image/jpeg , image/jpg, image/gif, image/png, image/svg, image/webp'>
	                      @if(!empty(Auth::guard('admin')->user()->image))
	                      	<img src="{{ asset('/storage/vendor_image') }}/{{ Auth::guard('admin')->user()->image  }}" class="img-circle elevation-2" alt="User Image">
	                      @endif
	                    </div>
	                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
	                    <button class="btn btn-light">Cancel</button>
	                  </form>
	                </div>
	              </div>
	      </div>
  	  </div>
  	  @elseif($slug == "business")
  	  <div class="row">
	      <div class="col-md-6 grid-margin stretch-card">
	              <div class="card">
	                <div class="card-body">
	                  <h4 class="card-title">Update Business Information</h4>

	                  @if(Session::has('error_message'))
		                <div class="alert alert-danger alert-dismissible fade show" role="alert">
		                  <strong>Error : </strong> {{ Session::get('error_message') }}
		                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		                    <span aria-hidden="true">&times;</span>
		                  </button>
		                </div>
		              @endif  

		              @if(Session::has('success_message'))
		                <div class="alert alert-success alert-dismissible fade show" role="alert">
		                  <strong>Success : </strong> {{ Session::get('success_message') }}
		                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		                    <span aria-hidden="true">&times;</span>
		                  </button>
		                </div>
		              @endif 

		              @if ($errors->any())
		                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
		                      @foreach ($errors->all() as $error)
		                        <li>{{ $error }}</li>
		                      @endforeach
		                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		                      	<span aria-hidden="true">&times;</span>
		                    </button>
		                  </div>
		              @endif

	                  <form class="forms-sample" method="post" enctype="multipart/form-data" action="{{ url('admin/update-vendor-details/business') }}">@csrf
	                  	<input type="hidden" name="id" value="{{ $vendorDetails['id'] }}">
	                    <div class="form-group">
	                      <label for="exampleInputUsername1">Vendor Username/Email</label>
	                      <input type="text" class="form-control" value="{{ Auth::guard('admin')->user()->email }}" readonly="">
	                    </div>
	                    <div class="form-group">
	                      <label for="exampleInputEmail1">Admin Type</label>
	                      <input class="form-control" value="{{ Auth::guard('admin')->user()->type }}" readonly="">
	                    </div>
	                    <div class="form-group">
	                      <label for="shop_name">Shop Name</label>
	                      <input type="text" class="form-control" id="shop_name" placeholder="Enter Shop Name" name="shop_name" value="{{ $vendorDetails['shop_name'] }}" required="">
	                    </div>
	                    <div class="form-group">
	                      <label for="shop_address">Shop Address</label>
	                      <input type="text" class="form-control" id="shop_address" placeholder="Enter Shop Address" name="shop_address" value="{{ $vendorDetails['shop_address'] }}" required="">
	                    </div>
	                    <div class="form-group">
	                      <label for="shop_city">Shop City</label>
	                      <input type="text" class="form-control" id="shop_city" placeholder="Enter Shop City" name="shop_city" value="{{ $vendorDetails['shop_city'] }}" required="">
	                    </div>
	                    <div class="form-group">
	                      <label for="shop_state">Shop State</label>
	                      <input type="text" class="form-control" id="shop_state" placeholder="Enter Shop State" name="shop_state" value="{{ $vendorDetails['shop_state'] }}" required="">
	                    </div>
	                    <div class="form-group">
	                      <label for="shop_country">Shop Country</label>
	                      <input type="text" class="form-control" id="shop_country" placeholder="Enter Shop Country" name="shop_country" value="{{ $vendorDetails['shop_country'] }}" required="">
	                    </div>
	                    <div class="form-group">
	                      <label for="shop_pincode">Shop Pincode</label>
	                      <input type="text" class="form-control" id="shop_pincode" placeholder="Enter Shop Pincode" name="shop_pincode" value="{{ $vendorDetails['shop_pincode'] }}" required="">
	                    </div>
	                    <div class="form-group">
	                      <label for="shop_mobile">Shop Mobile</label>
	                      <input type="text" class="form-control" id="shop_mobile" placeholder="Enter 11 Digit Mobile Number" name="shop_mobile" value="{{ $vendorDetails['shop_mobile'] }}" maxlength="11" minlength="11" required="">
	                    </div>
	                    <div class="form-group">
	                      <label for="business_license_number">Business License Number</label>
	                      <input type="text" class="form-control" id="business_license_number" placeholder="Enter 11 Digit Mobile Number" name="business_license_number" value="{{ $vendorDetails['business_license_number'] }}" required="">
	                    </div>
	                    <div class="form-group">
	                      <label for="gst_number">GST Number</label>
	                      <input type="text" class="form-control" id="gst_number" placeholder="Enter 11 Digit Mobile Number" name="gst_number" value="{{ $vendorDetails['gst_number'] }}" required="">
	                    </div>
	                    <div class="form-group">
	                      <label for="pan_number">PAN Number</label>
	                      <input type="text" class="form-control" id="pan_number" placeholder="Enter 11 Digit Mobile Number" name="pan_number" value="{{ $vendorDetails['pan_number'] }}"required="">
	                    </div>
	                    <div class="form-group">
	                      <label for="address_proof">Address Proof</label>
	                      <select class="form-control" name="address_proof" id="address_proof">
	                      	<option value="Passport" @if($vendorDetails['address_proof']=='Passport') selected @endif>Passport</option>
	                      	<option value="Voting Card" @if($vendorDetails['address_proof']=='Voting Card') selected @endif>Voting Card</option>
	                      	<option value="PAN" @if($vendorDetails['address_proof']=='PAN') selected @endif>PAN</option>
	                      	<option value="Driving License" @if($vendorDetails['address_proof']=='Driving License') selected @endif>Driving License</option>
	                      </select>
	                    </div>
	                    <div class="form-group">
	                      <label for="address_proof_image">Address Proof Image</label>
	                      <input type="file" class="form-control" id="address_proof_image" name="address_proof_image" accept = 'image/jpeg , image/jpg, image/gif, image/png, image/svg, image/webp'>
	                      @if(!empty($vendorDetails['address_proof_image']))
	                      	<img src="{{ asset('/storage/address_proof_image') }}/{{ $vendorDetails['address_proof_image']  }}" class="img-circle elevation-2" alt="User Image">
	                      @endif
	                    </div>
	                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
	                    <button class="btn btn-light">Cancel</button>
	                  </form>
	                </div>
	              </div>
			    </div>
		  	</div>
  	  @elseif($slug == "bank")
  	  <div class="row">
	      <div class="col-md-6 grid-margin stretch-card">
	              <div class="card">
	                <div class="card-body">
	                  <h4 class="card-title">Update Bank Information</h4>

	                  @if(Session::has('error_message'))
		                <div class="alert alert-danger alert-dismissible fade show" role="alert">
		                  <strong>Error : </strong> {{ Session::get('error_message') }}
		                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		                    <span aria-hidden="true">&times;</span>
		                  </button>
		                </div>
		              @endif  

		              @if(Session::has('success_message'))
		                <div class="alert alert-success alert-dismissible fade show" role="alert">
		                  <strong>Success : </strong> {{ Session::get('success_message') }}
		                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		                    <span aria-hidden="true">&times;</span>
		                  </button>
		                </div>
		              @endif 

		              @if ($errors->any())
		                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
		                      @foreach ($errors->all() as $error)
		                        <li>{{ $error }}</li>
		                      @endforeach
		                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		                      	<span aria-hidden="true">&times;</span>
		                    </button>
		                  </div>
		              @endif

	                  <form class="forms-sample" method="post" enctype="multipart/form-data" action="{{ url('admin/update-vendor-details/bank') }}">@csrf
	                  	<input type="hidden" name="id" value="{{ $vendorDetails['id'] }}">
	                    <div class="form-group">
	                      <label for="exampleInputUsername1">Vendor Username/Email</label>
	                      <input type="text" class="form-control" value="{{ Auth::guard('admin')->user()->email }}" readonly="">
	                    </div>
	                    <div class="form-group">
	                      <label for="account_holder_name">Account Holder Name</label>
	                      <input class="form-control" id="account_holder_name" name="account_holder_name" value="{{ $vendorDetails['account_holder_name'] }}" required="">
	                    </div>
	                    <div class="form-group">
	                      <label for="bank_name">Bank Name</label>
	                      <input type="text" class="form-control" id="bank_name" placeholder="Enter Shop Name" name="bank_name" value="{{ $vendorDetails['bank_name'] }}" required="">
	                    </div>
	                    <div class="form-group">
	                      <label for="account_number">Account Number</label>
	                      <input type="text" class="form-control" id="account_number" placeholder="Enter Shop Address" name="account_number" value="{{ $vendorDetails['account_number'] }}" required="">
	                    </div>
	                    <div class="form-group">
	                      <label for="bank_ifsc_code">Bank IFSC_Code</label>
	                      <input type="text" class="form-control" id="bank_ifsc_code" placeholder="Enter Shop City" name="bank_ifsc_code" value="{{ $vendorDetails['bank_ifsc_code'] }}" required="">
	                    </div>
	                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
	                    <button class="btn btn-light">Cancel</button>
	                  </form>
	                </div>
	              </div>
			    </div>
		  	</div>
  	  @endif
   </div>
   <!-- content-wrapper ends -->
   <!-- partial:partials/_footer.html -->
   @include('admin.layout.footer')
   <!-- partial -->
</div>

@endsection