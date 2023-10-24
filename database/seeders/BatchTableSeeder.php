<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BatchTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('batch')->insert([
            'name' => 'Batch 1',
            'start_date' => '2023-10-20',
            'end_Date' => '2023-11-20',
        ]);
        DB::table('batch')->insert([
            'name' => 'Batch 2',
            'start_date' => '2023-11-20',
            'end_Date' => '2023-12-20',
        ]);
    }
}
