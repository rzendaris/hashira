<?php

namespace App\Repositories\Student;
use App\Http\Requests\StudentRequest;
use App\Http\Requests\StudentUpdateRequest;

interface StudentRepository {
    public function fetchStudent();
    public function fetchStudentById($id);
    public function fetchStudentFilterByTeacher($user);
    public function insertStudent(StudentRequest $request);
    public function updateStudent(StudentUpdateRequest $request);
    public function deleteStudent($id);
}
