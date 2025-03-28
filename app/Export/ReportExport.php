<?php


namespace App\Export;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportExport implements FromQuery, WithHeadings
{

       use Exportable;

       private $columns = ['id','name','email','created_at'];
       public function query()
       {
        return User::query()->select($this->columns);
       }

       public function headings(): array
       {

        return $this->columns;
       }
}
