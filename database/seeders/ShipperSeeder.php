<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class ShipperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('shippers')->insert([
           
            [
                'name' => 'Shipper Miền Nam',
                'email' => 'shippermn@gmail.com',
                'status' => 1,
                'password' => bcrypt('password')
            ],
            [
                'name' => 'Shipper Miền Bắc',
                'email' => 'shippermb@gmail.com',
                'status' => 1,
                'password' => bcrypt('password')
            ],
            [
                'name' => 'Shipper Miền Trung',
                'email' => 'shippermt@gmail.com',
                'status' => 1,
                'password' => bcrypt('password')
            ],
        ]);
    }
}
