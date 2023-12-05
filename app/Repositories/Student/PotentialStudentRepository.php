<?php

namespace App\Repositories\Student;
use App\Http\Requests\PotentialStudentRequest;

interface PotentialStudentRepository {
    public function fetchPotentialStudent();
    public function insertPotentialStudent(PotentialStudentRequest $request);
}
