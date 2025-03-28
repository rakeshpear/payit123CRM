<?php

namespace App\Exports;

use App\Models\ExportClientTransaction;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

class ClientTransactionExport implements FromCollection, WithEvents, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        return ExportClientTransaction::select('transaction_id','transaction_date','status','currency','amount','fee','before_roll_rec','rolling_rec_per','payable_to_clnt','PSP_fees','net_after_PSP','PP_frnd','majestic','limegrove','invoice')->get();
    }

    public function headings(): array
    {
        return ["Transaction ID", "Date", "Acquirer status", "Amount", "Currency", "Fee", "Payable to client before rolling res.", "Rolling Reserve", "Payable to client", "PSP Fees", "Net after PSP & Client", "PP Friend", "Majestic", "Payit123 share", "Invoice"];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();
                
                // Loop through each column and set auto width
                foreach ($sheet->getColumnIterator() as $column) {
                    $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
                }

                $event->sheet->getStyle($event->sheet->calculateWorksheetDimension())->getAlignment()->setHorizontal('center');
                
                $event->sheet->getDelegate()->getStyle('A1:P1')->getFont()->setBold(true); // Adjust font size of the title
            },
        ];
    }
}
