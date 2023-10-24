<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'User Super Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
            'role_id' => 1
        ]);
        DB::table('users')->insert([
            'name' => 'User Finance',
            'email' => 'finance@gmail.com',
            'password' => bcrypt('finance'),
            'role_id' => 2
        ]);
        DB::table('users')->insert([
            'name' => 'User Teacher',
            'email' => 'teacher@gmail.com',
            'password' => bcrypt('teacher'),
            'role_id' => 3
        ]);
        DB::table('users')->insert([
            'name' => 'User Admission 1',
            'email' => 'admission1@gmail.com',
            'password' => bcrypt('admission'),
            'role_id' => 4
        ]);
        DB::table('users')->insert([
            'name' => 'User Admission 2',
            'email' => 'admission2@gmail.com',
            'password' => bcrypt('admission'),
            'role_id' => 4
        ]);
    }
}
