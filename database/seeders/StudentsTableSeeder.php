<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Student;
use App\Models\Transaction;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = DB::table('users')->where('role_id', 5)->get();
        $counter = 1;
        $price = 4000000;
        $installment = 4;
        foreach($users as $user){
            $batch = DB::table('batch')->where('id', $counter)->first();
            $location = DB::table('location')->where('id', $counter)->first();
            $student = new Student;
            $student->name = "Student ".$counter;
            $student->email = "student".$counter."@gmail.com";
            $student->batch_id = $batch->id;
            $student->location_id = $location->id;
            $student->address = "Alamat student ".$counter;
            $student->phone_number = "08228349498".$counter;
            $student->status = 1;
            $student->save();

            $transaction = new Transaction;
            $transaction->student_id = $student->id;
            $transaction->total_price = $price;
            $transaction->installment = $installment;
            $transaction->ongoing_installment = 1;
            $transaction->save();

            $date = Carbon::now();
            for($i = 1; $i <= $installment; $i++){
                if($i > 1){
                    $date->addMonths($i - 1);
                }
                DB::table('payment')->insert([
                    'transaction_id' => $transaction->id,
                    'nominal' => $price / $installment,
                    'installment' => $i,
                    'start_date' => $date->startOfMonth()->format('Y-m-d'),
                    'end_date' => $date->lastOfMonth()->format('Y-m-d'),
                ]);
                $date = Carbon::now();
            }
            $counter++;
        }
    }
}
