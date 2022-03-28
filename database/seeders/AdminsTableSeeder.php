<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRecords = [
        	['id'=>1, 'name'=>'Super Admin', 'type'=>'superadmin','vendor_id'=>0, 'mobile'=>'01912342125', 'email'=>'superadmin@gmail.com', 'password'=>'$2y$10$UlMYZs65IHSu4pXi026QYucxpt7gIXIRd.iZoJ8F//947o7Cmbfr.', 'image'=>'', 'status'=>1],
        ];

        Admin::insert($adminRecords);
    }
}
