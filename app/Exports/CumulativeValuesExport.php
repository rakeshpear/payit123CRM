<?php


namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;


class CumulativeValuesExport implements WithTitle, ShouldAutoSize, WithEvents, FromArray
{
    protected $cumulativeValues;
    protected $fileHeading;

    public function __construct(array $cumulativeValues, $fileHeading)
    {
        $this->cumulativeValues = $cumulativeValues;
        $this->fileHeading = $fileHeading;
    }

    public function array(): array
    {
        return $this->cumulativeValues;
    }

    public function title(): string
    {
        return 'Cumulatives';
    }

    public function registerEvents(): array
    {

        return [

            BeforeSheet::class => function (BeforeSheet $event) {
                // Set the main heading before the first row
                $sheet = $event->sheet->getDelegate();

                // Merge cells for the main heading
                $sheet->mergeCells('A1:K1');

                $sheet->getColumnDimension('A')->setWidth(30);
                $sheet->getColumnDimension('A')->setAutoSize(true);

                // Set the main heading value
                $sheet->setCellValue('A1', $this->fileHeading);

                // Apply styling for the main heading
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 16,
                        'color' => ['argb' => '00000000'],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'FFE6F1FA', // Red color for background
                        ],
                    ],
                ]);

                // Set the height of the first row (main heading row)
                $sheet->getRowDimension(1)->setRowHeight(30);

                // Apply text wrapping and alignment for A1
                $sheet->getStyle('A1')->getAlignment()->setWrapText(false);
            },

            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                $highestRow = $sheet->getHighestRow();

                // $rowsToSetNull = [3, 9, 15];

                foreach ($sheet->getColumnIterator('B') as $column) {
                    foreach ($column->getCellIterator() as $cell) {
                        $rowNumber = $cell->getRow();
                        if (empty($cell->getValue())) {
                            $cell->setValue('0.00');
                        }
                    }
                }

                // Apply bold style to the first row
                $sheet->getStyle('A2:B2')->getFont()->setBold(true);

                // Set background color for the first row
                $sheet->getStyle('A2:B2')->getFill()->setFillType('solid')->getStartColor()->setARGB('FFFF00'); // Yellow background 
                // $sheet->getStyle('A3:B3')->getFill()->setFillType('solid')->getStartColor()->setARGB('FFADD8E6');
                // $sheet->getStyle('A9:B9')->getFill()->setFillType('solid')->getStartColor()->setARGB('FFADD8E6');
                // $sheet->getStyle('A15:B15')->getFill()->setFillType('solid')->getStartColor()->setARGB('FFADD8E6');

                // $sheet->getStyle('A18:B18')->applyFromArray([
                //     'font' => [
                //         'bold' => true,
                //         'size' => 18,
                //         'color' => ['argb' => '00000000'],
                //     ],
                //     'alignment' => [
                //         'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                //         'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                //     ],
                //     'fill' => [
                //         'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                //         'startColor' => [
                //             'argb' => 'FFE6F1FA',
                //         ],
                //     ],
                // ]);
                
                $sheet->getStyle("B2:B{$highestRow}") // Apply to column B
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_NUMBER_00);

                
            },
        ];
    }
}
