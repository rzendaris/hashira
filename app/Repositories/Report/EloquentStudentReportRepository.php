<?php

namespace App\Repositories\Report;

use Helper;
use Auth;
use Carbon\Carbon;
use App\Models\StudentReport;
use App\Http\Requests\StudentReportRequest;

class EloquentStudentReportRepository implements StudentReportRepository
{

    public function fetchStudentReport()
    {
        $query_builder = StudentReport::with(['material', 'student'])->where('status', 1);
        return $query_builder;
    }

    public function insertStudentReport(StudentReportRequest $request)
    {
        $report = new StudentReport();
        $report->student_id = $request->id;
        $report->material_id = $request->material_id;
        $report->score = $request->score;
        $report->save();
        return $report;
    }
}