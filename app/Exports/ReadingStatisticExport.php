<?php

namespace App\Exports;

use App\Models\Reader;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ReadingStatisticExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $activities;
    protected $averageTGM;

    public function __construct($activities, $averageTGM)
    {
        $this->activities = $activities;
        $this->averageTGM = $averageTGM;
    }

    public function headings(): array
    {
        return [
            ['No', 'Nama Pembaca', 'Perhitungan TGM', '', '', 'TGM'],
            ['', '', 'TDM', 'TFM', 'TJB', ''],
        ];
    }

    public function map($row): array
    {
        static $rowNumber = 1;

        return [
            $rowNumber++,
            $row['reader_name'],
            $row['tdm'] . ' %',
            $row['tfm'] . ' %',
            $row['tjb'] . ' %',
            $row['tgm'] . ' %',
        ];
    }

    public function collection()
    {
        return collect($this->activities);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Merge cells for 'Perhitungan TGM'
                $sheet->mergeCells('A1:A2');
                $sheet->mergeCells('B1:B2');
                $sheet->mergeCells('F1:F2');
                $sheet->mergeCells('C1:E1');

                // Format Heading (Bold)
                $sheet->getStyle('A1:F2')->getFont()->setBold(true);

                // Center alignment for heading
                $sheet->getStyle('A1:F2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A1:F2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                // Alignment center untuk value kolom C, D, E, dan F (TDM, TFM, TJB, TGM)
                $sheet->getStyle('C3:F'.$sheet->getHighestRow())->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // All borders
                $sheet->getStyle('A1:F'.($sheet->getHighestRow()))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                // Adjust column width
                $sheet->getColumnDimension('A')->setWidth(5);
                $sheet->getColumnDimension('B')->setWidth(40);
                $sheet->getColumnDimension('C')->setWidth(10);
                $sheet->getColumnDimension('D')->setWidth(10);
                $sheet->getColumnDimension('E')->setWidth(10);
                $sheet->getColumnDimension('F')->setWidth(10);

                // Menambahkan footer dengan nilai rata-rata TGM
                $lastRow = $sheet->getHighestRow() + 1;
                $averageTDM = $this->activities->avg('tdm') ;
                $averageTFM = $this->activities->avg('tfm');
                $averageTJB = $this->activities->avg('tjb');

                // Merge kolom A dan B untuk footer
                $sheet->mergeCells("A{$lastRow}:B{$lastRow}");
                $sheet->setCellValue("A{$lastRow}", 'Rata-rata');

                // Isi kolom C, D, E, F dengan hasil rata-rata
                $sheet->setCellValue("C{$lastRow}", number_format($averageTDM, 2) . ' %');
                $sheet->setCellValue("D{$lastRow}", number_format($averageTFM, 2) . ' %');
                $sheet->setCellValue("E{$lastRow}", number_format($averageTJB, 2) . ' %');
                $sheet->setCellValue("F{$lastRow}", $this->averageTGM . ' %');

                // Footer styling
                $sheet->getStyle("A{$lastRow}:F{$lastRow}")->getFont()->setBold(true);
                $sheet->getStyle("A{$lastRow}:F{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Border untuk footer
                $sheet->getStyle("A{$lastRow}:F{$lastRow}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            }
        ];
    }
}
