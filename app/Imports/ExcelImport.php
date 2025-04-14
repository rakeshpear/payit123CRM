<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToArray;


class ExcelImport implements ToArray
{
    public $data;

    public function array(array $array)
    {
        $this->data = $array;
    }
}
