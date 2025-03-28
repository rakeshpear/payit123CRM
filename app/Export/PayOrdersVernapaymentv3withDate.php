<?php


namespace App\Export;

use App\Models\PayOrdersVernapaymentv3;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Carbon\Carbon;

class PayOrdersVernapaymentv3withDate implements FromCollection, WithHeadings,WithEvents
{

       use Exportable;

       private $s_date,$e_date;

       public function __construct($s_date,$e_date) 
       {
        
          $this->s_date = $s_date;
          $this->e_date = $e_date;


       }
    

       public function collection()
       {
        return PayOrdersVernapaymentv3::whereDate('orderDate','>=',$this->s_date)->whereDate('orderDate','<=',$this->e_date)->get();
       }

       public function headings(): array
       {
              return [

                     'orderId','fullName','email','phone','amount','currency','country','invoiceNumber','comments','orderStatus','orderMessage','transactionID','orderDate','orderPaid','paymentMethod','report','interchange','fee_scheme_fee','service_fee','card_type','bank_name','descriptor','mid','merchantName','merchant_name','chargeback Date','card Num','included in reprot','meps profile id','chargeback_callbackurl','refund_callbackurl','fraud_callbackurl','chargeback_callback','fraud_callback','refund_callback'
              ];
       }

       public function registerEvents(): array
       {
               return [
                   AfterSheet::class    => function(AfterSheet $event) {
          
                       $event->sheet->getDelegate()->getStyle('A1:AI1')
                                       ->getFont()
                                       ->setBold(true);
          
                   },
               ];
       }
}
