<?php

namespace App\Repositories\Report;
use App\Http\Requests\StudentReportRequest;

interface StudentReportRepository {
    public function fetchStudentReport();
    public function insertStudentReport(StudentReportRequest $request);
}
