<?php


namespace App\Exports\GBP;

use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ChargebackTransactionsGbpExport implements FromCollection, WithTitle, WithHeadings, ShouldAutoSize, WithEvents
{
    protected $data;
    protected $fileHeading;

    public function __construct($data, $fileHeading)
    {
        $this->data = $data;
        $this->fileHeading = $fileHeading;
    }

    public function collection()
    {
        return collect($this->data ?? []);
    }

    /**
     * Return the headers for the Excel file.
     */
    public function headings(): array
    {

        if (!empty($this->data) && isset($this->data[0])) {
            // Use the keys of the first row as the headers
            return array_keys((array) $this->data[0]);
        } else {
            return [
                'No',
                'Dispute Date',
                'PSP Code',
                'Acquirer_Status',
                'Amount',
                'Chargeback Fee',
                'Total Amount',
                'Client Name',
                'Blocked?',
                'Invoice Number',
                'Bank Name'
            ]; // Default headers
        }
    }

    public function title(): string
    {
        return 'Chargeback GBP';
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

                // Calculate the last row
                $lastRow = $sheet->getHighestRow() + 2;
                // $lastValueRow = $sheet->getHighestRow();

                // Add the totals to the bottom
                $sheet->setCellValue("B{$lastRow}", 'TOTAL');
                $sheet->setCellValue("E{$lastRow}", "=SUM(E3:E" . ($lastRow - 1) . ")");
                $sheet->setCellValue("G{$lastRow}", "=SUM(G3:G" . ($lastRow - 1) . ")");

                // Optionally style the totals row
                $sheet->getStyle("B{$lastRow}:G{$lastRow}")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFFF00'], // Yellow background
                    ],
                ]);

                // Apply background color and bold font to the header row (1st row)
                $sheet->getStyle('A2:K2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => '00000000'],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'FFFFFF00',
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ]
                ]);

                $columns1 = ['D', 'F', 'G'];

                foreach ($columns1 as $column) {
                    $event->sheet->getDelegate()
                        ->getStyle("{$column}3:{$column}{$lastRow}")->applyFromArray([

                            'fill' => [
                                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                'startColor' => [
                                    'argb' => 'FFFF00',
                                ],
                            ],

                        ]);
                }


                $columns = ['E', 'G'];

                foreach ($columns as $column) {
                    $event->sheet->getDelegate()
                        ->getStyle("{$column}2:{$column}10000") // Adjust row range as needed
                        ->getNumberFormat()
                        ->setFormatCode('0.00');
                }
            },
        ];
    }
}
