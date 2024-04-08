<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            [
                'name' => 'Admin Sản Phẩm',
                'email' => 'sanpham@gmail.com',
                'type' =>  2,
                'status' => 'active',
                'password' => bcrypt('password')
            ],
            
            
        ]);
    }
}
