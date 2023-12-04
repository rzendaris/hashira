<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\PotentialStudent;

class PotentialStudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $student = new PotentialStudent;
        $student->name = "Potential Student";
        $student->email = "pot.student@gmail.com";
        $student->address = "Alamat Potential student";
        $student->phone_number = "08228349498";
        $student->gender = "Laki-Laki";
        $student->birth_date = "2000-01-01";
        $student->education = "SMA";
        $student->city = "Jakarta";
        $student->save();
    }
}
