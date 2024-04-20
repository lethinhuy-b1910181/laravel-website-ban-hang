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
                'name' => 'Lê Thị Như Ý',
                'email' => 'yb1910181@student.ctu.edu.vn',
                'status' => 'active',
                'password' => bcrypt('password')
            ],
            // [
            //     'name' => 'Nguyễn Ngọc Nhi',
            //     'email' => 'lethinhuy4848@gmail.com',
            //     'status' => 'active',
            //     'password' => bcrypt('password')
            // ],
            // [
            //     'name' => 'Trần Bạch',
            //     'email' => 'lethinhuy1005@gmail.com',
            //     'status' => 'active',
            //     'password' => bcrypt('password')
            // ]
        ]);
    }
}
