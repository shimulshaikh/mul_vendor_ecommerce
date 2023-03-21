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
            ['id'=>1, 'name'=>'Admin', 'type'=>'admin','vendor_id'=>1, 'mobile'=>'01912342125', 'email'=>'admin@gmail.com', 'password'=>'$2y$10$UlMYZs65IHSu4pXi026QYucxpt7gIXIRd.iZoJ8F//947o7Cmbfr.', 'image'=>'', 'status'=>1],

        	['id'=>2, 'name'=>'John', 'type'=>'vendor','vendor_id'=>1, 'mobile'=>'01912342125', 'email'=>'john@gmail.com', 'password'=>'$2y$10$UlMYZs65IHSu4pXi026QYucxpt7gIXIRd.iZoJ8F//947o7Cmbfr.', 'image'=>'', 'status'=>1],
        ];

        Admin::insert($adminRecords);
    }
}
