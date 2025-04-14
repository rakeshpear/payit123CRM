<?php

namespace App\Exports\JPY;

use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class JpyTransactionsExport implements FromCollection, WithTitle, WithHeadings, ShouldAutoSize, WithEvents
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
                'Transaction ID',
                'Order Date',
                'Order Status',
                'Currency',
                'Acquirer_Status',
                'Amount',
                'Fee',
                'Before RR + TRX Fee',
                'RR',
                'Final Payable',
                'Invoice Number',
                'Net after PSP & Client',
                'Limegrove 50%',
                'PPY Share 50%',
                'Bank Name',

            ]; // Default headers
        }
    }

    public function title(): string
    {
        return 'Processing JPY';
    }

    public function registerEvents(): array
    {
        return [

            BeforeSheet::class => function (BeforeSheet $event) {
                // Set the main heading before the first row
                $sheet = $event->sheet->getDelegate();

                // Merge cells for the main heading
                $sheet->mergeCells('A1:K1'); // Adjust the range based on your data

                $sheet->getColumnDimension('A')->setWidth(30); // Adjust width as needed
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
                $highestColumn = $sheet->getHighestColumn();

                $clientMDRValue_session = Session::get('clientMDRValue');
                $clientTRXValue_session = Session::get('clientTrxValue');
                $clientRollingReserve_session = Session::get('clientRollingReserve');

                // Fee column Calculation
                for ($row = 3; $row <= $highestRow; $row++) {

                    $amountCell = "G$row"; // Amount Column
                    $feeCell = "H$row"; // 'Fee (MDR + Trx Fee)' column 
                    $beforeRRCell = "I$row";
                    $rrCell = "J$row";
                    $finalPayableCell = "K$row";

                    $sheet->setCellValue($feeCell, "=(($amountCell * $clientMDRValue_session)/100)");
                    $sheet->setCellValue($beforeRRCell, "=($amountCell - $feeCell - $clientTRXValue_session)");
                    $sheet->setCellValue($rrCell, "=(($amountCell * $clientRollingReserve_session)/100 )");
                    $sheet->setCellValue($finalPayableCell, "=($beforeRRCell - $rrCell )");
                }

                // Calculate the last row
                $lastRow = $sheet->getHighestRow() + 2;
                // $lastValueRow = $sheet->getHighestRow();

                // Add the totals to the bottom
                $sheet->setCellValue("B{$lastRow}", 'TOTAL'); // Label in the second column (adjust as needed)
                $sheet->setCellValue("G{$lastRow}", "=SUM(G3:G" . ($lastRow - 1) . ")");
                $sheet->setCellValue("H{$lastRow}", "=SUM(H3:H" . ($lastRow - 1) . ")");
                $sheet->setCellValue("I{$lastRow}", "=SUM(I3:I" . ($lastRow - 1) . ")");
                $sheet->setCellValue("J{$lastRow}", "=SUM(J3:J" . ($lastRow - 1) . ")");
                $sheet->setCellValue("K{$lastRow}", "=SUM(K3:K" . ($lastRow - 1) . ")");
                $sheet->setCellValue("M{$lastRow}", "=SUM(M3:M" . ($lastRow - 1) . ")");
                $sheet->setCellValue("N{$lastRow}", "=SUM(N3:N" . ($lastRow - 1) . ")");
                $sheet->setCellValue("O{$lastRow}", "=SUM(O3:O" . ($lastRow - 1) . ")");
                $sheet->setCellValue("P{$lastRow}", "=SUM(P3:P" . ($lastRow - 1) . ")");
                $sheet->setCellValue("Q{$lastRow}", "=SUM(Q3:Q" . ($lastRow - 1) . ")");
                $sheet->setCellValue("R{$lastRow}", "=SUM(R3:R" . ($lastRow - 1) . ")");
                $sheet->setCellValue("S{$lastRow}", "=SUM(S3:S" . ($lastRow - 1) . ")");
                $sheet->setCellValue("T{$lastRow}", "=SUM(T3:T" . ($lastRow - 1) . ")");
                $sheet->setCellValue("U{$lastRow}", "=SUM(U3:U" . ($lastRow - 1) . ")");
                $sheet->setCellValue("V{$lastRow}", "=SUM(V3:V" . ($lastRow - 1) . ")");
                $sheet->setCellValue("W{$lastRow}", "=SUM(W3:W" . ($lastRow - 1) . ")");
                // $sheet->setCellValue("X{$lastRow}", "=SUM(X3:X" . ($lastRow - 1) . ")");
                // $sheet->setCellValue("Y{$lastRow}", "=SUM(Y3:Y" . ($lastRow - 1) . ")");

                // $sheet->setCellValue("AB{$lastRow}", "=SUM(N" . ($lastRow) . ":AA" . ($lastRow) . "  )");


                // $totalPspValue_JPY = $sheet->getCell("Z{$lastRow}")->getCalculatedValue();
                // Session::put('totalPspValue_JPY', $totalPspValue_JPY);



                // Optionally style the totals row
                $sheet->getStyle("B{$lastRow}:Y{$lastRow}")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFFF00'], // Yellow background
                    ],
                ]);

                // Apply background color and bold font to the header row (1st row)
                $sheet->getStyle('A2:Z2')->applyFromArray([
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

                foreach (range('A', 'Z') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }

                // Apply background color and bold font to the header row (1st row)
                $sheet->getStyle("Z{$lastRow}:Z{$lastRow}")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => 'FFFFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'FF0000FF',
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ]
                ]);


                $columns = ['G', 'H', 'I', 'J', 'K', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

                foreach ($columns as $column) {
                    $event->sheet->getDelegate()
                        ->getStyle("{$column}2:{$column}10000") // Adjust row range as needed
                        ->getNumberFormat()
                        ->setFormatCode('0.00');
                }

                $columns1 = ['F', 'H', 'I', 'J', 'K'];

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
            },
        ];
    }
}
