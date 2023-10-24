<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'role_name' => 'Super Admin',
            'role_slug' => 'super',
        ]);
        DB::table('roles')->insert([
            'role_name' => 'Finance',
            'role_slug' => 'finance',
        ]);
        DB::table('roles')->insert([
            'role_name' => 'Teacher',
            'role_slug' => 'teacher',
        ]);
        DB::table('roles')->insert([
            'role_name' => 'Admission',
            'role_slug' => 'admission',
        ]);
    }
}
