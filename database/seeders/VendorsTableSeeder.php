<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vendor;

class VendorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendorRecords = [
        	['id'=>1, 'name'=>'John', 'address'=>'D-1212','city'=>'Dhaka', 'state'=>'Dhaka', 'country'=>'Bangladesh', 'pincode'=>'1212', 'mobile'=>'01938372837', 'email'=>'john@gmail.com', 'status'=>0],
        ];

        Vendor::insert($vendorRecords);
    }
}
