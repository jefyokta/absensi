<?php

namespace App\Exports;

use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class AbsensiExport implements FromView, WithTitle, WithStyles, WithEvents
{
    protected $employees;
    protected $dates;
    protected $month;
    protected $year;
    protected $subdivision;

    public function __construct($employees, $dates, $month, $year,$subdivision)
    {
        $this->employees = $employees;
        $this->dates = $dates;
        $this->month = $month;
        $this->year = $year;
        $this->subdivision = $subdivision;
    }

    public function view(): View
    {
        return view('dashboard.reports.excel', [
            'employees' => $this->employees,
            'dates' => $this->dates,
            'month' => $this->month,
            'year' => $this->year,
            'subdivision' => $this->subdivision,

        ]);
    }

    public function title(): string
    {
        return "Laporan_{$this->month}_{$this->year}";
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 16],
                'alignment' => ['horizontal' => 'center'],
            ],
            3 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'color' => ['rgb' => 'FFE5B4']
                ],
            ],
            4 => [
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'color' => ['rgb' => 'D3EAFD']
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function ($event) {
                $sheet = $event->sheet->getDelegate();


                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center',
                    ],
                ];


                $lastColumnIndex = 3 + count($this->dates) * 2;
                $lastColumn = Coordinate::stringFromColumnIndex($lastColumnIndex);

                $rowCount = count($this->employees) + 4;


                $sheet->getStyle("A1:{$lastColumn}{$rowCount}")
                      ->applyFromArray($styleArray);


                foreach (range(1, $lastColumnIndex) as $column) {
                    $sheet->getColumnDimension(Coordinate::stringFromColumnIndex($column))->setAutoSize(true);
                }


                $sheet->getRowDimension(1)->setRowHeight(30);
                $sheet->getRowDimension(3)->setRowHeight(25);
                $sheet->getRowDimension(4)->setRowHeight(20);

                for ($row = 5; $row <= $rowCount; $row++) {
                    $sheet->getRowDimension($row)->setRowHeight(-1);
                }
            },
        ];
    }
}
