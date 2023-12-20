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

class StudentReportExport implements FromView, WithStyles, WithColumnWidths, WithTitle
{
    protected $materialRepository;
    protected $batch;

    public function __construct(EloquentMaterialRepository $materialRepository, $batch) {
        $this->materialRepository = $materialRepository;
        $this->batch = $batch;
    }

    public function view(): View
    {
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($this->batch->start_date, $interval, $this->batch->end_date);
        $date_range = [];

        foreach ($period as $dt) {
            $array_data = array(
                'date' => $dt->format("d F Y"),
                'material' => $this->materialRepository->fetchMaterialByUserBatch(Auth::user()->id)->whereDate('created_at', $dt->format("Y-m-d"))->first()
            );
            $date_range[] = $array_data;
        }
        return view('menu.exports.students-report', [
            'materials' => $this->materialRepository->fetchMaterialByUserBatch(Auth::user()->id)->get(),
            'date_range' => $date_range
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($this->batch->start_date, $interval, $this->batch->end_date);

        $sheet->getStyle(5)->getFont()->setBold(true);
        $sheet->getStyle(5)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle(5)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $full_rows = iterator_count($period) * 2 + 5;

        $sheet->getStyle('A6:E'.$full_rows)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A6:E'.$full_rows)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->getStyle('B5')->getAlignment()->setWrapText(true);

        $sheet->getStyle('A:B')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 14,
            'B' => 25,
            'C' => 55,
            'D' => 45,
            'E' => 55,
        ];
    }

    public function title(): string
    {
        return 'REPORT';
    }
}
