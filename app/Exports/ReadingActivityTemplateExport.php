<?php

namespace App\Exports;

use App\Models\ReadingActivity;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ReadingActivityTemplateExport implements WithHeadings, FromArray, WithColumnFormatting
{
    public function headings(): array
    {
        return [
            'reader_name',
            'book_title',
            'reading_date',
            'reading_duration',
        ];
    }

    public function array(): array
    {
        return [
            ['Baruna Bima Fatkhurohman', 'Dikala Senja', '2024-10-01', '01:30:00'],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_DATE_YYYYMMDD2,
            'D' => '[h]:mm:ss',
        ];
    }
}
