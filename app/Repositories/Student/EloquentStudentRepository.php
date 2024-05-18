<?php

namespace App\Repositories\Student;

use Helper;
use Auth;
use Carbon\Carbon;
use App\Models\Student;
use App\Models\Transaction;
use App\Models\Payment;
use App\Models\User;
use App\Http\Requests\StudentRequest;
use App\Http\Requests\StudentUpdateRequest;
use App\Traits\Upload;

class EloquentStudentRepository implements StudentRepository
{
    use Upload;

    public function fetchStudent()
    {
        $query_builder = Student::with(['batch', 'report', 'teacher'])->where('status', 1);
        return $query_builder;
    }

    public function fetchStudentById($id)
    {
        $student = $this->fetchStudent()->where('id', $id)->first();
        return $student;
    }

    public function fetchStudentFilterByTeacher($user)
    {
        $student = $this->fetchStudent();
        if($user->location_id !== NULL){
            $student = $student->where('teacher_id', $user->id);
        }
        return $student;
    }

    public function insertStudent(StudentRequest $request)
    {
        $teacher = User::where('id', $request->teacher_id)->first();
        $student = new Student;
        $student->name = $request->name;
        $student->email = $request->email;
        $student->location_id = $teacher->location_id;
        $student->batch_id = $request->batch_id;
        $student->teacher_id = $teacher->id;
        $student->address = $request->address;
        $student->phone_number = $request->phone_number;
        $student->gender = $request->gender;
        $student->birth_date = $request->birth_date;
        $student->education = $request->education;
        $student->city = $request->city;
        $student->program = $request->program;
        $student->jft_status = $request->jft_status;
        $student->ssw_status = $request->ssw_status;
        if ($request->hasFile('ktp_file')) {
            $student->ktp_file = $this->UploadFile($request->file('ktp_file'), 'ktp');
        }
        if ($request->hasFile('ijazah_file')) {
            $student->ijazah_file = $this->UploadFile($request->file('ijazah_file'), 'ijazah');
        }
        $student->save();

        $price = $student->location->price;

        if($request->pay_later){
            $price = $price / 2;
        }

        $transaction = new Transaction;
        $transaction->student_id = $student->id;
        $transaction->total_price = $student->location->price;
        $transaction->installment = $request->installment;
        $transaction->ongoing_installment = 1;
        $transaction->save();

        $date = Carbon::now();
        for($i = 1; $i <= $request->installment; $i++){
            if($i > 1){
                $date->addMonths($i - 1);
            }
            $payment = new Payment;
            $payment->transaction_id = $transaction->id;
            $payment->nominal = $price / $request->installment;
            $payment->installment = $i;
            $payment->start_date = $date->startOfMonth()->format('Y-m-d');
            $payment->end_date = $date->lastOfMonth()->format('Y-m-d');
            $payment->save();

            $date = Carbon::now();
        }

        if($request->pay_later){
            $payment = new Payment;
            $payment->transaction_id = $transaction->id;
            $payment->nominal = $price;
            $payment->installment = $request->installment + 1;
            $payment->save();
        }
        return $student;
    }

    public function updateStudent(StudentUpdateRequest $request)
    {
        $student = $this->fetchStudentById($request->id);
        $student->jft_status = $request->jft_status;
        $student->ssw_status = $request->ssw_status;

        if ($request->filled('name')){
            $student->name = $request->name;
        }
        if ($request->filled('email')){
            $student->email = $request->email;
        }
        if ($request->filled('phone_number')){
            $student->phone_number = $request->phone_number;
        }
        if ($request->filled('address')){
            $student->address = $request->address;
        }
        if ($request->hasFile('ktp_file')) {
            $student->ktp_file = $this->UploadFile($request->file('ktp_file'), 'ktp');
        }
        if ($request->hasFile('ijazah_file')) {
            $student->ijazah_file = $this->UploadFile($request->file('ijazah_file'), 'ijazah');
        }
        $student->save();
        return $student;
    }

    public function deleteStudent($id)
    {
        $student = $this->fetchStudentById($id);
        if(isset($student)){
            $student->delete();
        }
        return $student;
    }
}