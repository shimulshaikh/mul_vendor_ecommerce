<?php

namespace Database\Seeders;
use App\Models\vendorsBusinessDetails;

use Illuminate\Database\Seeder;

class VendorsBusinessDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendorsBusinessDetailsRecords = [
        	['id'=>1, 'vendor_id'=>1, 'shop_name'=>'john Electronics store','shop_address'=>'1234-SCF', 'shop_city'=>'Dhaka', 'shop_state'=>'Dhaka', 'shop_country'=>'1212', 'shop_pincode'=>'11001', 'shop_mobile'=>'01938372837','shop_website'=>'sitemekars.com','shop_email'=>'john@gmail.com','address_proof'=>'Passport','address_proof_image'=>'test.jpg','business_license_number'=>'12365732','gst_number'=>'44345323','pan_number'=>'74638939'],
        ];

        vendorsBusinessDetails::insert($vendorsBusinessDetailsRecords);
    }
}
