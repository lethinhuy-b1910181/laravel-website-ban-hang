<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('customers')->insert([
           
            [
                'name' => 'Nguyễn Ngọc Nhi',
                'email' => 'lethinhuy4848@gmail.com',
                'status' => 'active',
                'password' => bcrypt('password')
            ],
            [
                'name' => 'Trần Bạch',
                'email' => 'lethinhuy1005@gmail.com',
                'status' => 'active',
                'password' => bcrypt('password')
            ]
        ]);
    }
}
