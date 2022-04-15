<?php

namespace Database\Seeders;
use App\Models\vendorsBankDetails;

use Illuminate\Database\Seeder;

class VendorsBankDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendorsBankDetailsRecords = [
        	['id'=>1, 'vendor_id'=>1, 'account_holder_name'=>'john Cena','bank_name'=>'ICICI', 'account_number'=>'0909372837463', 'bank_ifsc_code'=>'23746923'],
        ];

        vendorsBankDetails::insert($vendorsBankDetailsRecords);
    }
}
