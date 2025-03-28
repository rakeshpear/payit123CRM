<?php


namespace App\Export;

use App\Models\PayOrdersAcqV1;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Report implements FromQuery, WithHeadings
{

       use Exportable;

       // private $columns = ['id','name','email','created_at'];
       public function query()
       {
        return PayOrdersAcqV1::get();
       }

       public function headings(): array
       {

        // return $this->columns;
       }
}
