<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class MasterImportProject implements ToArray, WithHeadingRow
{
    /**
     * @param Array $rows
     */
    public function array(array $row)
    {
    }
}
