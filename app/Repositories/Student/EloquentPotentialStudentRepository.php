<?php

namespace App\Repositories\Student;

use Helper;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\Traits\Upload;
use App\Imports\ImportPotentialStudent;

use App\Models\PotentialStudent;
use App\Http\Requests\PotentialStudentRequest;

class EloquentPotentialStudentRepository implements PotentialStudentRepository
{
    use Upload;

    public function fetchPotentialStudent()
    {
        $query_builder = PotentialStudent::where('status', 1);
        return $query_builder;
    }

    public function insertPotentialStudent(PotentialStudentRequest $request)
    {
        Excel::import(new ImportPotentialStudent, $request->file('bulk_file')->store('files'));
        return;
    }
}