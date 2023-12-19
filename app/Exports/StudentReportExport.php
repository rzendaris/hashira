<?php

namespace App\Exports;

use Auth;
use App\Material;
use Illuminate\Contracts\View\View;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

use App\Repositories\Material\EloquentMaterialRepository;

class StudentReportExport implements FromView, WithStyles, WithColumnWidths
{
    protected $materialRepository;

    public function __construct(EloquentMaterialRepository $materialRepository) {
        $this->materialRepository = $materialRepository;
    }

    public function view(): View
    {
        return view('menu.exports.students-report', [
            'materials' => $this->materialRepository->fetchMaterialByUserBatch(Auth::user()->id)->get()
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        $count_data = $this->materialRepository->fetchMaterialByUserBatch(Auth::user()->id)->count();
        $sheet->getStyle(5)->getFont()->setBold(true);
        $sheet->getStyle(5)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle(5)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $full_rows = $count_data * 2 + 5;

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
}
