<?php

namespace App\Exports;

use Auth;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;

use Illuminate\Contracts\View\View;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;

use App\Repositories\Material\EloquentMaterialRepository;
use App\Repositories\Report\EloquentStudentReportRepository;

class StudentReportResultExport implements FromView, WithStyles, WithColumnWidths, WithTitle
{
    protected $materialRepository;
    protected $studentReportRepository;
    protected $batch;

    public function __construct(EloquentMaterialRepository $materialRepository, EloquentStudentReportRepository $studentReportRepository, $batch) {
        $this->materialRepository = $materialRepository;
        $this->studentReportRepository = $studentReportRepository;
        $this->batch = $batch;
    }

    public function view(): View
    {
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($this->batch->start_date, $interval, $this->batch->end_date);
        $date_range = [];
        $students = [];

        foreach ($period as $dt) {
            $key = $dt->format("F").' '.$dt->format("Y");
            $date_range[$key][] = $dt->format("d F Y");

            $students_report = $this->studentReportRepository->fetchStudentReport()
            ->whereRelation('student', 'batch_id', $this->batch->id)
            ->whereRelation('student', 'location_id', Auth::user()->location_id);

            $weekend = array('Sunday', 'Saturday');

            if(in_array($dt->format("l"), $weekend)){
                $arr_data = array(
                    'score' => 'W'
                );
            } else {
                $arr_data = array(
                    'score' => '-'
                );
            }
            
            foreach($students_report->get() as $student_report){
                $students_data = $students_report->whereRelation('student', 'id', $student_report->id)->whereDate('created_at', $dt->format("Y-m-d"))->first();
                if(isset($students_data)){
                    $arr_data = array(
                        'score' => $student_report->score
                    );
                }
            }
            $students['students'][$student_report->student->name][] = $arr_data;
        }

        return view('menu.exports.students-report-result', [
            'date_range' => $date_range,
            'students' => $students
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        $count_student = $this->studentReportRepository->fetchStudentReport()
            ->whereRelation('student', 'batch_id', $this->batch->id)
            ->whereRelation('student', 'location_id', Auth::user()->location_id)->count();
        
        $sheet->getStyle(8)->getFont()->setBold(true);
        $sheet->getStyle(8)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle(8)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle(9)->getFont()->setBold(true);
        $sheet->getStyle(9)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle(9)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        for($i = 1; $i <= $count_student; $i++){
            $sheet->getStyle($i + 9)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle($i + 9)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        $letters = array();
        $letter = 'A';
        while ($letter !== $sheet->getHighestDataColumn()) {
            $column_exception = array('A', 'B', 'C');
            $column_name = $letter++;
            if (!in_array($column_name, $column_exception)) {
                $sheet->getColumnDimension($column_name)->setWidth(5);
            }
        }
    }

    public function columnWidths(): array
    {
        return [
            'A' => 7,
            'B' => 35,
            'C' => 25
        ];
    }

    public function title(): string
    {
        return 'NILAI';
    }
}
