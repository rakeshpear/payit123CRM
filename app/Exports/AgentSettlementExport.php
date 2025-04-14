<?php


namespace App\Exports;

use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AgentSettlementExport implements WithTitle, ShouldAutoSize, WithEvents, FromArray
{
    protected $agentSettlementValues;
    protected $fileHeading;

    public function __construct(array $agentSettlementValues, $fileHeading)
    {
        $this->agentSettlementValues = $agentSettlementValues;
        $this->fileHeading = $fileHeading;
    }

    public function array(): array
    {
        return $this->agentSettlementValues;
    }

    public function title(): string
    {
        return 'Agents Settlement';
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
                // $lastRow = $sheet->getHighestRow() + 4;

                $totalPspValue_USD = Session::get('totalPspValue_USD');
                $totalPspValue_EUR = Session::get('totalPspValue_EUR');
                $crypto_charge = Session::get('cryptoCharge');

                // Add the totals to the bottom
                $sheet->setCellValue("A15", 'Convert to USD/USDt'); // Label in the second column (adjust as needed)
                $sheet->setCellValue("B15", "=SUM(B11:B14)");
                $sheet->setCellValue("C15", "=SUM(C11:C14)");
                $sheet->setCellValue("D15", "=SUM(D11:D14)");

                $convert_to_usdt_payit123 = $sheet->getCell('B15')->getCalculatedValue();

                $B16Value = $sheet->getCell('B16')->getValue();
                $B17Value = $sheet->getCell('B17')->getValue();
                $B18Value = $sheet->getCell('B18')->getValue();
                $B19Value = $sheet->getCell('B19')->getValue();
                $B20Value = $sheet->getCell('B20')->getValue();
                $B21Value = $sheet->getCell('B21')->getValue();
                $B22Value = $sheet->getCell('B20')->getValue();

                $B23Value = $convert_to_usdt_payit123 + $B16Value + $B17Value + $B18Value + $B19Value + $B20Value - $B21Value + $B22Value;

                $sheet->setCellValue("B23", $B23Value);
                $sheet->getStyle('B23')->getFill()->setFillType('solid')->getStartColor()->setARGB('FFFF00');
                $sheet->getStyle('B23')->getFont()->setBold(true);

                $convert_to_usdt_camitrade = $sheet->getCell('C15')->getCalculatedValue();

                $C16Value = $sheet->getCell('C16')->getValue();
                $C17Value = $sheet->getCell('C17')->getValue();
                $C18Value = $sheet->getCell('C18')->getValue();
                $C19Value = $sheet->getCell('C19')->getValue();
                $C20Value = $sheet->getCell('C20')->getValue();
                $C21Value = $sheet->getCell('C21')->getValue();
                $C22Value = $sheet->getCell('C20')->getValue();

                $C23Value = $convert_to_usdt_camitrade + $C16Value + $C17Value + $C18Value + $C19Value + $C20Value - $C21Value + $C22Value;

                $sheet->setCellValue("C23", $C23Value);
                $sheet->getStyle('C23')->getFill()->setFillType('solid')->getStartColor()->setARGB('FFFF00');
                $sheet->getStyle('C23')->getFont()->setBold(true);

                // dd($convert_to_usdt, $totalPspValue_USD, $totalPspValue_EUR);

                $s2sValue = $convert_to_usdt_payit123 - ($totalPspValue_USD + ($totalPspValue_EUR * 1.03));
                $pyys2s = $s2sValue / 2;



                $sheet->setCellValue("A26", 'S2S'); // Label in the second column (adjust as needed)
                $sheet->setCellValue("B26", $s2sValue);
                $sheet->setCellValue("B27", $crypto_charge);

                $B26Value = $sheet->getCell('B26')->getValue();
                $B27Value = $sheet->getCell('B27')->getValue();

                $B28Value = $B26Value + $B27Value;

                $sheet->setCellValue("B28", $B28Value);
                $sheet->setCellValue("B30", $pyys2s);
                $sheet->setCellValue("B32", $pyys2s);

                $sheet->setCellValue("B36", $crypto_charge);

                $partialRefunds_fee_total = Session::get('partialRefunds_fee_total');
                $chargebacks_fee_total = Session::get('chargebacks_fee_total');
                $refunds_fee_total = Session::get('refunds_fee_total');

                $cbsValue = $partialRefunds_fee_total + $chargebacks_fee_total + $refunds_fee_total;

                $sheet->setCellValue("B38", $cbsValue);

                // Apply bold style to the first row
                $sheet->getStyle('A2:D2')->getFont()->setBold(true);
                $sheet->getStyle('B4:D4')->getFont()->setBold(true);

                // Set background color for the first row
                $sheet->getStyle('A2')->getFill()->setFillType('solid')->getStartColor()->setARGB('FFFF00'); // Yellow background 


                $sheet->getStyle('A15:D15')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => '00000000'],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'FFFF00',
                        ],
                    ],
                ]);

                $sheet->getStyle('A4:D4')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 18,
                        'color' => ['argb' => '00000000'],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'FFE6F1FA',
                        ],
                    ],
                ]);

                $columns = ['B', 'C', 'D'];

                foreach ($columns as $column) {
                    $event->sheet->getDelegate()
                        ->getStyle("{$column}4:{$column}10000") // Adjust row range as needed
                        ->getNumberFormat()
                        ->setFormatCode('0.00');
                }
            },
        ];
    }
}
