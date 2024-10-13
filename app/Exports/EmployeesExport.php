<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class EmployeesExport implements FromCollection, WithTitle, WithEvents, WithStyles
{
    protected $employees;
    protected $title;

    public function __construct(Collection $employees, string $title)
    {
        $this->employees = $employees;
        $this->title = $title;
    }

    public function collection(): Collection
    {
        return $this->employees;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 16]],
            2 => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            \Maatwebsite\Excel\Events\AfterSheet::class => function (\Maatwebsite\Excel\Events\AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->mergeCells('A1:D1');
                $sheet->setCellValue('A1', $this->title);
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                $sheet->setCellValue('A2', 'Nama');
                $sheet->setCellValue('B2', 'Nik');
                $sheet->setCellValue('C2', 'Jabatan');
                $sheet->setCellValue('D2', 'NoHp');

                $sheet->getStyle('A2:D2')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFA0A0A0'],
                    ],
                ]);

                $row = 3;
                foreach ($this->employees as $employee) {
                    $sheet->setCellValue("A{$row}", $employee->name);
                    $sheet->setCellValue("B{$row}", $employee->nik);
                    $sheet->setCellValue("C{$row}", $employee->role ?? '-');
                    $sheet->setCellValue("D{$row}", $employee->phonenumber);
                    $row++;
                }

                $lastRow = $row - 1;
                $sheet->getStyle("A1:D{$lastRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                foreach (range('A', 'D') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}
