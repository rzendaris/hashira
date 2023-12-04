<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('location')->insert([
            'name' => 'Jatimekar',
            'price' => 8000000
        ]);
        DB::table('location')->insert([
            'name' => 'Temanggung',
            'price' => 5000000
        ]);
    }
}
