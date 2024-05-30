<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

use App\Exports\StudentReportExport;
use App\Exports\StudentReportResultExport;
use App\Repositories\Material\EloquentMaterialRepository;
use App\Repositories\Report\EloquentStudentReportRepository;
use App\Repositories\Student\EloquentStudentRepository;

class StudentReportExcel implements WithMultipleSheets
{
    use Exportable;

    protected $materialRepository;
    protected $studentReportRepository;
    protected $studentRepository;
    protected $batch;

    public function __construct(
        EloquentMaterialRepository $materialRepository,
        EloquentStudentReportRepository $studentReportRepository, 
        EloquentStudentRepository $studentRepository, 
        $batch)
    {
        $this->materialRepository = $materialRepository;
        $this->studentReportRepository = $studentReportRepository;
        $this->studentRepository = $studentRepository;
        $this->batch = $batch;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [
            new StudentReportExport($this->materialRepository, $this->batch),
            new StudentReportResultExport($this->materialRepository, $this->studentReportRepository, $this->studentRepository, $this->batch),
        ];

        return $sheets;
    }
}
